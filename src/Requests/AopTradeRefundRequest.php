<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeRefundResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTradeRefundRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=759
 */
final class AopTradeRefundRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.refund';

    protected bool $notifiable = true;

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data = parent::sendData($data);

        return $this->response = new AopTradeRefundResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent('refund_amount');

        $this->validateBizContentOne(
            'out_trade_no',
            'trade_no'
        );
    }
}
