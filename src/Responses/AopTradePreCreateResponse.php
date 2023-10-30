<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradePreCreateRequest;

final class AopTradePreCreateResponse extends AbstractAopResponse
{
    protected $key = 'alipay_trade_precreate_response';

    /**
     * @var AopTradePreCreateRequest
     */
    protected $request;

    public function getQrCode()
    {
        return $this->getAlipayResponse('qr_code');
    }
}
