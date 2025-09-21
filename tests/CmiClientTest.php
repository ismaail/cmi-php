<?php

declare(strict_types=1);

use CMI\CmiClient;
use CMI\CmiPayment;

test('test if hash is validated', function () {
    $baseUrl = 'http://cmi-php.local/example';
    $client = new CmiClient(new CmiPayment([
        'storekey' => '987456',
        'clientid' => '1234567',
        'oid' => '137ABC',
        'shopurl' => $baseUrl,
        'okUrl' => "$baseUrl/okFail.php",
        'failUrl' => "$baseUrl/okFail.php",
        'email' => 'mehdi.rochdi@gmail.com',
        'BillToName' => 'mehdi rochdi',
        'BillToCompany' => 'company name',
        'BillToStreet12' => '100 rue adress',
        'BillToCity' => 'casablanca',
        'BillToStateProv' => 'Maarif Casablanca',
        'BillToPostalCode' => '20230',
        'BillToCountry' => '504',
        'tel' => '0021201020304',
        'amount' => '10.60',
        'CallbackURL' => "$baseUrl/callback.php",

        'rnd' => '0.29594500 1693675195', // mock random microtime()
    ]));

    $client->generateHash();
    expect($client->generateHash())
        ->not()->toBeNull()
        ->toEqual('AyLnNPwao8EnbcrLo0AfAF5LGzRBfQfSpmeUIyhes+uUR8+DbhpbxT/JgXqTQYOcnpkB+kfD2rYZ5S8FpT08AQ==')
    ;
});
