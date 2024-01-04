<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetaableKeyNotAllowedFieldException extends Exception
{
    public function __construct(string $model, string $key, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("Model '$model' not allowed '$key' in function 'allowMetadataFields'", $code, $previous);
    }
}
