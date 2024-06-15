<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetadataInterfaceNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('metadata::base.exceptions.interface_not_found', [
            'model' => $model
        ]), $code, $previous);
    }
}
