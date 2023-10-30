<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeWapPayResponse;

/**
 * Class AopTradeWapPayRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/doc2/detail.htm?treeId=203&articleId=105463&docType=1
 */
final class AopTradeWapPayRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.wap.pay';

    protected bool $returnable = true;

    protected bool $notifiable = true;

    public function sendData($data): AopTradeWapPayResponse
    {
        return $this->response = new AopTradeWapPayResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent(
            'subject',
            'out_trade_no',
            'total_amount',
            'product_code'
        );
    }

    protected function getRequestUrl($data): string
    {
        return sprintf('%s?%s', $this->getEndpoint(), http_build_query($data));
    }
}
