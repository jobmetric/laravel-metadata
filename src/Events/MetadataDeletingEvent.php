<?php

namespace JobMetric\Metadata\Events;

use JobMetric\Metadata\Models\Meta;

class MetadataDeletingEvent
{
    public Meta $meta;

    /**
     * Create a new event instance.
     */
    public function __construct(Meta $meta)
    {
        $this->meta = $meta;
    }
}
