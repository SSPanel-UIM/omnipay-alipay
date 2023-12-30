<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeRefundRequest;

final class AopTradeRefundResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_trade_refund_response';

    /**
     * @var AopTradeRefundRequest
     */
    protected $request;
}
