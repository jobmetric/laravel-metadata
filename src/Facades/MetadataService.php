<?php

namespace JobMetric\Metadata\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(Model $model, string $key = null, string $locale = null)
 * @method static void store(Model $model, array $data = [])
 * @method static void delete(Model $model, string $locale = null)
 *
 * @see \JobMetric\Metadata\MetadataService
 */
class MetadataService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'MetadataService';
    }
}
