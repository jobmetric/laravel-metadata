<?php

namespace JobMetric\Metadata\Http\Requests;

use Illuminate\Support\Collection;
use JobMetric\Metadata\Typeify\Metadata;

trait MetadataTypeObjectRequest
{
    public function renderMetadataFiled(
        array      &$rules,
        Collection $metadata,
    ): void
    {
        $rules['metadata'] = 'array|sometimes';

        foreach ($metadata as $item) {
            /**
             * @var Metadata $item
             */
            $uniqName = $item->customField->params['uniqName'] ?? null;

            $rules['metadata.' . $uniqName] = $item->customField->validation ?? 'string|nullable|sometimes';
        }
    }

    public function renderMetadataAttribute(
        array      &$params,
        Collection $metadata
    ): void
    {
        foreach ($metadata as $item) {
            /**
             * @var Metadata $item
             */
            $uniqName = $item->customField->params['uniqName'];

            $params["metadata.$uniqName"] = trans($item->customField->label);
        }
    }
}
