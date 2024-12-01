<?php

namespace JobMetric\Metadata;

use Closure;
use JobMetric\Metadata\Metadata\MetadataBuilder;
use Throwable;

/**
 * Trait HierarchicalServiceType
 *
 * @package JobMetric\PackageCore
 */
trait MetadataServiceType
{
    /**
     * The metadata custom fields
     *
     * @var array $metadata
     */
    protected array $metadata = [];

    /**
     * Set Metadata.
     *
     * @param Closure|array $callable
     *
     * @return static
     * @throws Throwable
     */
    public function metadata(Closure|array $callable): static
    {
        if($callable instanceof Closure){
            $callable($builder = new MetadataBuilder);

            $this->metadata[] = $builder->build();
        }else{
            foreach ($callable as $metadata) {
                $builder = new MetadataBuilder;

                $builder->customField($metadata['customField'] ?? null);

                if (isset($metadata['hasFilter']) && $metadata['hasFilter'] === true) {
                    $builder->hasFilter();
                }

                $this->metadata[] = $builder->build();
            }
        }

        $this->setTypeParam('metadata', $this->metadata);

        return $this;
    }
}
