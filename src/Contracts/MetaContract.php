<?php

namespace JobMetric\Metadata\Contracts;

interface MetaContract
{
    /**
     * metadata allow fields.
     *
     * @return array
     */
    public function metadataAllowFields(): array;
}
