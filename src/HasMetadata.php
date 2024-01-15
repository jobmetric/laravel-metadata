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
        if (!in_array('JobMetric\Metadata\Contracts\MetadataContract', class_implements(self::class))) {
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
    public function metaableKey(string $key): MorphMany
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
}
