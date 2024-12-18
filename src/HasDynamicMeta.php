<?php

namespace JobMetric\Metadata;

use JobMetric\Metadata\ServiceType\Metadata;

/**
 * HasDynamicMeta
 *
 * @property static array $dynamicMeta
 */
trait HasDynamicMeta
{
    protected static array $dynamicMeta = [];

    /**
     * Boot Has Dynamic Metadata
     *
     * @return void
     */
    public static function bootHasDynamicMeta(): void
    {
        $serviceType = getServiceTypeClass(static::class);

        $types = $serviceType->getTypes();

        foreach ($types as $type) {
            $innerType = $serviceType->type($type);

            foreach ($innerType->getMetadata() as $metadata) {
                /**
                 * @var Metadata $metadata
                 */
                self::$dynamicMeta[$type][] = $metadata->customField->params['uniqName'];
            }
        }
    }

    /**
     * metadata allow fields.
     *
     * @return array
     */
    public function metadataAllowFields(): array
    {
        return self::$dynamicMeta[$this->{$this->dynamicMetaFieldTypeName()}] ?? [];
    }

    /**
     * meta filed type name.
     *
     * @return string
     */
    public function dynamicMetaFieldTypeName(): string
    {
        return 'type';
    }
}
