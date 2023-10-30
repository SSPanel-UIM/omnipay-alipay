<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradePreCreateResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Psr\Http\Client\Exception\NetworkException;
use Psr\Http\Client\Exception\RequestException;

/**
 * Class AopTradePreCreateRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=862
 */
final class AopTradePreCreateRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.precreate';

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     *
     * @throws NetworkException
     * @throws RequestException
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data = parent::sendData($data);

        return $this->response = new AopTradePreCreateResponse($this, $data);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent(
            'out_trade_no',
            'total_amount',
            'subject'
        );
    }
}
