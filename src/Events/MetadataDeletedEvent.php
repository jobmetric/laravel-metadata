<?php

namespace JobMetric\Metadata\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;
use JobMetric\Metadata\Models\Meta;

readonly class MetadataDeletedEvent implements DomainEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Meta $meta
    ) {
    }

    /**
     * Returns the stable technical key for the domain event.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'metadata.deleted';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::base.entity_names.metadata', 'metadata::base.events.metadata_deleted.title', 'metadata::base.events.metadata_deleted.description', 'fas fa-trash', [
            'metadata',
            'deletion',
            'management',
        ]);
    }
}
