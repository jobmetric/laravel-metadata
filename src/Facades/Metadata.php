<?php

namespace JobMetric\Metadata\Facades;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(Model $model, string|null $key = null)
 * @method static Model store(Model $model, string $key, string|array|null $value = null)
 * @method static void delete(Model $model, string|null $key = null)
 *
 * @see \JobMetric\Metadata\Metadata
 */
class Metadata extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Metadata';
    }
}
