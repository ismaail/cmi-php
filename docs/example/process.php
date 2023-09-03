<?php

use CMI\CmiPage;

require __DIR__ . '/../vendor/autoload.php';

$base_url = 'https://domain.local/example';

$client = new CMI\CmiClient([
    'storekey' => '', // STOREKEY
    'clientid' => '', // CLIENTID
    'oid' => '137ABC', // COMMAND ID IT MUST BE UNIQUE
    'shopurl' => $base_url, // SHOP URL FOR REDIRECTION
    'okUrl' => $base_url . '/okFail.php', // REDIRECTION AFTER SUCCEFFUL PAYMENT
    'failUrl' => $base_url . '/okFail.php', // REDIRECTION AFTER FAILED PAYMENT
    'email' => 'mehdi.rochdi@gmail.com', // YOUR EMAIL APPEAR IN CMI PLATEFORM
    'BillToName' => 'mehdi rochdi', // YOUR NAME APPEAR IN CMI PLATEFORM
    'BillToCompany' => 'company name', // YOUR COMPANY NAME APPEAR IN CMI PLATEFORM
    'BillToStreet12' => '100 rue adress', // YOUR ADDRESS APPEAR IN CMI PLATEFORM NOT REQUIRED
    'BillToCity' => 'casablanca', // YOUR CITY APPEAR IN CMI PLATEFORM NOT REQUIRED
    'BillToStateProv' => 'Maarif Casablanca', // YOUR STATE APPEAR IN CMI PLATEFORM NOT REQUIRED
    'BillToPostalCode' => '20230', // YOUR POSTAL CODE APPEAR IN CMI PLATEFORM NOT REQUIRED
    'BillToCountry' => '504', // YOUR COUNTRY APPEAR IN CMI PLATEFORM NOT REQUIRED (504=MA)
    'tel' => '0021201020304', // YOUR PHONE APPEAR IN CMI PLATEFORM NOT REQUIRED
    'amount' => $_POST['amount'], // RETRIEVE AMOUNT WITH METHOD POST
    'CallbackURL' => $base_url . '/callback.php', // CALLBACK
]);

$cmiPage = new CmiPage($client);

echo $cmiPage->buildRedirectForm();
