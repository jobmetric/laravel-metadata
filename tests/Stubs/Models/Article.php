<?php

namespace JobMetric\Metadata\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JobMetric\Metadata\HasMeta;
use JobMetric\Metadata\Tests\Stubs\Factories\ArticleFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $status
 *
 * @method static create(string[] $array)
 */
class Article extends Model
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

    protected array $metadata = [
        'phone',
        'address',
    ];

    protected array $metadata_casts = [
        'title' => 'string',
        'status' => 'string',
    ];

    protected static function newFactory(): ArticleFactory
    {
        return ArticleFactory::new();
    }
}
