<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeRefundQueryResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTradeRefundQueryRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=1049
 */
final class AopTradeRefundQueryRequest extends AbstractAopRequest
{
    protected string $method = 'alipay.trade.fastpay.refund.query';

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data = parent::sendData($data);

        return $this->response = new AopTradeRefundQueryResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent('out_request_no');

        $this->validateBizContentOne(
            'trade_no',
            'out_trade_no'
        );
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
    public function setOutTradeNo($value): AopTradeRefundQueryRequest
    {
        return $this->setParameter('out_trade_no', $value);
    }

    public function getTradeNo(): mixed
    {
        return $this->getParameter('trade_no');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setTradeNo($value): AopTradeRefundQueryRequest
    {
        return $this->setParameter('trade_no', $value);
    }
}
