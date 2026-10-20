# Committed business outcomes

Classes are registered by the package provider alongside legacy events. Keys ending in `.committed` are safe automation outcomes; earlier event signatures, payloads and timing are preserved. Only scalar identifiers are exposed.

| Event class | Key | Payload properties |
| --- | --- | --- |
| `JobMetric\Metadata\Events\Metadata\MetadataStoreCommittedEvent` | `metadata.metadata.stored.committed` | `id: int|string` |
| `JobMetric\Metadata\Events\Metadata\MetadataDeleteCommittedEvent` | `metadata.metadata.deleted.committed` | `id: int|string` |

Schedule from the owning operation after successful persistence. Delivery waits for the owning connection outer commit and is discarded on rollback. No-op operations emit nothing. Native Laravel listeners are isolated individually; failures are logged with event key and exception class only. No models, raw inputs, credentials or translated content are included. This is synchronous delivery without durable outbox guarantees.
