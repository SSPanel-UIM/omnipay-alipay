<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyWapPurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class LegacyWapPurchaseRequest
 *
 * @package   Omnipay\Alipay\Requests
 *
 * @link      https://doc.open.alipay.com/docs/doc.htm?treeId=60&articleId=104790&docType=1
 */
final class LegacyWapPurchaseRequest extends AbstractLegacyRequest
{
    protected string $service = 'alipay.wap.create.direct.pay.by.user';

    protected $key;

    protected $privateKey;

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

    public function getSignType(): mixed
    {
        return $this->getParameter('sign_type');
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
        return $this->response = new LegacyWapPurchaseResponse($this, $data);
    }

    public function getPartner(): mixed
    {
        return $this->getParameter('partner');
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setPartner($value): AbstractLegacyRequest
    {
        return $this->setParameter('partner', $value);
    }

    public function getInputCharset(): mixed
    {
        return $this->getParameter('_input_charset');
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setInputCharset($value): AbstractLegacyRequest
    {
        return $this->setParameter('_input_charset', $value);
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setSignType($value): AbstractLegacyRequest
    {
        return $this->setParameter('sign_type', $value);
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
    public function setNotifyUrl($value): LegacyWapPurchaseRequest
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
    public function setReturnUrl($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('return_url', $value);
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
    public function setOutTradeNo($value): LegacyWapPurchaseRequest
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
    public function setSubject($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('subject', $value);
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
    public function setTotalFee($value): LegacyWapPurchaseRequest
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
    public function setSellerId($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('seller_id', $value);
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

    public function getShowUrl(): mixed
    {
        return $this->getParameter('show_url');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setShowUrl($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('show_url', $value);
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
    public function setBody($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('body', $value);
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
    public function setItBPay($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('it_b_pay', $value);
    }

    public function getExternToken(): mixed
    {
        return $this->getParameter('extern_token');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setExternToken($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('extern_token', $value);
    }

    public function getOtherfee(): mixed
    {
        return $this->getParameter('otherfee');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setOtherfee($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('otherfee', $value);
    }

    public function getAirticket(): mixed
    {
        return $this->getParameter('airticket');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAirticket($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('airticket', $value);
    }

    public function getRnCheck(): mixed
    {
        return $this->getParameter('rn_check');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setRnCheck($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('rn_check', $value);
    }

    public function getBuyerCertNo(): mixed
    {
        return $this->getParameter('buyer_cert_no');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBuyerCertNo($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('buyer_cert_no', $value);
    }

    public function getBuyerRealName(): mixed
    {
        return $this->getParameter('buyer_real_name');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBuyerRealName($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('buyer_real_name', $value);
    }

    public function getScene(): mixed
    {
        return $this->getParameter('scene');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setScene($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('scene', $value);
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
    public function setHbFqParam($value): LegacyWapPurchaseRequest
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
    public function setGoodsType($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('goods_type', $value);
    }

    public function getAppPay(): mixed
    {
        return $this->getParameter('app_pay');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppPay($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('app_pay', $value);
    }

    public function getPromoParams(): mixed
    {
        return $this->getParameter('promo_params');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPromoParams($value): LegacyWapPurchaseRequest
    {
        return $this->setParameter('promo_params', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    protected function validateParams(): void
    {
        $this->validate(
            'partner',
            '_input_charset',
            'sign_type',
            'out_trade_no',
            'subject',
            'total_fee',
            'seller_id',
            'payment_type'
        );
    }
}
