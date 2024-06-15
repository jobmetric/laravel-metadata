<?php

namespace JobMetric\Metadata;

/**
 * @property array meta
 */
trait Metaable
{
    protected array $meta = [];

    /**
     * metadata allow fields.
     *
     * @return array
     */
    public function metadataAllowFields(): array
    {
        return $this->meta;
    }

    /**
     * Set metadata.
     *
     * @param array $meta
     * @return static
     */
    public function setMeta(array $meta): static
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get metadata.
     *
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }
}
