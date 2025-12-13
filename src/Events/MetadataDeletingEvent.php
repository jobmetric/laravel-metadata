<?php

namespace JobMetric\Metadata\Events;

use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;
use JobMetric\Metadata\Models\Meta;

readonly class MetadataDeletingEvent implements DomainEvent
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
        return 'metadata.deleting';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::base.events.metadata_deleting.group', 'metadata::base.events.metadata_deleting.title', 'metadata::base.events.metadata_deleting.description', 'fas fa-trash', [
            'metadata',
            'deletion',
            'management',
        ]);
    }
}
