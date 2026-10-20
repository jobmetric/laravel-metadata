<?php

namespace JobMetric\Metadata\Events\Metadata;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

/**
 * Describe a committed Metadata deleted outcome using allowlisted identifiers.
 */
readonly class MetadataDeleteCommittedEvent implements DomainEvent
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
        return 'metadata.metadata.deleted.committed';
    }

    /**
     * Describe the outcome for translated discovery interfaces.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::automation.metadata_deleted.group', 'metadata::automation.metadata_deleted.title', 'metadata::automation.metadata_deleted.description', 'fas fa-bolt', ['automation', 'committed', 'metadata']);
    }
}
