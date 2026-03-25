<?php

declare(strict_types=1);

namespace CMI\Validator;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    /**
     * @var array<string, string>
     */
    private array $errors;

    /**
     * @param array<string, string> $errors
     */
    public function __construct(
        array $errors,
        string $message = 'Invalid CMI attributes',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
