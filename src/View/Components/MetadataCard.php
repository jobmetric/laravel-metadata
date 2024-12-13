<?php

namespace JobMetric\Metadata\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Throwable;

class MetadataCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Collection|null $items = null,
        public array $values = [],
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
        return $this->view('metadata::components.metadata-card');
    }

}
