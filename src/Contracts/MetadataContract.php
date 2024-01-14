<?php

namespace JobMetric\Metadata\Contracts;

interface MetadataContract
{
    /**
     * metadata allow fields.
     *
     * @return array
     */
    public function metadataAllowFields(): array;
}
