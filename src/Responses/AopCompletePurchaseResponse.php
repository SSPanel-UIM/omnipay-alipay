<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopCompletePurchaseRequest;

final class AopCompletePurchaseResponse extends AbstractResponse
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

    public function isPaid(): bool
    {
        if (array_get($this->data, 'trade_status')) {
            if (array_get($this->data, 'trade_status') === 'TRADE_SUCCESS') {
                return true;
            }
            if (array_get($this->data, 'trade_status') === 'TRADE_FINISHED') {
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
