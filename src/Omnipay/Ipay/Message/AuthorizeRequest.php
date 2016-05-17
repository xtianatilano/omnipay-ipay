<?php

namespace Omnipay\Ipay\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Dummy Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{

    protected $liveEndpoint = 'https://pay.ips.com.cn';
    protected $testEndpoint = 'http://pay.ips.net.cn';

    public function getMerchantKey()
    {
        return $this->getParameter('merchantKey');
    }

    public function setMerchantKey($value)
    {
        return $this->setParameter('merchantKey', $value);
    }

    public function getMerchantCode()
    {
        return $this->getParameter('merchantCode');
    }

    public function setMerchantCode($value)
    {
        return $this->setParameter('merchantCode', $value);
    }

    public function getBillNumber()
    {
        return $this->getParameter('billNumber');
    }

    public function setBillNumber($value)
    {
        return $this->setParameter('billNumber', $value);
    }

    public function getGatewayType()
    {
        return $this->getParameter('gatewayType');
    }

    public function setGatewayType($value)
    {
        return $this->setParameter('gatewayType', $value);
    }

    public function getLanguageCode()
    {
        return $this->getParameter('languageCode');
    }

    public function setLanguageCode($value)
    {
        return $this->setParameter('languageCode', $value);
    }

    public function getOrderEncodeType()
    {
        return $this->getParameter('orderEncodeType');
    }

    public function setOrderEncodeType($value)
    {
        return $this->setParameter('orderEncodeType', $value);
    }

    public function getRetEncodeType()
    {
        return $this->getParameter('retEncodeType');
    }

    public function setRetEncodeType($value)
    {
        return $this->setParameter('retEncodeType', $value);
    }

    public function getRetType()
    {
        return $this->getParameter('retType');
    }

    public function setRetType($value)
    {
        return $this->setParameter('retType', $value);
    }

    public function getData()
    {
        $this->validate('amount');

        $data = array();

        $data["Billno"] = $this->getBillNumber();
        $data["Currency_Type"] = $this->getCurrency();
        $data["Amount"] = $this->getAmount();
        $data["Date"] = date('Ymd');
        $data["OrderEncodeType"] = $this->getOrderEncodeType();
        $data["merchantKey"] = $this->getMerchantKey();
        $data["SignMD5"] =  $this->generateSignMD5($data);

        unset($data['merchantKey']);

        $data["Mer_code"] = $this->getMerchantCode();
        $data["Lang"] = strtoupper($this->getLanguageCode());
        $data["Merchanturl"] = $this->getReturnUrl();
        $data["FailUrl"] = $this->getReturnUrl();
        $data["ServerUrl"] = $this->getNotifyUrl();
        $data["ErrorUrl"] = "";
        $data["Attach"] = "";
        $data["DispAmount"] = $this->getAmount();
        $data["Gateway_Type"] = $this->getGatewayType();
        $data["RetEncodeType"] = $this->getRetEncodeType();
        $data["Rettype"] = $this->getRetType();

        return $data;
    }

    protected function generateSignMD5($data)
    {
        $fields = array();

        // specific order required by PayFast
        foreach (array('Billno', 'Currency_Type', 'Amount', 'Date', 'OrderEncodeType', 'merchantKey') as $key) {
            if (!empty($data[$key])) {
                $fields[$key] = $data[$key];
            }
        }

        return md5('billno' . $fields["Billno"]
          . 'currencytype' . $fields["Currency_Type"]
          . 'amount' . $fields["Amount"]
          . 'date' . $fields["Date"]
          . 'orderencodetype' . $fields["OrderEncodeType"]
          . $fields['merchantKey']
        );
    }

    public function sendData($data)
    {
        // return $this->response = new Response($this, $data, $this->getEndpoint().'/ipayment.aspx');

        $url = $this->getEndpoint().'/ipayment.aspx';
        $httpResponse = $this->httpClient->post($url, null, $data)->send();

        return new Response($this, $data, $url, $httpResponse->getStatusCode());
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
