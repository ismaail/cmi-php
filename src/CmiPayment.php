<?php

declare(strict_types=1);

namespace CMI;

use CMI\Assert\Assert;
use CMI\Assert\ValidationException;
use CMI\Assert\InvalidArgumentException;

class CmiPayment
{
    private array $attributes;

    /**
     * Languages supported by CMI
     *
     * @const array
     */
    private const LANGS = ['ar', 'fr', 'en'];

    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getDefaultAttributes(), $attributes);

        $this->assertAttributes($attributes);

        $this->attributes = $attributes;
    }

    private function getDefaultAttributes(): array
    {
        return [
            'storetype' => '3D_PAY_HOSTING',
            'trantype' => 'PreAuth',
            'currency' => '504', // MAD
            'rnd' => microtime(),
            'lang' => 'fr',
            'hashAlgorithm' => 'ver3',
            'encoding' => 'UTF-8', // OPTIONAL
            'refreshtime' => '5' // OPTIONAL
        ];
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @throws ValidationException
     */
    private function assertAttributes($attributes): void
    {
        $errors = [];

        // storekey
        try {
            $value = $attributes['storekey'] ?? null;

            Assert::notNull($value);
            Assert::stringNotEmpty($value);
            Assert::alnum($value);
        } catch (InvalidArgumentException $exception) {
            $errors['storekey'] = $exception->getMessage();
        }

        // clientid
        try {
            $value = $attributes['clientid'] ?? null;

            Assert::notNull($value);
            Assert::stringNotEmpty($value);
            Assert::alnum($value);
        } catch (InvalidArgumentException $exception) {
            $errors['clientid'] = $exception->getMessage();
        }

        // storetype (has default value if not provided)
        try {
            $value = $attributes['storetype'];

            Assert::notNull($value);
            Assert::string($value);
            Assert::stringNotEmpty($value);
        } catch (InvalidArgumentException $exception) {
            $errors['storetype'] = $exception->getMessage();
        }

        // trantype (has default value if not provided)
        try {
            $value = $attributes['trantype'];

            Assert::notNull($value);
            Assert::string($value);
            Assert::stringNotEmpty($value);
        } catch (InvalidArgumentException $exception) {
            $errors['trantype'] = $exception->getMessage();
        }

        // amount
        try {
            $value = $attributes['amount'] ?? null;

            Assert::notNull($value);
            Assert::numeric($value);
        } catch (InvalidArgumentException $exception) {
            $errors['amount'] = $exception->getMessage();
        }

        // currency (has default value if not provided)
        try {
            $value = $attributes['currency'];

            Assert::notNull($value);
            Assert::numeric($value);
        } catch (InvalidArgumentException $exception) {
            $errors['currency'] = $exception->getMessage();
        }

        // oid
        try {
            $value = $attributes['oid'] ?? null;

            Assert::notNull($value);
            Assert::alnum($value);
        } catch (InvalidArgumentException $exception) {
            $errors['oid'] = $exception->getMessage();
        }

        // okUrl
        try {
            $value = $attributes['okUrl'] ?? null;

            Assert::notNull($value);
            Assert::url($value);
        } catch (InvalidArgumentException $exception) {
            $errors['okUrl'] = $exception->getMessage();
        }

        // failUrl
        try {
            $value = $attributes['failUrl'] ?? null;

            Assert::notNull($value);
            Assert::url($value);
        } catch (InvalidArgumentException $exception) {
            $errors['failUrl'] = $exception->getMessage();
        }

        // lang (has default value if not provided)
        try {
            $value = $attributes['lang'];

            Assert::notNull($value);
            Assert::stringNotEmpty($value);
            Assert::inArray($value, self::LANGS);
        } catch (InvalidArgumentException $exception) {
            $errors['lang'] = $exception->getMessage();
        }

        // email
        try {
            $value = $attributes['email'] ?? null;

            Assert::notNull($value);
            Assert::email($value);
        } catch (InvalidArgumentException $exception) {
            $errors['email'] = $exception->getMessage();
        }

        // BillToName
        try {
            $value = $attributes['BillToName'] ?? null;

            Assert::notNull($value);
            Assert::string($value);
            Assert::stringNotEmpty($value);
        } catch (InvalidArgumentException $exception) {
            $errors['BillToName'] = $exception->getMessage();
        }

        // hashAlgorithm (has default value if not provided)
        try {
            $value = $attributes['hashAlgorithm'];

            Assert::notNull($value);
            Assert::string($value);
            Assert::stringNotEmpty($value);
        } catch (InvalidArgumentException $exception) {
            $errors['hashAlgorithm'] = $exception->getMessage();
        }

        if (! empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
