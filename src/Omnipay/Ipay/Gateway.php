<?php

namespace Omnipay\Ipay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Ipay\Message\DirectRequest;

/**
 * Dummy Gateway
 *
 * This gateway is useful for testing. It simply authorizes any payment made using a valid
 * credit card number and expiry.
 *
 * Any card number which passes the Luhn algorithm and ends in an even number is authorized,
 * for example: 4242424242424242
 *
 * Any card number which passes the Luhn algorithm and ends in an odd number is declined,
 * for example: 4111111111111111
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Ipay';
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantCode' => '',
            'billNumber' => '',
            'gatewayType' => '',
            'languageCode' => '',
            'orderEncodeType' => '',
            'retEncodeType' => '',
            'retType' => '',
            'testMode' => false,
            );
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Ipay\Message\DirectRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->authorize($parameters);
    }
}
