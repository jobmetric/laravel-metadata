<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JobMetric\Metadata\Exceptions\ModelMetadataInterfaceNotFoundException;
use JobMetric\Metadata\Models\Meta;
use Throwable;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasMetadata
{
    /**
     * boot has metadata
     *
     * @return void
     * @throws Throwable
     */
    public static function bootHasMetadata(): void
    {
        static::retrieved(function ($model) {
            if(!in_array('JobMetric\Metadata\MetadataInterface', class_implements($model))) {
                throw new ModelMetadataInterfaceNotFoundException($model::class);
            }
        });
    }

    /**
     * The attributes that can be stored in the metadata table.
     *
     * @var array<string>
     */
    protected array $metadata = [];

    /**
     * set metadata field
     *
     * @param array $fields
     *
     * @return void
     */
    public function setMetadataFields(array $fields = []): void
    {
        $this->metadata = array_merge($this->metadata, $fields);
    }

    /**
     * get metadata field
     *
     * @return array
     */
    public function getMetadataFields(): array
    {
        return $this->metadata;
    }

    /**
     * metaable has many relationship
     *
     * @return MorphMany
     */
    public function metaable(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * scope key for select metaable relationship
     *
     * @param string $key
     *
     * @return MorphMany
     */
    public function metaableKey(string $key): MorphMany
    {
        return $this->metaable()->where('key', $key);
    }

    /**
     * scope has metadata
     *
     * @param Builder $query
     * @param string $key
     *
     * @return void
     */
    public function scopeHasMetadata(Builder $query, string $key): void
    {
        $query->whereHas('metaable', function (Builder $q) use ($key) {
            $q->where('key', $key);
        });
    }
}
