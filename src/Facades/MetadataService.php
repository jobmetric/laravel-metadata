<?php

namespace JobMetric\Metadata\Facades;

use Illuminate\Support\Facades\Facade;

/**
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
