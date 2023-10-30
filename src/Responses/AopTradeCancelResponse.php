<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeRefundRequest;

final class AopTradeCancelResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_cancel_response';

    /**
     * @var AopTradeRefundRequest
     */
    protected $request;
}
