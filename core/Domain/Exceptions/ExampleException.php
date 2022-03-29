<?php

namespace Core\Domain\Exceptions;

use Throwable;
use Exception;

class ExampleException extends Exception
{

    public function __construct(string $message = null, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
