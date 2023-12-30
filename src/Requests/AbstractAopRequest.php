<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Exception;
use Omnipay\Alipay\Common\Signer;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractAopRequest extends AbstractRequest
{
    protected string $method;

    protected $privateKey;

    protected $encryptKey;

    protected $alipayPublicKey;

    protected $alipayRootCert;

    protected $appCert;

    protected bool $checkAlipayPublicCert = true;

    protected string $endpoint = 'https://openapi.alipay.com/gateway.do';

    protected bool $returnable = false;

    protected bool $notifiable = false;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     *
     * @throws InvalidRequestException
     */
    public function getData(): mixed
    {
        $this->validateParams();
        $this->getCertSN();
        $this->setDefaults();
        $this->convertToString();
        $data = $this->getParameters();
        $data['method'] = $this->method;
        ksort($data);
        $data['sign'] = $this->sign($data, $this->getSignType());

        return $data;
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateParams(): void
    {
        $this->validate(
            'app_id',
            'format',
            'charset',
            'sign_type',
            'timestamp',
            'version',
            'biz_content'
        );
    }

    public function getCertSN(): void
    {
        if (strtoupper($this->getSignType()) === 'RSA2') {
            $alipayRootCert = $this->getAlipayRootCert();
            $appCert = $this->getAppCert();

            if (is_file($alipayRootCert) && is_file($appCert)) {
                $this->setParameter('alipay_root_cert_sn', getRootCertSN($alipayRootCert));
                $this->setParameter('app_cert_sn', getCertSN($appCert));
            }
        }
    }

    public function getSignType(): mixed
    {
        return $this->getParameter('sign_type');
    }

    public function getAlipayRootCert(): mixed
    {
        return $this->alipayRootCert;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAlipayRootCert($value): AbstractAopRequest
    {
        $this->alipayRootCert = $value;

        return $this;
    }

    public function getAppCert(): mixed
    {
        return $this->appCert;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setAppCert($value): AbstractAopRequest
    {
        $this->appCert = $value;

        return $this;
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
    public function setTimestamp($value): AbstractAopRequest
    {
        return $this->setParameter('timestamp', $value);
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
    public function setPrivateKey($value): AbstractAopRequest
    {
        $this->privateKey = $value;

        return $this;
    }

    public function getCheckAlipayPublicCert(): bool
    {
        return $this->checkAlipayPublicCert;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setCheckAlipayPublicCert(bool $value): AbstractAopRequest
    {
        $this->checkAlipayPublicCert = $value;

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
    public function setAlipayPublicKey($value): AbstractAopRequest
    {
        $this->alipayPublicKey = $value;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return mixed|ResponseInterface|StreamInterface
     *
     * @throws NetworkException
     */
    public function sendData($data): mixed
    {
        $method = $this->getRequestMethod();
        $url = $this->getRequestUrl($data);
        $body = $this->getRequestBody();

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = $this->httpClient->request($method, $url, $headers, $body);

        return $this->decode($response->getBody());
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setEndpoint($value): AbstractAopRequest
    {
        $this->endpoint = $value;

        return $this;
    }

    public function getBizContent(): mixed
    {
        return $this->getParameter('biz_content');
    }

    /**
     * @param null $key
     * @param null $default
     *
     * @return mixed
     */
    public function getBizData($key = null, $default = null): mixed
    {
        if (is_string($this->getBizContent())) {
            $data = json_decode($this->getBizContent(), true);
        } else {
            $data = $this->getBizContent();
        }

        if (is_null($key)) {
            return $data;
        }
        return array_get($data, $key, $default);
    }

    public function getAppId(): mixed
    {
        return $this->getParameter('app_id');
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setAppId($value): AbstractAopRequest
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
     * @return AbstractAopRequest
     */
    public function setFormat($value): AbstractAopRequest
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
     * @return AbstractAopRequest
     */
    public function setCharset($value): AbstractAopRequest
    {
        return $this->setParameter('charset', $value);
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setSignType($value): AbstractAopRequest
    {
        return $this->setParameter('sign_type', $value);
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setBizContent($value): AbstractAopRequest
    {
        return $this->setParameter('biz_content', $value);
    }

    public function getAlipaySdk(): mixed
    {
        return $this->getParameter('alipay_sdk');
    }

    /**
     * @param $value
     *
     * @return AbstractAopRequest
     */
    public function setAlipaySdk($value): AbstractAopRequest
    {
        return $this->setParameter('alipay_sdk', $value);
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
    public function setNotifyUrl($value): AbstractAopRequest
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
    public function setReturnUrl($value): AbstractAopRequest
    {
        return $this->setParameter('return_url', $value);
    }

    public function getEncryptKey(): mixed
    {
        return $this->encryptKey;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setEncryptKey($value): AbstractAopRequest
    {
        $this->encryptKey = $value;

        return $this;
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
    public function setVersion($value): AbstractAopRequest
    {
        return $this->setParameter('version', $value);
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
    public function setAppAuthToken($value): AbstractAopRequest
    {
        return $this->setParameter('app_auth_token', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateBizContent(): void
    {
        $data = $this->getBizContent();

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        foreach (func_get_args() as $key) {
            if (! array_has($data, $key)) {
                throw new InvalidRequestException("The biz_content {$key} parameter is required");
            }
        }
    }

    /**
     * @throws InvalidRequestException
     */
    public function validateBizContentOne(): void
    {
        $data = $this->getBizContent();

        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $keys = func_get_args();

        $allEmpty = true;

        foreach ($keys as $key) {
            if (array_has($data, $key)) {
                $allEmpty = false;
                break;
            }
        }

        if ($allEmpty) {
            throw new InvalidRequestException(
                sprintf('The biz_content (%s) parameter must provide one at least', implode(',', $keys))
            );
        }
    }

    protected function setDefaults(): void
    {
        if (! $this->getTimestamp()) {
            $this->setTimestamp(date('Y-m-d H:i:s'));
        }
    }

    protected function convertToString(): void
    {
        foreach ($this->parameters->all() as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $this->parameters->set($key, json_encode($value));
            }
        }
    }

    /**
     * @param array $params
     * @param string $signType
     *
     * @return string|null
     *
     * @throws Exception
     * @throws InvalidRequestException
     */
    protected function sign(array $params, string $signType): ?string
    {
        $signer = new Signer($params);

        $signType = strtoupper($signType);

        if ($signType === 'RSA') {
            $sign = $signer->signWithRSA($this->getPrivateKey());
        } elseif ($signType === 'RSA2') {
            $sign = $signer->signWithRSA($this->getPrivateKey(), OPENSSL_ALGO_SHA256);
        } else {
            throw new InvalidRequestException('The sign type is invalid');
        }

        return $sign;
    }

    protected function getRequestMethod(): string
    {
        return 'POST';
    }

    /**
     * @param $data
     *
     * @return string
     */
    protected function getRequestUrl($data): string
    {
        $queryParams = $data;

        unset($queryParams['biz_content']);
        ksort($queryParams);

        return sprintf('%s?%s', $this->getEndpoint(), http_build_query($queryParams));
    }

    protected function getRequestBody(): string
    {
        $params = [
            'biz_content' => $this->getBizContent(),
        ];

        return http_build_query($params);
    }

    protected function decode($data)
    {
        return json_decode((string) $data, true);
    }

    protected function filter($data): void
    {
        if (! $this->returnable) {
            unset($data['return_url']);
        }

        if (! $this->notifiable) {
            unset($data['notify_url']);
        }
    }

    /**
     * @throws InvalidRequestException
     */
    protected function validateOne(): void
    {
        $keys = func_get_args();

        if ($keys && is_array($keys[0])) {
            $keys = $keys[0];
        }

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
}
