<?php

namespace JobMetric\Metadata\Http\Requests;

trait MetadataTypeObjectRequest
{
    public function renderMetadataFiled(
        array &$rules,
        array $object_type,
    ): void
    {
        if (isset($object_type['metadata'])) {
            $rules['metadata'] = 'array|sometimes';
            foreach ($object_type['metadata'] as $metadata_key => $metadata_value) {
                $rules['metadata.' . $metadata_key] = $metadata_value['validation'] ?? 'string|nullable|sometimes';
            }
        }
    }
}
