<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetaableInterfaceNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        $message = 'Model "'.$model.'" not implements JobMetric\Metadata\MetadataInterface interface!';

        parent::__construct($message, $code, $previous);
    }
}
