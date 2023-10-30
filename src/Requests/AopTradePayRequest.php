<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\AopTradeCancelResponse;
use Omnipay\Alipay\Responses\AopTradePayResponse;
use Omnipay\Alipay\Responses\AopTradeQueryResponse;
use Psr\Http\Client\Exception\NetworkException;
use Psr\Http\Client\Exception\RequestException;

/**
 * Class AopTradePayRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/api.htm?docType=4&apiId=850
 */
final class AopTradePayRequest extends AbstractAopRequest
{
    protected $method = 'alipay.trade.pay';

    protected bool $notifiable = true;

    protected bool $polling = true;

    protected int $pollingWait = 3;

    protected int $pollingAttempts = 10;

    /**
     * @var AopTradePayResponse|AopTradeQueryResponse|AopTradeCancelResponse
     */
    protected $response;

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return AopTradePayResponse|AopTradeQueryResponse
     *
     * @throws NetworkException
     * @throws RequestException
     */
    public function sendData(mixed $data): AopTradePayResponse|AopTradeQueryResponse
    {
        $data = parent::sendData($data);

        $this->response = new AopTradePayResponse($this, $data);

        if ($this->response->isWaitPay() && $this->polling) {
            $this->polling();
        }

        return $this->response;
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent(
            'out_trade_no',
            'scene',
            'auth_code',
            'subject'
        );

        $this->validateBizContentOne(
            'total_amount',
            'discountable_amount',
            'undiscountable_amount'
        );
    }

    public function setPolling(bool $polling): AopTradePayRequest
    {
        $this->polling = $polling;

        return $this;
    }

    public function setPollingWait(int $pollingWait): AopTradePayRequest
    {
        $this->pollingWait = $pollingWait;

        return $this;
    }

    public function setPollingAttempts(int $pollingAttempts): AopTradePayRequest
    {
        $this->pollingAttempts = $pollingAttempts;

        return $this;
    }

    /**
     * @link https://img.alicdn.com/top/i1/LB14VRALXXXXXcnXXXXXXXXXXXX
     */
    protected function polling(): void
    {
        $currentAttempt = 0;

        while ($currentAttempt++ < $this->pollingAttempts) {
            /**
             * Query Order Trade Status
             */
            $this->query();

            if ($this->response->getCode() >= 40000) {
                break;
            }
            if ($this->response->isPaid()) {
                break;
            }
            if ($this->response->isClosed()) {
                break;
            }

            sleep($this->pollingWait);
        }

        /**
         * Close Order
         */
        if ($this->response->isWaitPay()) {
            $this->cancel();
        }
    }

    protected function query(): void
    {
        $request = new AopTradeQueryRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setEndpoint($this->getEndpoint());
        $request->setPrivateKey($this->getPrivateKey());
        $request->setBizContent(
            ['out_trade_no' => $this->getBizData('out_trade_no')]
        );

        $this->response = $request->send();
    }

    protected function cancel(): void
    {
        $request = new AopTradeCancelRequest($this->httpClient, $this->httpRequest);
        $request->initialize($this->parameters->all());
        $request->setEndpoint($this->getEndpoint());
        $request->setPrivateKey($this->getPrivateKey());
        $request->setBizContent(
            ['out_trade_no' => $this->getBizData('out_trade_no')]
        );

        $this->response = $request->send();
    }
}
