<?php

declare(strict_types=1);

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\LegacyCompletePurchaseRequest;
use Omnipay\Alipay\Requests\LegacyCompleteRefundRequest;
use Omnipay\Alipay\Requests\LegacyQueryRequest;
use Omnipay\Alipay\Requests\LegacyRefundRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractLegacyGateway extends AbstractGateway
{
    public function getDefaultParameters(): array
    {
        return [
            'inputCharset' => 'UTF-8',
            'signType' => 'MD5',
            'paymentType' => '1',
            'alipaySdk' => 'lokielse/omnipay-alipay',
        ];
    }

    public function getPartner(): mixed
    {
        return $this->getParameter('partner');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPartner($value): static
    {
        return $this->setParameter('partner', $value);
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

    public function getPaymentType(): mixed
    {
        return $this->getParameter('payment_type');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPaymentType($value): static
    {
        return $this->setParameter('payment_type', $value);
    }

    public function getKey(): mixed
    {
        return $this->getParameter('key');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setKey($value): static
    {
        return $this->setParameter('key', $value);
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
        return $this->setParameter('alipay_public_key', $value);
    }

    public function getSellerId(): mixed
    {
        return $this->getParameter('seller_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerId($value): static
    {
        return $this->setParameter('seller_id', $value);
    }

    public function getSellerEmail(): mixed
    {
        return $this->getParameter('seller_email');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerEmail($value): static
    {
        return $this->setParameter('seller_email', $value);
    }

    public function getSellerAccountName(): mixed
    {
        return $this->getParameter('seller_account_name');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerAccountName($value): static
    {
        return $this->setParameter('seller_account_name', $value);
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

    public function getReturnUrl(): mixed
    {
        return $this->getParameter('return_url');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setReturnUrl($value): static
    {
        return $this->setParameter('return_url', $value);
    }

    public function getInputCharset(): mixed
    {
        return $this->getParameter('_input_charset');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setInputCharset($value): static
    {
        return $this->setParameter('_input_charset', $value);
    }

    public function getItBPay(): mixed
    {
        return $this->getParameter('it_b_pay');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setItBPay($value): static
    {
        return $this->setParameter('it_b_pay', $value);
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
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function completePurchase(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(LegacyCompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function refund(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(LegacyRefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function completeRefund(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(LegacyCompleteRefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function query(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(LegacyQueryRequest::class, $parameters);
    }
}
