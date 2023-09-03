<?php

require(__DIR__ . '/../vendor/autoload.php');

$_POST['storekey'] = '';
$hash = $_POST['HASH'];

$client = new CMI\CmiClient($_POST);

$status = $client->hashEqual($_POST['HASH']);

if ($status) {
    echo 'echo HASH is successfull, so the transaction went well';
} else {
    echo 'It mean the hash generated not equal to hash sended by CMI plateform ';
}
