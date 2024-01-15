<?php

namespace JobMetric\Metadata\Events;

use Illuminate\Database\Eloquent\Model;

class MetadataStoredEvent
{
    public Model $model;
    public string $key;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $model, string $key)
    {
        $this->model = $model;
        $this->key = $key;
    }
}
