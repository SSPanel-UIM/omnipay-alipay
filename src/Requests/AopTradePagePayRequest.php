<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradePagePayResponse;

/**
 * Class AopTradePagePayRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/doc2/detail.htm?treeId=270&articleId=105901&docType=1
 */
final class AopTradePagePayRequest extends AbstractAopRequest
{
    protected string $method = 'alipay.trade.page.pay';

    protected bool $returnable = true;

    protected bool $notifiable = true;

    public function sendData($data): AopTradePagePayResponse
    {
        return $this->response = new AopTradePagePayResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent('subject', 'out_trade_no', 'total_amount', 'product_code');
    }

    protected function getRequestUrl($data): string
    {
        return sprintf('%s?%s', $this->getEndpoint(), http_build_query($data));
    }
}
