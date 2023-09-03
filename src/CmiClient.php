<?php

declare(strict_types=1);

namespace CMI;

/**
 * @phpcs:disable Generic.Files.LineLength.TooLong
 */
class CmiClient
{
    /**
     * Default base URL for CMI's API
     *
     * @const string
     */
    private const API_ENDPOINT = 'https://testpayment.cmi.co.ma';

    private CmiPayment $cmiPayment;

    public function __construct(CmiPayment $cmiPayment)
    {
        $this->cmiPayment = $cmiPayment;
    }

    public function getCmiPayment(): CmiPayment
    {
        return $this->cmiPayment;
    }

    public function getApiEndpoint(): string
    {
        return self::API_ENDPOINT;
    }

    /**
     * Generate Hash to make redirection to CMI page
     */
    public function generateHash(): string
    {
        // amount|BillToCompany|BillToName|callbackUrl|clientid|currency|email|failUrl|hashAlgorithm|lang|okurl|rnd|storetype|TranType|storeKey

        $cmiParams = $this->cmiPayment->getAttributes();

        $optionskeys = array_keys($cmiParams);
        natcasesort($optionskeys);
        $hashval = '';

        foreach ($optionskeys as $param) {
            // Skip some params
            if (in_array(strtolower($param), ['storekey', 'hash', 'encoding'], strict: true)) {
                continue;
            }

            $paramValue = str_replace(['\\', '|'], ['\\\\', '\|'], trim($cmiParams[$param]));
            $hashval .= $paramValue . '|';
        }

        $storeKeyValue = str_replace(['\\', '|'], ['\\\\', '\|'], $cmiParams['storekey']);
        $hashval .= $storeKeyValue;

        return base64_encode(pack('H*', hash('sha512', $hashval)));
    }

    /**
     * Check status hash from CMI plateform if is equal to hash generated
     */
    public function hashEqual(string $hash): bool
    {
        return $this->generateHash() === $hash;
    }
}
