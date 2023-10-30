<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTransferToAccountQueryResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class AopTransferToAccountQueryRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://docs.open.alipay.com/api_28/alipay.fund.trans.order.query
 */
final class AopTransferToAccountQueryRequest extends AbstractAopRequest
{
    protected $method = 'alipay.fund.trans.order.query';

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

        return $this->response = new AopTransferToAccountQueryResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContentOne(
            'out_biz_no',
            'order_id'
        );
    }
}
