<?php

namespace JobMetric\Metadata\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use JobMetric\Metadata\Models\Meta;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasMetadata
{
    /**
     * metadata has many relationship
     *
     * @return MorphMany
     */
    public function metadata(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metaable');
    }

    /**
     * scope key for select metadata relationship
     *
     * @param Builder $builder
     * @param string  $key
     *
     * @return Builder
     */
    public function scopeMetadataKey(Builder $builder, string $key): Builder
    {
        return $builder->where('key', $key);
    }
}
