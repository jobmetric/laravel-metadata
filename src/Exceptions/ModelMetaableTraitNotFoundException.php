<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class ModelMetaableTraitNotFoundException extends Exception
{
    public function __construct(string $model, int $code = 400, ?Throwable $previous = null)
    {
        $message = 'Model "'.$model.'" not use JobMetric\Metadata\Traits\HasMetadata Trait!';

        parent::__construct($message, $code, $previous);
    }
}
