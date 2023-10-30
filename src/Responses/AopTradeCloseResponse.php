<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeRefundRequest;

final class AopTradeCloseResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_close_response';

    /**
     * @var AopTradeRefundRequest
     */
    protected $request;
}
