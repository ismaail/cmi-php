<?php

declare(strict_types=1);

use CMI\CmiClient;
use CMI\CmiPayment;

test('hash is validated', function () {
    $base_url = 'http://cmi-php.local/example';
    $cmiPayment = new CmiPayment([
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

    $expectedhash = 'AyLnNPwao8EnbcrLo0AfAF5LGzRBfQfSpmeUIyhes+uUR8+DbhpbxT/JgXqTQYOcnpkB+kfD2rYZ5S8FpT08AQ==';

    $cmiClient = new CmiClient($cmiPayment);
    expect($cmiClient->hashEqual($expectedhash))
        ->toBeTrue()
        ->and($expectedhash)
        ->toEqual($expectedhash);
});
