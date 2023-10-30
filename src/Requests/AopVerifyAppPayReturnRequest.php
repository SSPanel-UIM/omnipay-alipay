<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\AopNotifyResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopVerifyAppPayReturnRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/doc.htm?treeId=193&articleId=105302&docType=1
 */
final class AopVerifyAppPayReturnRequest extends AbstractAopRequest
{
    protected string $key = 'alipay_trade_app_pay_response';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     *
     * @throws InvalidRequestException
     */
    public function getData(): mixed
    {
        $this->validate();

        $result = $this->getResult();

        if (str_starts_with($result, '{\"')) {
            $result = stripslashes($result);
        }

        $response = json_decode($result, true);

        $data = $response[$this->key];
        $data['sign'] = $response['sign'];
        $data['sign_type'] = $response['sign_type'];

        return $data;
    }

    /**
     * @throws InvalidRequestException
     */
    public function validate(...$args): void
    {
        parent::validate(
            'result'
        );

        $result = $this->getResult();

        if (! is_string($result)) {
            throw new InvalidRequestException('The result should be string');
        }

        if (str_starts_with($result, '{\"')) {
            $result = stripslashes($result);
        }

        $data = json_decode($result, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidRequestException('The result should be a valid json string');
        }

        if (! isset($data[$this->key])) {
            throw new InvalidRequestException("The result decode data should contain " . $this->key);
        }
    }

    public function getResult(): mixed
    {
        return $this->getParameter('result');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setResult($value): AopVerifyAppPayReturnRequest
    {
        return $this->setParameter('result', $value);
    }

    public function getMemo(): mixed
    {
        return $this->getParameter('memo');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setMemo($value): AopVerifyAppPayReturnRequest
    {
        return $this->setParameter('memo', $value);
    }

    public function getResultStatus(): mixed
    {
        return $this->getParameter('resultStatus');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setResultStatus($value): AopVerifyAppPayReturnRequest
    {
        return $this->setParameter('resultStatus', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $request = new AopNotifyRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setEndpoint($this->getEndpoint());
        $request->setParams($data);
        $request->setSort(false);
        $request->setEncodePolicy(Signer::ENCODE_POLICY_JSON);
        $request->setAlipayPublicKey($this->getAlipayPublicKey());

        /**
         * @var AopNotifyResponse $response
         */
        return $request->send();
    }
}
