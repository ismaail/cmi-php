<?php

declare(strict_types=1);

namespace CMI;

use CMI\Validator\ValidationException;
use CMI\Validator\Validator;

class CmiPayment
{
    private array $attributes;

    /**
     * Languages supported by CMI
     *
     * @const list<string>
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
    private function assertAttributes(array $attributes): void
    {
        $rules = [
            'storekey' => ['required', 'string', 'not_empty', 'alnum'],
            'clientid' => ['required', 'string', 'not_empty', 'alnum'],
            'storetype' => ['required', 'string', 'not_empty'],
            'trantype' => ['required', 'string', 'not_empty'],
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'numeric'],
            'oid' => ['required', 'alnum'],
            'okUrl' => ['required', 'url'],
            'failUrl' => ['required', 'url'],
            'lang' => ['required', 'string', 'not_empty', ['in', ...self::LANGS]],
            'email' => ['required', 'email'],
            'BillToName' => ['required', 'string', 'not_empty'],
            'hashAlgorithm' => ['required', 'string', 'not_empty'],
        ];

        $validator = new Validator($rules);
        $errors = $validator->validate($attributes);

        if (! empty($errors)) {
            throw new ValidationException($errors);
        }
    }
}
