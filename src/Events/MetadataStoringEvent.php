<?php

namespace JobMetric\Metadata\Events;

use Illuminate\Database\Eloquent\Model;

class MetadataStoringEvent
{
    public Model $model;
    public string $key;
    public array|string|bool|null $value;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $model, string $key, array|string|bool|null $value = null)
    {
        $this->model = $model;
        $this->key = $key;
        $this->value = $value;
    }
}
