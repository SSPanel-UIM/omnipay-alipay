<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopCompleteRefundResponse;
use Omnipay\Alipay\Responses\AopTradeQueryResponse;
use Omnipay\Common\Exception\InvalidRequestException;

final class AopCompleteRefundRequest extends AbstractAopRequest
{
    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return AopCompleteRefundResponse
     */
    public function sendData($data): AopCompleteRefundResponse
    {
        $request = new AopNotifyRequest($this->httpClient, $this->httpRequest);
        $request->initialize(['params' => $data]);
        $request->setEndpoint($this->getEndpoint());
        $request->setAlipayPublicKey($this->getAlipayPublicKey());
        $data = $request->send()->getData();

        if (! array_get($data, 'trade_status')) {
            $tn = array_get($data, 'trade_no');

            $request = new AopTradeQueryRequest($this->httpClient, $this->httpRequest);
            $request->initialize($this->getParameters());
            $request->setEndpoint($this->getEndpoint());
            $request->setBizContent(['trade_no' => $tn]);
            $request->setPrivateKey($this->getPrivateKey());

            /**
             * @var AopTradeQueryResponse $response
             */
            $response = $request->send();

            $tradeStatus = $response->getAlipayResponse('trade_status');

            $data['trade_status'] = $tradeStatus;
        }
        return $this->response = new AopCompleteRefundResponse($this, $data);
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     *
     * @throws InvalidRequestException
     * @throws InvalidRequestException
     */
    public function getData(): mixed
    {
        $this->validateParams();

        return $this->getParams();
    }

    public function validateParams(): void
    {
        $this->validate('params');
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
    public function setParams($value): AopCompleteRefundRequest
    {
        return $this->setParameter('params', $value);
    }
}
