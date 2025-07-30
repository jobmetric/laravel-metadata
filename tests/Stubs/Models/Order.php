<?php

namespace JobMetric\Metadata\Tests\Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use JobMetric\Metadata\HasMeta;

/**
 * @method static create(string[] $array)
 */
class Order extends Model
{
    use HasMeta;

    public $timestamps = false;
}
