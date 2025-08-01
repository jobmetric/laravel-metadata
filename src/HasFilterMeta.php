<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasFilterMeta
 *
 * This trait provides dynamic filtering capability based on metadata for any Eloquent model.
 * It checks for metadata input in the HTTP request and applies conditional join and where clauses
 * to the query builder accordingly.
 *
 * Typically used to allow filtering models via polymorphic metadata key-value pairs in APIs or admin panels.
 *
 * Example usage:
 * ```php
 * $query = Model::query();
 * $this->queryFilterMetadata($query, Model::class);
 * ```
 *
 * @package JobMetric\Metadata
 */
trait HasFilterMeta
{
    /**
     * Applies dynamic filtering to a query based on metadata sent via HTTP request.
     *
     * This method:
     * - Checks if a `metadata` key exists in the request and contains valid key-value pairs.
     * - Joins the metadata table using a polymorphic relation on the given model.
     * - Applies `where` clauses to match the requested metadata keys and values.
     *
     * @param Builder $query The Eloquent query builder instance (passed by reference).
     * @param string $className The fully-qualified class name of the model being filtered (used in polymorphic type matching).
     * @param string $primaryColumn The column name used as the primary identifier (default: `id`).
     *
     * @return void
     */
    public function queryFilterMetadata(Builder &$query, string $className, string $primaryColumn = 'id'): void
    {
        if (request()->filled('metadata')) {
            $metadata = request()->input('metadata');

            $metadata_table = config('metadata.tables.meta');

            $flagMeta = false;
            foreach ($metadata as $meta) {
                if (!is_null($meta) && $meta !== '') {
                    $flagMeta = true;
                    break;
                }
            }

            if ($flagMeta) {
                $query->join($metadata_table . ' as meta', 'meta.metaable_id', '=', $primaryColumn)
                    ->where('meta.metaable_type', '=', $className);

                $query->where(function (Builder $q) use ($metadata) {
                    foreach ($metadata as $meta_key => $meta_value) {
                        if (!is_null($meta_value) && $meta_value !== '') {
                            $q->where(function () use ($q, $meta_key, $meta_value) {
                                $q->where('meta.key', $meta_key);
                                $q->where('meta.value', $meta_value);
                            });
                        }
                    }
                });
            }
        }
    }
}
