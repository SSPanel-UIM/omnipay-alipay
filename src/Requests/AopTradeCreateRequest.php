<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeCreateResponse;
use Psr\Http\Client\Exception\NetworkException;
use Psr\Http\Client\Exception\RequestException;

/**
 * Class AopTradeCreateRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://docs.open.alipay.com/api_1/alipay.trade.create
 */
final class AopTradeCreateRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.create';

    public function getNotifyUrl(): mixed
    {
        return $this->getParameter('notify_url');
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setNotifyUrl($value): AbstractAopRequest
    {
        return $this->setParameter('notify_url', $value);
    }

    public function getAppAuthToken(): mixed
    {
        return $this->getParameter('app_auth_token');
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setAppAuthToken($value): AbstractAopRequest
    {
        return $this->setParameter('app_auth_token', $value);
    }

    /**
     * @param mixed $data
     *
     * @return AopTradeCreateResponse
     *
     * @throws NetworkException
     * @throws RequestException
     */
    public function sendData($data): AopTradeCreateResponse
    {
        $data = parent::sendData($data);

        return $this->response = new AopTradeCreateResponse($this, $data);
    }
}
