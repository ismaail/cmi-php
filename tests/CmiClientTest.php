<?php

declare(strict_types=1);

use CMI\CmiClient;
use CMI\CmiPayment;

it('generate a validated hash.', function () {
    $baseUrl = 'http://cmi-php.local/example';
    $client = new CmiClient(new CmiPayment([
        'storekey' => '987456',
        'clientid' => '1234567',
        'oid' => '137ABC',
        'shopurl' => $baseUrl,
        'okUrl' => "$baseUrl/okFail.php",
        'failUrl' => "$baseUrl/okFail.php",
        'email' => 'example@gmail.com',
        'BillToName' => 'Jhon Doe',
        'BillToCompany' => 'company name',
        'BillToStreet12' => '123 main Street',
        'BillToCity' => 'City Name',
        'BillToStateProv' => 'State Name',
        'BillToPostalCode' => '10000',
        'BillToCountry' => '100',
        'tel' => '001020304',
        'amount' => '10.60',
        'CallbackURL' => "$baseUrl/callback.php",

        'rnd' => '0.29594500 1693675195', // mock random microtime()
    ]));

    $client->generateHash();
    expect($client->generateHash())
        ->not()->toBeNull()
        ->toEqual('14BaHQ6okBJhRK9yOFEFK6jrEWG2ZeX2CPamLTdbq3v05fIIr1OG6Rx112GcJeZbfF6QforHBclIJ1EzdcFMIg==')
    ;
});
