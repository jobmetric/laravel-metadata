<?php

namespace JobMetric\Metadata\Events;

use Illuminate\Database\Eloquent\Model;

class MetadataForgetEvent
{
    public Model $model;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
