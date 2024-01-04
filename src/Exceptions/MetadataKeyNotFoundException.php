<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class MetadataKeyNotFoundException extends Exception
{
    public function __construct(string $key, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct("Metadata key $key not found!", $code, $previous);
    }
}
