<?php

namespace JobMetric\Metadata;

/**
 * @property array metaType
 */
trait MetaableWithType
{
    protected array $metaType = [];

    /**
     * metadata allow fields.
     *
     * @return array
     */
    public function metadataAllowFields(): array
    {
        return $this->getMeta($this->{$this->getMetaFieldTypeName()});
    }

    /**
     * get meta filed type name.
     *
     * @return string
     */
    public function getMetaFieldTypeName(): string
    {
        return 'type';
    }

    /**
     * Set metadata.
     *
     * @param string $type
     * @param array $meta
     *
     * @return static
     */
    public function setMeta(string $type, array $meta): static
    {
        $this->metaType[$type] = $meta;

        return $this;
    }

    /**
     * Get metadata by type.
     *
     * @param string $type
     *
     * @return array
     */
    public function getMetaType(string $type): array
    {
        return $this->metaType[$type];
    }

    /**
     * Get metadata keys by type.
     *
     * @param string $type
     *
     * @return array
     */
    public function getMeta(string $type): array
    {
        return array_keys($this->metaType[$type]);
    }
}
