<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopCompletePurchaseRequest;

final class AopCompleteRefundResponse extends AbstractResponse
{
    /**
     * @var AopCompletePurchaseRequest
     */
    protected $request;

    public function getResponseText(): string
    {
        if ($this->isSuccessful()) {
            return 'success';
        }
        return 'fail';
    }

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return true;
    }

    public function isRefunded(): bool
    {
        $trade_status = array_get($this->data, 'trade_status');
        if ($trade_status) {
            // 全额退款为 TRADE_CLOSED；非全额退款为 TRADE_SUCCESS
            if ($trade_status === 'TRADE_CLOSED' || $trade_status === 'TRADE_SUCCESS') {
                return true;
            }
            return false;
        }

        if (array_get($this->data, 'code') === '10000') {
            return true;
        }

        return false;
    }
}
