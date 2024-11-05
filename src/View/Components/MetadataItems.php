<?php

namespace JobMetric\Metadata\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Throwable;

class MetadataItems extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $values = [],
        public array $items = [],
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @throws Throwable
     */
    public function render(): View|Closure|string
    {
        return $this->view('metadata::components.metadata-items');
    }

}
