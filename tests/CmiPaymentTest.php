<?php

declare(strict_types=1);

use CMI\CmiPayment;
use CMI\Assert\ValidationException;

test('required attributes validation throws validation exception', function (array $attributes) {
    $this->expectException(ValidationException::class);
    $this->expectExceptionMessage('Invalid CMI attributes');

    new CmiPayment($attributes);
})->with('requiredAttributesExceptions');

test('required attributes validation exception errors', function (array $attributes, array $errorMessages) {
    try {
        new CmiPayment($attributes);
    } catch (ValidationException $exception) {
        $this->assertEquals($errorMessages, $exception->getErrors());
    }
})->with('requiredAttributesExceptions');

dataset('requiredAttributesExceptions', [
    [
        [],
        [
            'storekey' => 'value is required',
            'clientid' => 'value is required',
            'amount' => 'value is required',
            'oid' => 'value is required',
            'okUrl' => 'value is required',
            'failUrl' => 'value is required',
            'email' => 'value is required',
            'BillToName' => 'value is required',
        ],
    ],
    [
        [
            'storekey' => null, 'clientid' => null, 'storetype' => null, 'trantype' => null,
            'amount' => null, 'currency' => null, 'oid' => null, 'okUrl' => null, 'failUrl' => null,
            'lang' => null, 'email' => null, 'BillToName' => null, 'hashAlgorithm' => null,
        ],
        [
            'storekey' => 'value is required',
            'clientid' => 'value is required',
            'storetype' => 'value is required',
            'trantype' => 'value is required',
            'amount' => 'value is required',
            'currency' => 'value is required',
            'oid' => 'value is required',
            'okUrl' => 'value is required',
            'failUrl' => 'value is required',
            'lang' => 'value is required',
            'email' => 'value is required',
            'BillToName' => 'value is required',
            'hashAlgorithm' => 'value is required',
        ],
    ],
    [
        [
            'storekey' => 123, 'clientid' => 456, 'storetype' => 000, 'trantype' => 000,
            'amount' => '', 'currency' => '', 'oid' => '', 'okUrl' => '', 'failUrl' => '',
            'lang' => '', 'email' => '', 'BillToName' => '', 'hashAlgorithm' => 000,
        ],
        [
            'storekey' => 'value must be a string',
            'clientid' => 'value must be a string',
            'storetype' => 'value must be a string',
            'trantype' => 'value must be a string',
            'amount' => 'value must be a numeric',
            'currency' => 'value must be a numeric',
            'oid' => 'value must contain letters and digits only',
            'okUrl' => 'value cannot be empty string',
            'failUrl' => 'value cannot be empty string',
            'lang' => 'value cannot be empty string',
            'email' => 'value cannot be empty string',
            'BillToName' => 'value cannot be empty string',
            'hashAlgorithm' => 'value must be a string',
        ],
    ],
    [
        [
            'storekey' => '123 256', 'clientid' => 'AB CD', 'storetype' => '', 'trantype' => '',
            'amount' => 'one', 'currency' => 'XXX', 'oid' => 'AA BB', 'okUrl' => 'domain',
            'failUrl' => 'domain', 'lang' => 'xx', 'email' => 'doe', 'BillToName' => 'Jhon Doe',
            'hashAlgorithm' => '',
        ],
        [
            'storekey' => 'value must contain letters and digits only',
            'clientid' => 'value must contain letters and digits only',
            'storetype' => 'value cannot be empty string',
            'trantype' => 'value cannot be empty string',
            'amount' => 'value must be a numeric',
            'currency' => 'value must be a numeric',
            'oid' => 'value must contain letters and digits only',
            'okUrl' => 'value must be a valid url',
            'failUrl' => 'value must be a valid url',
            'lang' => 'value must one of this: ar,fr,en',
            'email' => 'value must be a valid email',
            'hashAlgorithm' => 'value cannot be empty string',
        ],
    ],
]);
