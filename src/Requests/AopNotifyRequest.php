<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Exception;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Alipay\Responses\AopNotifyResponse;
use Omnipay\Alipay\Responses\VerifyNotifyIdResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

final class AopNotifyRequest extends AbstractAopRequest
{
    /**
     * @var ParameterBag
     */
    public ParameterBag $params;

    protected bool $verifyNotifyId = false;

    protected bool $sort = true;

    protected string $encodePolicy = 'QUERY';

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
        $this->initParams();

        $this->validateParams();

        return $this->params->all();
    }

    public function getParams(): mixed
    {
        return $this->getParameter('params');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setParams($value): AopNotifyRequest
    {
        return $this->setParameter('params', $value);
    }

    public function validateParams(): void
    {
        if (empty($this->params->all())) {
            throw new InvalidRequestException('The `params` or $_REQUEST is empty');
        }

        if (! $this->params->has('sign_type')) {
            throw new InvalidRequestException('The `sign_type` is required');
        }

        if (! $this->params->has('sign')) {
            throw new InvalidRequestException('The `sign` is required');
        }
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     *
     * @throws InvalidRequestException
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $this->verifySignature();

        if ($this->params->has('notify_id')) {
            if ($this->verifyNotifyId) {
                $this->verifyNotifyId();
            }
        }

        return $this->response = new AopNotifyResponse($this, $data);
    }

    public function setSort(bool $sort): AopNotifyRequest
    {
        $this->sort = $sort;

        return $this;
    }

    public function setEncodePolicy(string $encodePolicy): AopNotifyRequest
    {
        $this->encodePolicy = $encodePolicy;

        return $this;
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
    public function setPartner($value): AopNotifyRequest
    {
        return $this->setParameter('partner', $value);
    }

    public function setVerifyNotifyId(bool $value): AopNotifyRequest
    {
        $this->verifyNotifyId = $value;

        return $this;
    }

    /**
     * @throws InvalidRequestException
     * @throws Exception
     */
    protected function verifySignature(): void
    {
        $signer = new Signer($this->params->all());
        $signer->setSort($this->sort);
        $signer->setEncodePolicy($this->encodePolicy);
        $signer->setIgnores(['sign', 'sign_type']);
        $content = $signer->getContentToSign();

        $sign = $this->params->get('sign');
        $signType = $this->params->get('sign_type');

        if ($signType === 'RSA2') {
            $match = (new Signer())->verifyWithRSA($content, $sign, $this->getAlipayPublicKey(), OPENSSL_ALGO_SHA256);
        } else {
            $match = (new Signer())->verifyWithRSA($content, $sign, $this->getAlipayPublicKey());
        }

        if (! $match) {
            throw new InvalidRequestException('The signature is not match');
        }
    }

    /**
     * @throws InvalidRequestException
     */
    protected function verifyNotifyId(): void
    {
        if (! $this->getPartner()) {
            throw new InvalidRequestException('The partner is required for notify_id verify');
        }

        $request = new LegacyVerifyNotifyIdRequest($this->httpClient, $this->httpRequest);
        $request->setPartner($this->getPartner());
        $request->setNotifyId($this->params->get('notify_id'));

        /**
         * @var VerifyNotifyIdResponse $response
         */
        $response = $request->send();

        if (! $response->isSuccessful()) {
            throw new InvalidRequestException('The notify_id is not trusted');
        }
    }

    private function initParams(): void
    {
        $params = $this->getParams();

        if (! $params) {
            $params = array_merge($_GET, $_POST);
        }

        $this->params = new ParameterBag($params);
    }
}
