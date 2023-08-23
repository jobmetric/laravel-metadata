<?php

namespace JobMetric\Metadata;

interface MetadataInterface
{
    /**
     * allow metadata fields.
     *
     * @return array
     */
    public function allowMetadataFields(): array;
}
