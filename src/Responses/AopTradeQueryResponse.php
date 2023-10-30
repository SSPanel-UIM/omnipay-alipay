<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeQueryRequest;

final class AopTradeQueryResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_query_response';

    /**
     * @var AopTradeQueryRequest
     */
    protected $request;

    public function isPaid(): bool
    {
        if ($this->getTradeStatus() === 'TRADE_SUCCESS') {
            return true;
        }
        if ($this->getTradeStatus() === 'TRADE_FINISHED') {
            return true;
        }
        return false;
    }

    public function getTradeStatus(): mixed
    {
        return $this->getAlipayResponse('trade_status');
    }

    public function isWaitPay(): bool
    {
        return $this->getTradeStatus() === 'WAIT_BUYER_PAY';
    }

    public function isClosed(): bool
    {
        return $this->getTradeStatus() === 'TRADE_CLOSED';
    }
}
