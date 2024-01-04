<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetaableTraitNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("Model $model not use JobMetric\Metadata\HasMetadata Trait!", $code, $previous);
    }
}
