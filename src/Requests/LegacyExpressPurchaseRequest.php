<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyExpressPurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class LegacyExpressPurchaseRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/doc.htm?treeId=108&articleId=104743&docType=1
 */
final class LegacyExpressPurchaseRequest extends AbstractLegacyRequest
{
    protected string $service = 'create_direct_pay_by_user';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validateParams();

        $data = $this->filter($this->parameters->all());

        $data['service'] = $this->service;
        $data['sign'] = $this->sign($data, $this->getSignType());
        $data['sign_type'] = $this->getSignType();

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        return $this->response = new LegacyExpressPurchaseResponse($this, $data);
    }

    public function getOutTradeNo(): mixed
    {
        return $this->getParameter('out_trade_no');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOutTradeNo($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('out_trade_no', $value);
    }

    public function getSubject(): mixed
    {
        return $this->getParameter('subject');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSubject($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('subject', $value);
    }

    public function getPaymentType(): mixed
    {
        return $this->getParameter('payment_type');
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setPaymentType($value): AbstractLegacyRequest
    {
        return $this->setParameter('payment_type', $value);
    }

    public function getTotalFee(): mixed
    {
        return $this->getParameter('total_fee');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setTotalFee($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('total_fee', $value);
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
    public function setSellerId($value): LegacyExpressPurchaseRequest
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
    public function setSellerEmail($value): LegacyExpressPurchaseRequest
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
    public function setSellerAccountName($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('seller_account_name', $value);
    }

    public function getBuyerId(): mixed
    {
        return $this->getParameter('buyer_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBuyerId($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('buyer_id', $value);
    }

    public function getBuyerEmail(): mixed
    {
        return $this->getParameter('buyer_email');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBuyerEmail($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('buyer_email', $value);
    }

    public function getBuyerAccountName(): mixed
    {
        return $this->getParameter('buyer_account_name');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBuyerAccountName($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('buyer_account_name', $value);
    }

    public function getPrice(): mixed
    {
        return $this->getParameter('price');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrice($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('price', $value);
    }

    public function getQuantity(): mixed
    {
        return $this->getParameter('quantity');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setQuantity($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('quantity', $value);
    }

    public function getBody(): mixed
    {
        return $this->getParameter('body');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBody($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('body', $value);
    }

    public function getShowUrl(): mixed
    {
        return $this->getParameter('show_url');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setShowUrl($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('show_url', $value);
    }

    public function getPayMethod(): mixed
    {
        return $this->getParameter('paymethod');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPayMethod($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('paymethod', $value);
    }

    public function getEnablePayMethod(): mixed
    {
        return $this->getParameter('enable_paymethod');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setEnablePayMethod($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('enable_paymethod', $value);
    }

    public function getAntiPhishingKey(): mixed
    {
        return $this->getParameter('anti_phishing_key');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAntiPhishingKey($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('anti_phishing_key', $value);
    }

    public function getExterInvokeIp(): mixed
    {
        return $this->getParameter('exter_invoke_ip');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setExterInvokeIp($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('exter_invoke_ip', $value);
    }

    public function getExtraCommonParam(): mixed
    {
        return $this->getParameter('extra_common_param');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setExtraCommonParam($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('extra_common_param', $value);
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
    public function setItBPay($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('it_b_pay', $value);
    }

    public function getToken(): mixed
    {
        return $this->getParameter('token');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setToken($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('token', $value);
    }

    public function getQrPayMode(): mixed
    {
        return $this->getParameter('qr_pay_mode');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setQrPayMode($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('qr_pay_mode', $value);
    }

    public function getQrcodeWidth(): mixed
    {
        return $this->getParameter('qrcode_width');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setQrcodeWidth($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('qrcode_width', $value);
    }

    public function getNeedBuyerRealnamed(): mixed
    {
        return $this->getParameter('need_buyer_realnamed');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setNeedBuyerRealnamed($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('need_buyer_realnamed', $value);
    }

    public function getHbFqParam(): mixed
    {
        return $this->getParameter('hb_fq_param');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setHbFqParam($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('hb_fq_param', $value);
    }

    public function getGoodsType(): mixed
    {
        return $this->getParameter('goods_type');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setGoodsType($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('goods_type', $value);
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
    public function setReturnUrl($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('return_url', $value);
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
    public function setNotifyUrl($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('notify_url', $value);
    }

    public function getDefaultbank(): mixed
    {
        return $this->getParameter('defaultbank');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setDefaultbank($value): LegacyExpressPurchaseRequest
    {
        return $this->setParameter('defaultbank', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    protected function validateParams(): void
    {
        $this->validate(
            '_input_charset',
            'out_trade_no',
            'subject',
            'payment_type',
            'total_fee'
        );

        $this->validateOne(
            'seller_id',
            'seller_email',
            'seller_account_name'
        );
    }
}
