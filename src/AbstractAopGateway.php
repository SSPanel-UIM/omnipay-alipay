<?php

declare(strict_types=1);

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopCompletePurchaseRequest;
use Omnipay\Alipay\Requests\AopCompleteRefundRequest;
use Omnipay\Alipay\Requests\AopTradeCancelRequest;
use Omnipay\Alipay\Requests\AopTradeCloseRequest;
use Omnipay\Alipay\Requests\AopTradeOrderSettleRequest;
use Omnipay\Alipay\Requests\AopTradeQueryRequest;
use Omnipay\Alipay\Requests\AopTradeRefundQueryRequest;
use Omnipay\Alipay\Requests\AopTradeRefundRequest;
use Omnipay\Alipay\Requests\AopTransferToAccountQueryRequest;
use Omnipay\Alipay\Requests\AopTransferToAccountRequest;
use Omnipay\Alipay\Requests\DataServiceBillDownloadUrlQueryRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractAopGateway extends AbstractGateway
{
    protected array $endpoints = [
        'production' => 'https://openapi.alipay.com/gateway.do',
        'sandbox' => 'https://openapi.alipaydev.com/gateway.do',
    ];

    public function getDefaultParameters(): array
    {
        return [
            'format' => 'JSON',
            'charset' => 'UTF-8',
            'signType' => 'RSA',
            'version' => '1.0',
            'timestamp' => date('Y-m-d H:i:s'),
            'alipaySdk' => 'lokielse/omnipay-alipay',
        ];
    }

    public function getAppId(): mixed
    {
        return $this->getParameter('app_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppId($value): static
    {
        return $this->setParameter('app_id', $value);
    }

    public function getFormat(): mixed
    {
        return $this->getParameter('format');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setFormat($value): static
    {
        return $this->setParameter('format', $value);
    }

    public function getCharset(): mixed
    {
        return $this->getParameter('charset');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setCharset($value): static
    {
        return $this->setParameter('charset', $value);
    }

    public function getSignType(): mixed
    {
        return $this->getParameter('sign_type');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSignType($value): static
    {
        return $this->setParameter('sign_type', $value);
    }

    public function getVersion(): mixed
    {
        return $this->getParameter('version');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setVersion($value): static
    {
        return $this->setParameter('version', $value);
    }

    public function getPrivateKey(): mixed
    {
        return $this->getParameter('private_key');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value): static
    {
        return $this->setParameter('private_key', $value);
    }

    public function getAlipayRootCert(): mixed
    {
        return $this->getParameter('alipay_root_cert');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipayRootCert($value): static
    {
        return $this->setParameter('alipay_root_cert', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipayPublicCert($value): static
    {
        $this->setParameter('alipay_public_key', getPublicKey($value));

        return $this->setParameter('alipay_public_cert', $value);
    }

    public function getAppCert(): mixed
    {
        return $this->getParameter('app_cert');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppCert($value): static
    {
        return $this->setParameter('app_cert', $value);
    }

    public function getCheckAlipayPublicCert(): mixed
    {
        return $this->getParameter('check_alipay_public_cert');
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setCheckAlipayPublicCert(bool $value): static
    {
        return $this->setParameter('check_alipay_public_cert', $value);
    }

    public function getEncryptKey(): mixed
    {
        return $this->getParameter('encrypt_key');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setEncryptKey($value): static
    {
        return $this->setParameter('encrypt_key', $value);
    }

    public function getNotifyUrl(): mixed
    {
        return $this->getParameter('notify_url');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyUrl($value): static
    {
        return $this->setParameter('notify_url', $value);
    }

    public function getTimestamp(): mixed
    {
        return $this->getParameter('timestamp');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setTimestamp($value): static
    {
        return $this->setParameter('timestamp', $value);
    }

    public function getAppAuthToken(): mixed
    {
        return $this->getParameter('app_auth_token');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppAuthToken($value): static
    {
        return $this->setParameter('app_auth_token', $value);
    }

    public function getSysServiceProviderId(): mixed
    {
        return $this->getParameter('sys_service_provider_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSysServiceProviderId($value): static
    {
        return $this->setParameter('sys_service_provider_id', $value);
    }

    public function getAlipayPublicKey(): mixed
    {
        return $this->getParameter('alipay_public_key');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipayPublicKey($value): static
    {
        // prevent public key overlay when certificate exist
        if (! $this->getAlipayPublicCert()) {
            return $this->setParameter('alipay_public_key', $value);
        }

        return $this;
    }

    public function getAlipayPublicCert(): mixed
    {
        return $this->getParameter('alipay_public_cert');
    }

    public function getEndpoint(): mixed
    {
        return $this->getParameter('endpoint');
    }

    public function getAlipaySdk(): mixed
    {
        return $this->getParameter('alipay_sdk');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipaySdk($value): static
    {
        return $this->setParameter('alipay_sdk', $value);
    }

    /**
     * @return AbstractAopGateway
     *
     * @throws InvalidRequestException
     */
    public function production(): static
    {
        return $this->setEnvironment('production');
    }

    /**
     * @param $value
     *
     * @return $this
     *
     * @throws InvalidRequestException
     */
    public function setEnvironment($value): static
    {
        $env = strtolower($value);

        if (! isset($this->endpoints[$env])) {
            throw new InvalidRequestException('The environment is invalid');
        }

        $this->setEndpoint($this->endpoints[$env]);

        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setEndpoint($value): static
    {
        return $this->setParameter('endpoint', $value);
    }

    /**
     * @return AbstractAopGateway
     *
     * @throws InvalidRequestException
     */
    public function sandbox(): static
    {
        return $this->setEnvironment('sandbox');
    }

    /**
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     *
     * @throws InvalidRequestException
     */
    public function completePurchase(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopCompletePurchaseRequest::class, $parameters);
    }

    /**
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     *
     * @throws InvalidRequestException
     */
    public function completeRefund(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopCompleteRefundRequest::class, $parameters);
    }

    /**
     * Query Order Status
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function query(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeQueryRequest::class, $parameters);
    }

    /**
     * Refund
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function refund(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeRefundRequest::class, $parameters);
    }

    /**
     * Query Refund Status
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function refundQuery(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeRefundQueryRequest::class, $parameters);
    }

    /**
     * Close Order
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function close(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeCloseRequest::class, $parameters);
    }

    /**
     * Cancel Order
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function cancel(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeCancelRequest::class, $parameters);
    }

    /**
     * Transfer To Account
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function transfer(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTransferToAccountRequest::class, $parameters);
    }

    /**
     * Query Transfer Status
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function transferQuery(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTransferToAccountQueryRequest::class, $parameters);
    }

    /**
     * Settle
     *
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function settle(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeOrderSettleRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function queryBillDownloadUrl(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(DataServiceBillDownloadUrlQueryRequest::class, $parameters);
    }
}
