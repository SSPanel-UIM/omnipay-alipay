<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeOrderSettleRequest;

final class AopTradeOrderSettleResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_trade_order_settle_response';

    /**
     * @var AopTradeOrderSettleRequest
     */
    protected $request;
}
