<?php

namespace JobMetric\Metadata\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $key
 * @property mixed $value
 * @property mixed $is_json
 */
class MetadataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            $this->key => ($this->is_json) ? json_decode($this->value, true) : $this->value
        ];
    }
}
