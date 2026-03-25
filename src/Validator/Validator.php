<?php

declare(strict_types=1);

namespace CMI\Validator;

use InvalidArgumentException;

class Validator
{
    /**
     * @param array<string, array<int, string|array<int, mixed>>> $rules
     */
    public function __construct(private readonly array $rules) {}

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    public function validate(array $data): array
    {
        $errors = [];

        foreach ($this->rules as $field => $rules) {
            $value = $data[$field] ?? null;

            foreach ($rules as $rule) {
                try {
                    if (is_string($rule)) {
                        $this->validateRule($rule, $value);
                    } elseif (is_array($rule)) {
                        /** @var string $ruleName */
                        $ruleName = $rule[0];
                        $parameters = array_slice($rule, 1);
                        $this->validateRule($ruleName, $value, $parameters);
                    }
                } catch (InvalidArgumentException $e) {
                    $errors[$field] = $e->getMessage();
                    break;
                }
            }
        }

        return $errors;
    }

    /**
     * @param array<int, mixed> $parameters
     */
    private function validateRule(string $rule, mixed $value, array $parameters = []): void
    {
        match ($rule) {
            'required' => $this->validateRequired($value),
            'string' => $this->validateString($value),
            'numeric' => $this->validateNumeric($value),
            'email' => $this->validateEmail($value),
            'url' => $this->validateUrl($value),
            'alnum' => $this->validateAlnum($value),
            'not_empty' => $this->validateNotEmpty($value),
            'in' => $this->validateIn($value, $parameters),
            default => throw new InvalidArgumentException("Unknown validation rule: $rule")
        };
    }

    private function validateRequired(mixed $value): void
    {
        if (null === $value) {
            throw new InvalidArgumentException('value is required');
        }
    }

    private function validateString(mixed $value): void
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('value must be a string');
        }
    }

    private function validateNumeric(mixed $value): void
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('value must be a numeric');
        }
    }

    private function validateEmail(mixed $value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('value must be a valid email');
        }
    }

    private function validateUrl(mixed $value): void
    {
        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('value must be a valid url');
        }
    }

    private function validateAlnum(mixed $value): void
    {
        if (! is_string($value) || ! preg_match('/^[a-zA-Z0-9]+$/', $value)) {
            throw new InvalidArgumentException('value must contain letters and digits only');
        }
    }

    /**
     * @param array<int, mixed> $haystack
     */
    private function validateIn(mixed $value, array $haystack): void
    {
        if (! in_array($value, $haystack, true)) {
            throw new InvalidArgumentException('value must one of this: ' . implode(',', $haystack));
        }
    }

    private function notEq(string $value, string $expect, string $message = ''): void
    {
        if ($expect === $value) {
            throw new InvalidArgumentException(
                $message ?: sprintf('Expected a different value than %s.', $expect)
            );
        }
    }

    private function validateNotEmpty(mixed $value): void
    {
        $this->validateString($value);

        $this->notEq($value, '', 'value cannot be empty string');
    }
}
