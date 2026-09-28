<?php

namespace JobMetric\Metadata\Support;

use Closure;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Trait HasMetadataType
 *
 * @package JobMetric\Metadata
 */
trait HasMetadataType
{
    /**
     * The metadata custom fields
     *
     * @var array $metadata
     */
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
        if ($callable instanceof Closure) {
            $callable($builder = new MetadataBuilder);

            $metadataItems = [$builder->build()];
        } else {
            $metadataItems = [];
            foreach ($callable as $metadata) {
                $builder = new MetadataBuilder;

                $builder->customField($metadata['customField'] ?? null);

                if (isset($metadata['hasFilter']) && $metadata['hasFilter'] === true) {
                    $builder->hasFilter();
                }

                $metadataItems[] = $builder->build();
            }
        }

        $this->appendTypeParam('metadata', $metadataItems);

        return $this;
    }

    /**
     * Get metadata.
     *
     * @return Collection
     */
    public function getMetadata(): Collection
    {
        return collect($this->getTypeParam('metadata', []));
    }
}
