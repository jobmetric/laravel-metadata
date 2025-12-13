<?php

namespace JobMetric\Metadata\Events;

use Illuminate\Database\Eloquent\Model;
use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;
use JobMetric\Metadata\Models\Meta;

readonly class MetadataStoredEvent implements DomainEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Model $model,
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
        return 'metadata.stored';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::base.entity_names.metadata', 'metadata::base.events.metadata_stored.title', 'metadata::base.events.metadata_stored.description', 'fas fa-save', [
            'metadata',
            'storage',
            'management',
        ]);
    }
}
