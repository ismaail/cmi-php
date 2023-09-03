<?php

namespace CMI\Assert;

/**
 * @see https://github.com/webmozarts/assert/blob/master/src/Assert.php
 */
class Assert
{
    public static function notNull(mixed $value): void
    {
        if (null === $value) {
            throw new InvalidArgumentException('value is required');
        }
    }

    public static function string(mixed $value): void
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('value must be a string');
        }
    }

    public static function stringNotEmpty(mixed $value): void
    {
        static::string($value);

        static::NotEq($value, '', 'value cannot be empty string');
    }

    public static function numeric(mixed $value): void
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('value must be a numeric');
        }
    }

    public static function email(mixed $value): void
    {
        static::stringNotEmpty($value);

        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('value must be a valid email');
        }
    }

    public static function url(mixed $value): void
    {
        static::stringNotEmpty($value);

        if (! filter_var($value, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('value must be a valid url');
        }
    }

    public static function alnum(mixed $value): void
    {
        $locale = setlocale(LC_CTYPE, 0);
        setlocale(LC_CTYPE, 'C');
        $valid = !ctype_alnum($value);
        setlocale(LC_CTYPE, $locale);

        if ($valid) {
            throw new InvalidArgumentException('value must contain letters and digits only');
        }
    }

    public static function notEq(string $value, string $expect, string $message = ''): void
    {
        if ($expect === $value) {
            throw new InvalidArgumentException(
                $message ?: sprintf('Expected a different value than %s.', $expect)
            );
        }
    }

    public static function inArray(mixed $value, array $haystack): void
    {
        if (! in_array($value, $haystack, true)) {
            throw new InvalidArgumentException('value must one of this: ' . implode(',', $haystack));
        }
    }
}
