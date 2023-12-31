<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeCloseResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTradeCloseRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/doc2/apiDetail.htm?apiId=1058&docType=4
 */
final class AopTradeCloseRequest extends AbstractAopRequest
{
    protected string $method = 'alipay.trade.close';

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

        return $this->response = new AopTradeCloseResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContentOne(
            'out_trade_no',
            'trade_no'
        );
    }
}
