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
     * The attributes that can be stored in the metadata table.
     *
     * @var array<string>
     */
    protected array $metadata = [];

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
