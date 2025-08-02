<?php

namespace JobMetric\Metadata\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Class Meta
 *
 * Represents a key-value metadata entry associated with any Eloquent model
 * via a polymorphic relation.
 *
 * This model is designed to store arbitrary metadata for models such as posts,
 * products, users, etc., allowing extensibility without altering their main table.
 * It supports complex data types by marking values as JSON-encoded.
 *
 * @package JobMetric\Metadata
 *
 * @property int $id The primary identifier of the metadata row.
 * @property string $metaable_type The class name of the related model.
 * @property int $metaable_id The ID of the related model instance.
 * @property string $key The name of the metadata key.
 * @property mixed $value The associated metadata value.
 * @property boolean $is_json Whether the value is stored as JSON.
 * @property Carbon $created_at The timestamp when this metadata was created.
 * @property Carbon $updated_at The timestamp when this metadata was last updated.
 *
 * @property-read Model|MorphTo $metaable The related Eloquent model.
 *
 * @method static Builder|Meta whereMetaableType(string $metaable_type)
 * @method static Builder|Meta whereMetaableId(int $metaable_id)
 * @method static Builder|Meta whereKey(string $key)
 * @method static Builder|Meta whereValue(mixed $value)
 * @method static Builder|Meta whereIsJson(bool $is_json)
 */
class Meta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'metaable_type',
        'metaable_id',
        'key',
        'value',
        'is_json'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metaable_type' => 'string',
        'metaable_id' => 'integer',
        'key' => 'string',
        'is_json' => 'boolean'
    ];

    /**
     * Override the table name using config.
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('metadata.tables.meta', parent::getTable());
    }

    /**
     * Get the parent metaable model (morph-to relation).
     *
     * @return MorphTo
     */
    public function metaable(): MorphTo
    {
        return $this->morphTo();
    }
}
