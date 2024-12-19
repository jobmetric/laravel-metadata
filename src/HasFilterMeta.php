<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasFilterMeta
 *
 * @package JobMetric\Metadata
 */
trait HasFilterMeta
{
    /**
     * Query filter Metadata
     *
     * @param Builder $query
     * @param string $className
     * @param string $primaryColumn
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
                if (!is_null($meta) && $meta != '') {
                    $flagMeta = true;
                    break;
                }
            }

            if ($flagMeta) {
                $query->join($metadata_table . ' as m', 'm.metaable_id', '=', $primaryColumn)
                    ->where('m.metaable_type', '=', $className);

                $query->where(function (Builder $q) use ($metadata) {
                    foreach ($metadata as $meta_key => $meta_value) {
                        if (!is_null($meta_value) && $meta_value != '') {
                            $q->where(function () use ($q, $meta_key, $meta_value) {
                                $q->where('m.key', $meta_key);
                                $q->where('m.value', $meta_value);
                            });
                        }
                    }
                });
            }
        }
    }
}
