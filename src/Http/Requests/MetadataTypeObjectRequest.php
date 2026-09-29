<?php

namespace JobMetric\Metadata\Http\Requests;

use Illuminate\Support\Collection;
use JobMetric\Metadata\Support\Metadata;

/**
 * Add metadata definitions to a form request.
 */
trait MetadataTypeObjectRequest
{
    /**
     * Append validation rules for every registered metadata field.
     *
     * @param array<string, mixed> $rules
     * @param Collection<int, Metadata> $metadata
     *
     * @return void
     */
    public function renderMetadataFiled(array &$rules, Collection $metadata): void
    {
        $rules['metadata'] = 'array|sometimes';

        foreach ($metadata as $item) {
            $uniqName = $item->customField->params['uniqName'] ?? null;

            $rules['metadata.' . $uniqName] = $item->customField->validation ?? 'string|nullable|sometimes';
        }
    }

    /**
     * Append translated attribute names for every metadata field.
     *
     * @param array<string, string> $params
     * @param Collection<int, Metadata> $metadata
     *
     * @return void
     */
    public function renderMetadataAttribute(array &$params, Collection $metadata): void
    {
        foreach ($metadata as $item) {
            $uniqName = $item->customField->params['uniqName'];

            $params["metadata.$uniqName"] = trans($item->customField->label);
        }
    }
}
