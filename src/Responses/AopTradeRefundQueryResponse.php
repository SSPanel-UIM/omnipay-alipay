<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeRefundQueryRequest;

final class AopTradeRefundQueryResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_trade_fastpay_refund_query_response';

    /**
     * @var AopTradeRefundQueryRequest
     */
    protected $request;
}
