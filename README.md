# Omnipay: Ipay

**Ipay driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Ipay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
                "xtianproject/omnipay-ipay": "~1.0@dev"
    },

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/xtianproject/omnipay-ipay"
        }
    ]
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Ipay

For general usage instructions:

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Ipay');

$formData = [
    "merchantCode" => "",
    "billNumber" => "",
    "amount" => "",
    "currency" => "",
    "gatewayType" => "",
    "languageCode" => "",
    "returnUrl" => "",
    "orderEncodeType" => "",
    "retEncodeType" =>  "",
    "retType" => '',
    "notifyUrl" => "",
    "merchantKey" => "",
    "testMode" => true,
    ];

$response = $gateway->redirect($formData)->send();

if ($response->isSuccessful()) {
    $response->redirect();
}
```
