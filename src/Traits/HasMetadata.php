<?php

namespace JobMetric\Metadata\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use JobMetric\Metadata\Models\Meta;

/**
 * @method morphMany(string $class, string $string)
 */
trait HasMetadata
{
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
     * @param string  $key
     *
     * @return MorphMany
     */
    public function metaableKey(string $key): MorphMany
    {
        return $this->metaable()->where('key', $key);
    }
}
