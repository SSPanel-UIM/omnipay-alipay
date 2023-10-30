<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyCompletePurchaseResponse;
use Omnipay\Common\Message\ResponseInterface;

final class LegacyCompleteRefundRequest extends AbstractLegacyRequest
{
    protected bool $verifyNotifyId = true;

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $request = new LegacyNotifyRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setAlipayPublicKey($this->getAlipayPublicKey());
        $request->setVerifyNotifyId($this->verifyNotifyId);
        $request->setKey($this->getKey());
        $response = $request->send();

        $data = $response->getData();

        return $this->response = new LegacyCompletePurchaseResponse($this, $data);
    }

    /**
     * @param bool $verifyNotifyId
     *
     * @return $this
     */
    public function setVerifyNotifyId(bool $verifyNotifyId): LegacyCompleteRefundRequest
    {
        $this->verifyNotifyId = $verifyNotifyId;

        return $this;
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->getParams();
    }

    public function getParams(): mixed
    {
        return $this->getParameter('params');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setParams($value): LegacyCompleteRefundRequest
    {
        return $this->setParameter('params', $value);
    }
}
