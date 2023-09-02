<?php

declare(strict_types=1);

use Mehdirochdi\CMI\CmiClient;
use Mehdirochdi\CMI\Exception\InvalidArgumentException;

test('test it require storekey', function () {
    expect(fn() => new CmiClient())
        ->toThrow(InvalidArgumentException::class, 'storekey is required');
});

test('test storekey null', function () {
    expect(fn() => new CmiClient(['storekey' => null]))
        ->toThrow(InvalidArgumentException::class, 'storekey is required');
});

test('test storekey has space', function () {
    expect(fn() => new CmiClient(['storekey' => '123 256']))
        ->toThrow(InvalidArgumentException::class, 'storekey cannot contain whitespace');
});

test('test if hash is validated', function () {
    $base_url = 'http://cmi-php.local/example';
    $client = new Mehdirochdi\CMI\CmiClient([
        'storekey' => '987456', // STOREKEY
        'clientid' => '1234567', // CLIENTID
        'oid' => '137ABC', // COMMAND ID IT MUST BE UNIQUE
        'shopurl' => $base_url, // SHOP URL FOR REDIRECTION
        'okUrl' => "$base_url/okFail.php", // REDIRECTION AFTER SUCCEFFUL PAYMENT
        'failUrl' => "$base_url/okFail.php", // REDIRECTION AFTER FAILED PAYMENT
        'email' => 'mehdi.rochdi@gmail.com', // YOUR EMAIL APPEAR IN CMI PLATEFORM
        'BillToName' => 'mehdi rochdi', // YOUR NAME APPEAR IN CMI PLATEFORM
        'BillToCompany' => 'company name', // YOUR COMPANY NAME APPEAR IN CMI PLATEFORM
        'BillToStreet12' => '100 rue adress', // YOUR ADDRESS APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToCity' => 'casablanca', // YOUR CITY APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToStateProv' => 'Maarif Casablanca', // YOUR STATE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToPostalCode' => '20230', // YOUR POSTAL CODE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'BillToCountry' => '504', // YOUR COUNTRY APPEAR IN CMI PLATEFORM NOT REQUIRED (504=MA)
        'tel' => '0021201020304', // YOUR PHONE APPEAR IN CMI PLATEFORM NOT REQUIRED
        'amount' => '10.60', // RETRIEVE AMOUNT WITH METHOD POST
        'CallbackURL' => "$base_url/callback.php", // CALLBACK

        'rnd' => '0.29594500 1693675195', // mock random microtime()
    ]);

    $client->generateHash();
    expect($client->Hash)
        ->not()->toBeNull()
        ->toEqual('AyLnNPwao8EnbcrLo0AfAF5LGzRBfQfSpmeUIyhes+uUR8+DbhpbxT/JgXqTQYOcnpkB+kfD2rYZ5S8FpT08AQ==')
    ;
});
