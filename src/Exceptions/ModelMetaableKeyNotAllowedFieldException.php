<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetaableKeyNotAllowedFieldException extends Exception
{
    public function __construct(string $model, string $key, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('metadata::base.exceptions.key_not_allowed', [
            'model' => $model,
            'key' => $key,
        ]), $code, $previous);
    }
}
