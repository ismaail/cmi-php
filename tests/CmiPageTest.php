<?php

declare(strict_types=1);

namespace CmiTest;

use CMI\CmiClient;
use CMI\CmiPage;
use CMI\CmiPayment;

test('it generate redirect form', function () {
    $cmiPayment = new CmiPayment([
        'storekey' => '987456',
        'clientid' => '1234567',
        'oid' => '137ABC',
        'shopurl' => 'https://shpourl',
        'okUrl' => 'https://shpourl/okFail.php',
        'failUrl' => 'https://shpourl/okFail.php',
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
        'CallbackURL' => 'https://shpourl/callback.php',

        'rnd' => '0.91526800 1623787465', // the value is randomly reneraged in BaseCmiClient with microtime(),
    ]);

    $cmiClient = new CmiClient($cmiPayment);
    $cmiPage = new CmiPage($cmiClient);

    $html = <<<'HTML'
            <form name="redirectpost" method="post" action="https://testpayment.cmi.co.ma/fim/est3Dgate">
                <input type="hidden" name="storetype" value="3D_PAY_HOSTING"><input type="hidden" name="trantype" value="PreAuth"><input type="hidden" name="currency" value="504"><input type="hidden" name="rnd" value="0.91526800 1623787465"><input type="hidden" name="lang" value="fr"><input type="hidden" name="hashAlgorithm" value="ver3"><input type="hidden" name="encoding" value="UTF-8"><input type="hidden" name="refreshtime" value="5"><input type="hidden" name="storekey" value="987456"><input type="hidden" name="clientid" value="1234567"><input type="hidden" name="oid" value="137ABC"><input type="hidden" name="shopurl" value="https://shpourl"><input type="hidden" name="okUrl" value="https://shpourl/okFail.php"><input type="hidden" name="failUrl" value="https://shpourl/okFail.php"><input type="hidden" name="email" value="example@gmail.com"><input type="hidden" name="BillToName" value="Jhon Doe"><input type="hidden" name="BillToCompany" value="company name"><input type="hidden" name="BillToStreet12" value="123 main Street"><input type="hidden" name="BillToCity" value="City Name"><input type="hidden" name="BillToStateProv" value="State Name"><input type="hidden" name="BillToPostalCode" value="10000"><input type="hidden" name="BillToCountry" value="100"><input type="hidden" name="tel" value="001020304"><input type="hidden" name="amount" value="10.60"><input type="hidden" name="CallbackURL" value="https://shpourl/callback.php">
            </form>
            <script>
                document.forms['redirectpost'].submit();
            </script>
            HTML;

    expect($cmiPage->buildRedirectForm())
        ->toEqual($html)
    ;
});
