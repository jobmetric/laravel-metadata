<?php

namespace JobMetric\Metadata\Events\Metadata;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

/**
 * Describe a committed Metadata created outcome using allowlisted identifiers.
 */
readonly class MetadataStoreCommittedEvent implements DomainEvent
{
    /**
     * Capture identifiers without models, input values or credentials.
     *
     * @param int|string $id
     *
     * @return void
     */
    public function __construct(
        public int|string $id
    ) {
    }

    /**
     * Return the stable key used by automation consumers.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'metadata.metadata.stored.committed';
    }

    /**
     * Describe the outcome for translated discovery interfaces.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::automation.metadata_stored.group', 'metadata::automation.metadata_stored.title', 'metadata::automation.metadata_stored.description', 'fas fa-bolt', ['automation', 'committed', 'metadata']);
    }
}
