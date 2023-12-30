<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Exception;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\LegacyAppPurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class LegacyAppPurchaseRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/doc.htm?treeId=59&articleId=103663&docType=1
 */
final class LegacyAppPurchaseRequest extends AbstractLegacyRequest
{
    protected string $service = 'mobile.securitypay.pay';

    protected $privateKey;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     *
     * @throws Exception
     */
    public function getData(): array
    {
        $this->validateParams();

        $params = $this->getParamsToSign();

        $signer = new Signer($params);
        $sign = $signer->signWithRSA($this->privateKey);
        $resp = [];

        $resp['order_string'] = sprintf(
            '%s&sign="%s"&sign_type="RSA"',
            $signer->getContentToSign(),
            urlencode($sign)
        );

        return $resp;
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
        return $this->response = new LegacyAppPurchaseResponse($this, $data);
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

    public function getSignType(): mixed
    {
        return $this->getParameter('sign_type');
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
    public function setNotifyUrl($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('notify_url', $value);
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
    public function setAppId($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('app_id', $value);
    }

    public function getAppEnv(): mixed
    {
        return $this->getParameter('appenv');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppEnv($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('appenv', $value);
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
    public function setOutTradeNo($value): LegacyAppPurchaseRequest
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
    public function setSubject($value): LegacyAppPurchaseRequest
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

    public function getSellerId(): mixed
    {
        return $this->getParameter('seller_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerId($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('seller_id', $value);
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
    public function setTotalFee($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('total_fee', $value);
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
    public function setBody($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('body', $value);
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
    public function setGoodsType($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('goods_type', $value);
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
    public function setHbFqParam($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('hb_fq_param', $value);
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
    public function setRnCheck($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('rn_check', $value);
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
    public function setItBPay($value): LegacyAppPurchaseRequest
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
    public function setExternToken($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('extern_token', $value);
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
    public function setPromoParams($value): LegacyAppPurchaseRequest
    {
        return $this->setParameter('promo_params', $value);
    }

    public function getPrivateKey(): mixed
    {
        return $this->privateKey;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setPrivateKey($value): mixed
    {
        return $this->privateKey = $value;
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
            'notify_url',
            'out_trade_no',
            'subject',
            'total_fee',
            'payment_type'
        );
    }

    private function getParamsToSign(): array
    {
        $params = $this->parameters->all();
        $params['service'] = $this->service;

        $params = array_filter($params, 'strlen');

        return array_map(
            static function ($v) {
                return sprintf('"%s"', $v);
            },
            $params
        );
    }
}
