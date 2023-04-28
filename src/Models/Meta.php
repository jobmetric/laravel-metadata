<?php

namespace JobMetric\Metadata\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
