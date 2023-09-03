<?php

namespace CmiTest;

use CMI\CmiClient;
use CMI\CmiPage;
use CMI\CmiPayment;

/**
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */

test('it generate redirect form', function () {
    $cmiPayment = new CmiPayment([
        'storekey' => 'XXXXXXXXXXXXX',
        'clientid' => '123456789',
        'oid' => '137ABC',
        'shopurl' => 'https://shpourl',
        'okUrl' => 'https://shpourl/okFail.php',
        'failUrl' => 'https://shpourl/okFail.php',
        'email' => 'doe@example.com',
        'BillToName' => 'Jhon Doe',
        'BillToCompany' => 'company name',
        'BillToStreet12' => '100 rue adress',
        'BillToCity' => 'casablanca',
        'BillToStateProv' => 'Maarif Casablanca',
        'BillToPostalCode' => '20230',
        'BillToCountry' => '504',
        'tel' => '0021201020304',
        'amount' => '5.99',
        'CallbackURL' => 'https://shpourl/callback.php',

        'rnd' => '0.91526800 1623787465', // the value is randomly reneraged in BaseCmiClient with microtime(),
    ]);

    $cmiClient = new CmiClient($cmiPayment);
    $cmiPage = new CmiPage($cmiClient);

    $html = <<<'HTML'
            <form name="redirectpost" method="post" action="https://testpayment.cmi.co.ma/fim/est3Dgate">
                <input type="hidden" name="storetype" value="3D_PAY_HOSTING"><input type="hidden" name="trantype" value="PreAuth"><input type="hidden" name="currency" value="504"><input type="hidden" name="rnd" value="0.91526800 1623787465"><input type="hidden" name="lang" value="fr"><input type="hidden" name="hashAlgorithm" value="ver3"><input type="hidden" name="encoding" value="UTF-8"><input type="hidden" name="refreshtime" value="5"><input type="hidden" name="storekey" value="XXXXXXXXXXXXX"><input type="hidden" name="clientid" value="123456789"><input type="hidden" name="oid" value="137ABC"><input type="hidden" name="shopurl" value="https://shpourl"><input type="hidden" name="okUrl" value="https://shpourl/okFail.php"><input type="hidden" name="failUrl" value="https://shpourl/okFail.php"><input type="hidden" name="email" value="doe@example.com"><input type="hidden" name="BillToName" value="Jhon Doe"><input type="hidden" name="BillToCompany" value="company name"><input type="hidden" name="BillToStreet12" value="100 rue adress"><input type="hidden" name="BillToCity" value="casablanca"><input type="hidden" name="BillToStateProv" value="Maarif Casablanca"><input type="hidden" name="BillToPostalCode" value="20230"><input type="hidden" name="BillToCountry" value="504"><input type="hidden" name="tel" value="0021201020304"><input type="hidden" name="amount" value="5.99"><input type="hidden" name="CallbackURL" value="https://shpourl/callback.php">
            </form>
            <script>
                document.forms['redirectpost'].submit();
            </script>
            HTML;

    expect($cmiPage->buildRedirectForm())
        ->toEqual($html);
});
