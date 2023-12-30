<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyQueryResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Psr\Http\Client\Exception\NetworkException;
use Psr\Http\Client\Exception\RequestException;

/**
 * Class LegacyQueryRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    http://aopsdkdownload.cn-hangzhou.alipay-pub.aliyun-inc.com/demo/alipaysinglequery.zip
 */
final class LegacyQueryRequest extends AbstractLegacyRequest
{
    protected string $service = 'single_trade_query';

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     *
     * @throws NetworkException
     * @throws RequestException
     * @throws InvalidRequestException
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $url = sprintf('%s?%s', $this->getEndpoint(), http_build_query($this->getData()));
        $result = $this->httpClient->request('GET', $url, [], '')->getBody();

        $xml = simplexml_load_string((string) $result);
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $this->response = new LegacyQueryResponse($this, $data);
    }

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

        $data = [
            'service' => $this->service,
            'partner' => $this->getPartner(),
            'trade_no' => $this->getTradeNo(),
            'out_trade_no' => $this->getOutTradeNo(),
            '_input_charset' => $this->getInputCharset(),
            'sign_type' => $this->getSignType(),
        ];
        $data['sign'] = $this->sign($data, $this->getSignType());

        return $data;
    }

    public function getTradeNo(): mixed
    {
        return $this->getParameter('trade_no');
    }

    public function getOutTradeNo(): mixed
    {
        return $this->getParameter('out_trade_no');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setTradeNo($value): LegacyQueryRequest
    {
        return $this->setParameter('trade_no', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOutTradeNo($value): LegacyQueryRequest
    {
        return $this->setParameter('out_trade_no', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    protected function validateParams(): void
    {
        $this->validate(
            'partner',
            '_input_charset'
        );

        $this->validateOne(
            'trade_no',
            'out_trade_no'
        );
    }
}
