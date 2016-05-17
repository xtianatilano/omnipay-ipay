<?php

namespace Omnipay\Ipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Direct Response
 */
class RedirectResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $redirectUrl;

    public function __construct(RequestInterface $request, $data, $redirectUrl, $status)
    {
        parent::__construct($request, $data);
        $this->redirectUrl = $redirectUrl;
        $this->status = $status;
    }

    public function isSuccessful()
    {
        return 200 === $this->status;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
