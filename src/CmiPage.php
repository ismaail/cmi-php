<?php

declare(strict_types=1);

namespace CMI;

class CmiPage
{
    private CmiClient $cmiClient;

    public function __construct(CmiClient $cmiClient)
    {
        $this->cmiClient = $cmiClient;
    }

    /**
     * Generate form with hidedn inputs
     * and make redirection to CMI plateform to handle the payment.
     */
    public function buildRedirectForm(): string
    {
        $url = $this->cmiClient->getApiEndpoint() . '/fim/est3Dgate';

        $formInputs = '';

        foreach ($this->cmiClient->getCmiPayment()->getAttributes() as $name => $value) {
            $formInputs .= sprintf('<input type="hidden" name="%s" value="%s">', $name, trim($value));
        }

        return <<<HTML
            <form name="redirectpost" method="post" action="{$url}">
                {$formInputs}
            </form>
            <script>
                document.forms['redirectpost'].submit();
            </script>
            HTML;
    }
}
