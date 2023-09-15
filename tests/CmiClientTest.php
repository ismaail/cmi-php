<?php

declare(strict_types=1);

use CMI\CmiClient;
use CMI\CmiPayment;

it('generates correct valid hash', function (array $attributes, string $expectedhash) {
    $cmiPayment = new CmiPayment($attributes);

    $cmiClient = new CmiClient($cmiPayment);
    expect($cmiClient->generateHash())
        ->toEqual($expectedhash);
})->with([
    [
        'attributes' => [
            'storekey' => '987456', // STOREKEY
            'clientid' => '1234567', // CLIENTID
            'oid' => '137ABC', // COMMAND ID IT MUST BE UNIQUE
            'shopurl' => 'http://cmi-php.local/example', // SHOP URL FOR REDIRECTION
            'okUrl' => 'http://cmi-php.local/example/okFail.php', // REDIRECTION AFTER SUCCEFFUL PAYMENT
            'failUrl' => 'http://cmi-php.local/example/okFail.php', // REDIRECTION AFTER FAILED PAYMENT
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
            'CallbackURL' => 'http://cmi-php.local/example/callback.php', // CALLBACK

            'rnd' => '0.29594500 1693675195', // mock random microtime()
        ],
        'expectedhash' => 'AyLnNPwao8EnbcrLo0AfAF5LGzRBfQfSpmeUIyhes+uUR8+DbhpbxT/JgXqTQYOcnpkB+kfD2rYZ5S8FpT08AQ=='
    ],
]);
