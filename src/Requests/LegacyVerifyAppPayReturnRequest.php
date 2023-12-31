<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyNotifyResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class LegacyVerifyAppPayReturnRequest
 *
 * @package Omnipay\Alipay\Requests
 */
final class LegacyVerifyAppPayReturnRequest extends AbstractLegacyRequest
{
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validateParams();

        $result = trim($this->getResult());

        if (str_ends_with($result, '\"')) {
            $result = stripslashes($result);
        }

        parse_str($result, $data);

        $sign = trim($data['sign'], '"');
        $sign = str_replace(' ', '+', $sign);
        $signType = trim($data['sign_type'], '"');

        $data['sign'] = $sign;
        $data['sign_type'] = $signType;

        return $data;
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateParams(): void
    {
        $this->validate(
            'result'
        );

        $result = $this->getResult();

        if (! is_string($result)) {
            throw new InvalidRequestException('The result should be string');
        }

        parse_str($result, $data);

        if (! isset($data['sign'])) {
            throw new InvalidRequestException('The `result` is invalid');
        }

        if (! isset($data['sign_type'])) {
            throw new InvalidRequestException('The `result` is invalid');
        }
    }

    public function getResult(): mixed
    {
        return $this->getParameter('result');
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
        $request = new LegacyNotifyRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setParams($data);
        $request->setSort(false);
        $request->setAlipayPublicKey($this->getAlipayPublicKey());

        /**
         * @var LegacyNotifyResponse $response
         */
        return $request->send();
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setResult($value): LegacyVerifyAppPayReturnRequest
    {
        return $this->setParameter('result', $value);
    }
}
