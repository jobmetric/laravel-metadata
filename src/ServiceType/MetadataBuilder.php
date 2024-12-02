<?php

namespace JobMetric\Metadata\ServiceType;

use Closure;
use Illuminate\Support\Traits\Macroable;
use JobMetric\CustomField\CustomField;
use JobMetric\CustomField\CustomFieldBuilder;
use JobMetric\CustomField\Exceptions\OptionEmptyLabelException;
use Throwable;

class MetadataBuilder
{
    use Macroable;

    /**
     * The metadata instances
     *
     * @var array $metadata
     */
    protected array $metadata;

    /**
     * The custom field instance.
     *
     * @var CustomField|null $customField
     */
    public ?CustomField $customField = null;

    /**
     * The has filter status.
     *
     * @var bool $hasFilter
     */
    public bool $hasFilter = false;

    /**
     * Set custom field.
     *
     * @param Closure $callable
     *
     * @return static
     */
    public function customField(Closure $callable): static
    {
        $callable($builder = new CustomFieldBuilder);

        $this->customField = $builder->build();

        $this->metadata[] = $this->customField;

        return $this;
    }

    /**
     * Set has filter.
     *
     * @return static
     */
    public function hasFilter(): static
    {
        $this->hasFilter = true;

        return $this;
    }

    /**
     * Build the metadata.
     *
     * @return Metadata
     * @throws Throwable
     */
    public function build(): Metadata
    {
        if (is_null($this->customField)) {
            throw new OptionEmptyLabelException;
        }

        $metadata = new Metadata($this->customField, $this->hasFilter);

        $this->metadata[] = $metadata;

        return $metadata;
    }

    /**
     * Execute the callback to build the metadata.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->metadata;
    }
}
