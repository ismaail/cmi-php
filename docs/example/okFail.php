<?php

require(__DIR__ . '/../vendor/autoload.php');

$postData = $_POST;

$postData['storekey'] = 'TEST1234';

$client = new CMI\CmiClient(new CMI\CmiPayment($postData));

$status = $client->hashEqual($postData['HASH']);

echo $status ? 'echo HASH is successfull, so the transaction went well'
             : 'It mean the hash generated not equal to hash sended by CMI plateform';
