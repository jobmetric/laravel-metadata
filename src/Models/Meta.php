<?php

namespace JobMetric\Metadata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int id
 * @property int metaable
 * @property int metaable_id
 * @property string metaable_type
 * @property string key
 * @property mixed value
 * @property boolean is_json
 */
class Meta extends Model
{
    use HasFactory;

    protected $fillable = [
        'metaable_id',
        'metaable_type',
        'key',
        'value',
        'is_json'
    ];

    protected $casts = [
        'key' => 'string',
        'is_json' => 'boolean'
    ];

    public function getTable()
    {
        return config('metadata.tables.meta', parent::getTable());
    }

    /**
     * metaable relationship
     *
     * @return MorphTo
     */
    public function metaable(): MorphTo
    {
        return $this->morphTo();
    }
}
