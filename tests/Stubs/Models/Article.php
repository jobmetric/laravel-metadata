<?php

namespace JobMetric\Metadata\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JobMetric\Metadata\Contracts\MetaContract;
use JobMetric\Metadata\HasMeta;

/**
 * @property int $id
 * @property string $title
 * @property string $status
 *
 * @method static create(string[] $array)
 */
class Article extends Model implements MetaContract
{
    use HasFactory, HasMeta;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'status'
    ];
    protected $casts = [
        'title' => 'string',
        'status' => 'string',
    ];

    public function metadataAllowFields(): array
    {
        return [
            'description',
            'info'
        ];
    }
}
