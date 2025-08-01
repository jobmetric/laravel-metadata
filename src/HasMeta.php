<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use JobMetric\Metadata\Events\MetadataDeletedEvent;
use JobMetric\Metadata\Events\MetadataDeletingEvent;
use JobMetric\Metadata\Events\MetadataStoredEvent;
use JobMetric\Metadata\Events\MetadataStoringEvent;
use JobMetric\Metadata\Exceptions\MetadataKeyNotFoundException;
use JobMetric\Metadata\Exceptions\ModelMetaableKeyNotAllowedFieldException;
use JobMetric\Metadata\Models\Meta;
use Throwable;

/**
 * Trait HasMeta
 *
 * Adds metadata functionality to Eloquent models via morphMany relation.
 * Allows storing, retrieving, querying, and managing arbitrary metadata
 * using key-value pairs, while optionally respecting allowed metadata keys.
 *
 * @property-read Collection<int, Meta> $metas
 * @property-read Collection $metadataCache
 *
 * @method static Builder|static hasMetaKey(string $key)
 *
 * @package JobMetric\Metadata
 */
trait HasMeta
{
    /**
     * Metadata whitelist. Use ['*'] to allow all keys.
     *
     * @var array
     */
    private array $baseMetadata = ['*'];

    /**
     * Temporarily holds metadata passed through the model attributes.
     *
     * @var array
     */
    private array $innerMeta = [];

    /**
     * Appends 'metadata' to fillable attributes during model construction.
     *
     * @return void
     * @throws Throwable
     */
    public function initializeHasMeta(): void
    {
        if (hasPropertyInClass($this, 'metadata')) {
            $this->baseMetadata = $this->metadata;
        }

        $this->mergeFillable(['metadata']);
    }

    /**
     * Registers model events to handle metadata processing.
     *
     * @return void
     * @throws Throwable
     */
    public static function bootHasMeta(): void
    {
        $checkerClosure = function (Model $model) {
            if (isset($model->attributes['metadata'])) {
                $keys = array_keys($model->attributes['metadata']);
                if (!empty($diff = array_diff($keys, $model->baseMetadata)) && !in_array('*', $model->baseMetadata)) {
                    throw new MetadataKeyNotFoundException($diff);
                }

                $model->innerMeta = $model->attributes['metadata'];
                unset($model->attributes['metadata']);
            }
        };

        static::saving($checkerClosure);

        $savingAndUpdatingClosure = function ($model) {
            foreach ($model->innerMeta as $metaKey => $metaValue) {
                $model->storeMetadata($metaKey, $metaValue);
            }

            $model->innerMeta = [];
        };

        static::saved($savingAndUpdatingClosure);

        static::deleted(function ($model) {
            if (!in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model->metas()->delete();
            }
        });

        if (in_array(SoftDeletes::class, class_uses_recursive(static::class))) {
            static::deleted(function ($model) {
                $model->metas()->delete();
            });
        }
    }

    /**
     * Returns the morphMany relationship for metadata.
     *
     * @return MorphMany
     */
    public function metas(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * Filters the metadata relation by key.
     *
     * @param string $key
     *
     * @return MorphMany
     */
    public function metaKey(string $key): MorphMany
    {
        return $this->metas()->where('key', $key);
    }

    /**
     * Query scope: filter models that have a specific meta key.
     *
     * @param Builder $query
     * @param string $key
     *
     * @return Builder
     */
    public function scopeHasMetaKey(Builder $query, string $key): Builder
    {
        return $query->whereHas('metas', function (Builder $q) use ($key) {
            $q->where('key', $key);
        });
    }

    /**
     * Retrieves metadata value(s). If key is null, returns all metadata as collection.
     *
     * @param string|null $key
     * @param array|string|bool|null $default
     *
     * @return mixed
     * @throws Throwable
     */
    public function getMetadata(?string $key = null, array|string|bool|null $default = null): mixed
    {
        if (is_null($key)) {
            return $this->metas->mapWithKeys(function (Meta $meta) {
                return [$meta->key => $meta->is_json ? json_decode($meta->value, true) : $meta->value];
            });
        }

        if (!(in_array('*', $this->baseMetadata) || in_array($key, $this->baseMetadata))) {
            throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
        }

        $object = $this->metaKey($key)->first();
        if ($object) {
            return $object->is_json ? json_decode($object->value, true) : $object->value;
        }

        return $default;
    }

    /**
     * Stores or updates a metadata value by key.
     *
     * @param string $key
     * @param array|string|bool|null $value
     *
     * @return static
     * @throws Throwable
     */
    public function storeMetadata(string $key, array|string|bool|null $value = null): static
    {
        if (!(in_array('*', $this->baseMetadata) || in_array($key, $this->baseMetadata))) {
            throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
        }

        event(new MetadataStoringEvent($this, $key, $value));

        $model = $this->metas()->updateOrCreate([
            'key' => $key,
        ], [
            'value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value,
            'is_json' => is_array($value),
        ]);

        event(new MetadataStoredEvent($this, $model));

        return $this;
    }

    /**
     * Stores multiple metadata key-value pairs in a batch.
     *
     * @param array $metas The array should be in the format ['key' => 'value', ...].
     *
     * @return static
     * @throws Throwable
     */
    public function storeMetadataBatch(array $metas): static
    {
        foreach ($metas as $key => $value) {
            $this->storeMetadata($key, $value);
        }

        return $this;
    }

    /**
     * Deletes metadata by key or clears all metadata.
     *
     * @param string|null $key
     *
     * @return static
     * @throws Throwable
     */
    public function forgetMetadata(?string $key = null): static
    {
        if (!is_null($key)) {
            if (!(in_array('*', $this->baseMetadata) || in_array($key, $this->baseMetadata))) {
                throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
            }

            $this->metaKey($key)->get()->each(function ($meta) {
                event(new MetadataDeletingEvent($meta));

                $meta->delete();

                event(new MetadataDeletedEvent($meta));
            });
        } else {
            $this->metas()->get()->each(function ($meta) {
                event(new MetadataDeletingEvent($meta));

                $meta->delete();

                event(new MetadataDeletedEvent($meta));
            });
        }

        return $this;
    }

    /**
     * Checks if the model has a specific metadata key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasMetadata(string $key): bool
    {
        return $this->hasMetaKey($key)->exists();
    }

    /**
     * Returns all metadata as key-value pairs.
     *
     * @return Collection
     */
    public function getMetadataByValue(): Collection
    {
        return $this->metas->mapWithKeys(function (Meta $meta) {
            return [$meta->key => $meta->is_json ? json_decode($meta->value, true) : $meta->value];
        });
    }

    /**
     * Returns the allowed metadata keys for the model.
     *
     * @return string[]
     */
    public function getMetaKeys(): array
    {
        if (in_array('*', $this->baseMetadata)) {
            return ['*'];
        }

        return $this->baseMetadata;
    }

    /**
     * Sets the allowed metadata keys for the model.
     *
     * @param array $meta
     *
     * @return void
     */
    public function mergeMeta(array $meta): void
    {
        if (in_array('*', $this->baseMetadata)) {
            unset($this->baseMetadata[array_search('*', $this->baseMetadata)]);
        }

        $this->baseMetadata = array_merge($this->baseMetadata, $meta);

        // Ensure uniqueness and reset the keys
        $this->baseMetadata = array_values(array_unique($this->baseMetadata));
    }

    /**
     * Removes a metadata key from the allowed list.
     *
     * @param string $key
     *
     * @return void
     * @throws Throwable
     */
    public function removeMetaKey(string $key): void
    {
        if (in_array($key, $this->baseMetadata)) {
            unset($this->baseMetadata[$key]);
        } else {
            throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
        }

        if (empty($this->baseMetadata)) {
            $this->baseMetadata = ['*'];
        }
    }
}
