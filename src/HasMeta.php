<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JobMetric\Metadata\Events\MetadataForgetEvent;
use JobMetric\Metadata\Events\MetadataStoredEvent;
use JobMetric\Metadata\Exceptions\MetadataKeyNotFoundException;
use JobMetric\Metadata\Exceptions\ModelMetaableKeyNotAllowedFieldException;
use JobMetric\Metadata\Exceptions\ModelMetadataInterfaceNotFoundException;
use JobMetric\Metadata\Models\Meta;
use Throwable;

/**
 * @method morphMany(string $class, string $string)
 * @method metadataAllowFields()
 */
trait HasMeta
{
    /**
     * boot has metadata
     *
     * @return void
     * @throws Throwable
     */
    public static function bootHasMeta(): void
    {
        if (!in_array('JobMetric\Metadata\Contracts\MetaContract', class_implements(self::class))) {
            throw new ModelMetadataInterfaceNotFoundException(self::class);
        }
    }

    /**
     * metaable has many relationship
     *
     * @return MorphMany
     */
    public function metas(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * scope key for select metas relationship
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
     * scope has meta
     *
     * @param Builder $query
     * @param string $key
     *
     * @return void
     */
    public function scopeHasMeta(Builder $query, string $key): void
    {
        $query->whereHas('metaable', function (Builder $q) use ($key) {
            $q->where('key', $key);
        });
    }

    /**
     * scope has meta value
     *
     * @param Builder $query
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function scopeHasMetaValue(Builder $query, string $key, string $value): void
    {
        $query->whereHas('metaable', function (Builder $q) use ($key, $value) {
            $q->where('key', $key)->where('value', $value);
        });
    }

    /**
     * get metadata
     *
     * @param string|null $key
     *
     * @return mixed
     * @throws Throwable
     */
    public function getMetadata(string|null $key = null): mixed
    {
        if (is_null($key)) {
            $data = collect();

            $builder = $this->metas();
            foreach ($builder->get() as $item) {
                if ($item->is_json) {
                    $data->add(json_decode($item->value, true));
                } else {
                    $data->add($item->value);
                }
            }

            return $data;
        }

        $allowedFields = $this->metadataAllowFields();
        if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
            throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
        }

        /**
         * @var Meta $object
         */
        $object = $this->metaKey($key)->first();
        if ($object) {
            if ($object->is_json) {
                return json_decode($object->value, true);
            } else {
                return $object->value;
            }
        }

        throw new MetadataKeyNotFoundException($key);
    }

    /**
     * store metadata
     *
     * @param string $key
     * @param string|array|null $value
     *
     * @return static
     * @throws Throwable
     */
    public function storeMetadata(string $key, string|array|null $value = null): static
    {
        $allowedFields = $this->metadataAllowFields();
        if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
            throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
        }

        $model = $this->metas()->updateOrCreate([
            'key' => $key,
        ], [
            'value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value,
            'is_json' => is_array($value),
        ]);

        event(new MetadataStoredEvent($model, $key));

        return $this;
    }

    /**
     * forget metadata
     *
     * @param string|null $key
     *
     * @return static
     * @throws Throwable
     */
    public function forgetMetadata(string|null $key = null): static
    {
        if (!is_null($key)) {
            $allowedFields = $this->metadataAllowFields();
            if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
                throw new ModelMetaableKeyNotAllowedFieldException(self::class, $key);
            }

            $this->metaKey($key)->get()->each(function ($meta) {
                $meta->delete();

                event(new MetadataForgetEvent($meta));
            });
        } else {
            $this->metas()->get()->each(function ($meta) {
                $meta->delete();

                event(new MetadataForgetEvent($meta));
            });
        }

        return $this;
    }
}
