<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Exception;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractLegacyRequest extends AbstractRequest
{
    protected string $endpoint = 'https://mapi.alipay.com/gateway.do';

    protected $service;

    protected mixed $key;

    protected mixed $signType;

    protected mixed $privateKey;

    protected mixed $alipayPublicKey;

    public function getEndpoint(): string
    {
        return $this->endpoint;
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
    public function setPartner($value): mixed
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
     * @return $this
     */
    public function setInputCharset($value): mixed
    {
        return $this->setParameter('_input_charset', $value);
    }

    public function getAlipaySdk(): mixed
    {
        return $this->getParameter('alipay_sdk');
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setAlipaySdk($value): AbstractLegacyRequest
    {
        return $this->setParameter('alipay_sdk', $value);
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
    public function setPaymentType($value): mixed
    {
        return $this->setParameter('payment_type', $value);
    }

    public function getSignType(): mixed
    {
        return $this->signType;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSignType($value): mixed
    {
        $this->signType = $value;

        return $this;
    }

    public function getAlipayPublicKey(): mixed
    {
        return $this->alipayPublicKey;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipayPublicKey($value): mixed
    {
        $this->alipayPublicKey = $value;

        return $this;
    }

    public function getKey(): mixed
    {
        return $this->key;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setKey($value): mixed
    {
        $this->key = $value;

        return $this;
    }

    public function getPrivateKey(): mixed
    {
        return $this->privateKey;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setPrivateKey($value): mixed
    {
        $this->privateKey = $value;

        return $this;
    }

    /**
     * @throws InvalidRequestException
     */
    protected function validateOne(): void
    {
        $keys = func_get_args();

        $allEmpty = true;

        foreach ($keys as $key) {
            $value = $this->parameters->get($key);

            if (! empty($value)) {
                $allEmpty = false;
                break;
            }
        }

        if ($allEmpty) {
            throw new InvalidRequestException(
                sprintf('The parameters (%s) must provide one at least', implode(',', $keys))
            );
        }
    }

    /**
     * @throws InvalidRequestException
     * @throws Exception
     */
    protected function sign($params, $signType): string
    {
        $signer = new Signer($params);

        $signType = strtoupper($signType);

        if ($signType === 'MD5') {
            if (! $this->getKey()) {
                throw new InvalidRequestException('The `key` is required for `MD5` sign_type');
            }

            $sign = $signer->signWithMD5($this->getKey());
        } elseif ($signType === 'RSA') {
            if (! $this->getPrivateKey()) {
                throw new InvalidRequestException('The `private_key` is required for `RSA` sign_type');
            }

            $sign = $signer->signWithRSA($this->getPrivateKey());
        } else {
            throw new InvalidRequestException('The signType is not allowed');
        }

        return $sign;
    }

    protected function filter($data): array
    {
        return array_filter($data, 'strlen');
    }
}
