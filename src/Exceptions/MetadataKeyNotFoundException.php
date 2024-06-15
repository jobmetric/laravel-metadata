<?php

namespace JobMetric\Metadata\Exceptions;

use Exception;
use Throwable;

class MetadataKeyNotFoundException extends Exception
{
    public function __construct(string $key, int $code = 400, ?Throwable $previous = null)
    {
        parent::__construct(trans('metadata::base.exceptions.key_not_found', [
            'key' => $key
        ]), $code, $previous);
    }
}
