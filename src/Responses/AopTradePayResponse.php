<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradePayRequest;

final class AopTradePayResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_trade_pay_response';

    /**
     * @var AopTradePayRequest
     */
    protected $request;

    public function isPayFailed(): bool
    {
        return $this->getCode() === '40004';
    }

    public function isPaid(): bool
    {
        return $this->getCode() === '10000';
    }

    public function isWaitPay(): bool
    {
        return $this->getCode() === '10003';
    }

    public function isUnknownException(): bool
    {
        return $this->getCode() === '20000';
    }
}
