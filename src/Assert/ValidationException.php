<?php

namespace CMI\Assert;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    private array $errors;

    public function __construct(
        array $errors,
        $message = 'Invalid CMI attributes',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
