<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeAppPayResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTradeAppPayRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/doc.htm?treeId=204&articleId=105465&docType=1
 */
final class AopTradeAppPayRequest extends AbstractAopRequest
{
    protected string $method = 'alipay.trade.app.pay';

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data['order_string'] = http_build_query($data);

        return $this->response = new AopTradeAppPayResponse($this, $data);
    }

    public function getNotifyUrl(): mixed
    {
        return $this->getParameter('notify_url');
    }

    /**
     * @param $value
     *
     * @return AopTradeAppPayRequest
     */
    public function setNotifyUrl($value): AopTradeAppPayRequest
    {
        return $this->setParameter('notify_url', $value);
    }
}
