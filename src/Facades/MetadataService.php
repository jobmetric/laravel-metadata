<?php

namespace JobMetric\Metadata\Facades;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection|Model|null get(Model $model, string|null $key = null)
 * @method static Model store(Model $model, string $key, string|array|null $value = null)
 * @method static void delete(Model $model, string|null $key = null)
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
