<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeQueryResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTradeQueryRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=757
 */
final class AopTradeQueryRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.query';

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

        return $this->response = new AopTradeQueryResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContentOne(
            'trade_no',
            'out_trade_no'
        );
    }
}
