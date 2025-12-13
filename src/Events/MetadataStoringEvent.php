<?php

namespace JobMetric\Metadata\Events;

use Illuminate\Database\Eloquent\Model;
use JobMetric\EventSystem\Contracts\DomainEvent;
use JobMetric\EventSystem\Support\DomainEventDefinition;

readonly class MetadataStoringEvent implements DomainEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public Model $model,
        public string $key,
        public array|string|bool|null $value = null
    ) {
    }

    /**
     * Returns the stable technical key for the domain event.
     *
     * @return string
     */
    public static function key(): string
    {
        return 'metadata.storing';
    }

    /**
     * Returns the full metadata definition for this domain event.
     *
     * @return DomainEventDefinition
     */
    public static function definition(): DomainEventDefinition
    {
        return new DomainEventDefinition(self::key(), 'metadata::base.events.metadata_storing.group', 'metadata::base.events.metadata_storing.title', 'metadata::base.events.metadata_storing.description', 'fas fa-save', [
            'metadata',
            'storage',
            'management',
        ]);
    }
}
