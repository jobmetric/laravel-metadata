<?php

namespace JobMetric\Metadata\Contracts;

/**
 * Interface MetaContract
 *
 * Defines the contract for Eloquent models that support metadata management.
 *
 * Implementing this interface requires the model to specify which metadata keys
 * are allowed to be used for storage and retrieval, providing a layer of
 * validation and security.
 *
 * @package JobMetric\Metadata
 */
interface MetaContract
{
    /**
     * Returns an array of allowed metadata keys that can be stored or accessed
     * on the implementing model.
     *
     * This method is used to whitelist valid metadata fields and prevent
     * unauthorized or unintended keys from being used.
     *
     * @return string[] List of allowed metadata keys.
     */
    public function metadataAllowFields(): array;
}
