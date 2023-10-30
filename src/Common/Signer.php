<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Common;

use Exception;

/**
 * Sign Tool for Alipay
 * Class Signer
 *
 * @package Omnipay\Alipay\Common
 */
final class Signer
{
    public const ENCODE_POLICY_QUERY = 'QUERY';
    public const ENCODE_POLICY_JSON = 'JSON';

    public const KEY_TYPE_PUBLIC = 1;
    public const KEY_TYPE_PRIVATE = 2;

    private array $ignores = ['sign', 'sign_type'];

    private bool $sort = true;

    private string $encodePolicy = self::ENCODE_POLICY_QUERY;

    /**
     * @var array
     */
    private array $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function signWithMD5($key): string
    {
        $content = $this->getContentToSign();

        return md5($content . $key);
    }

    public function getContentToSign(): false|string|null
    {
        $params = $this->getParamsToSign();

        if ($this->encodePolicy === self::ENCODE_POLICY_QUERY) {
            return urldecode(http_build_query($params));
        }
        if ($this->encodePolicy === self::ENCODE_POLICY_JSON) {
            return json_encode($params);
        }
        return null;
    }

    /**
     * @return array
     */
    public function getParamsToSign(): array
    {
        $params = $this->params;

        $this->unsetKeys($params);

        $params = $this->filter($params);

        if ($this->sort) {
            $this->sort($params);
        }

        return $params;
    }

    /**
     * @return array
     */
    public function getIgnores(): array
    {
        return $this->ignores;
    }

    /**
     * @param array $ignores
     *
     * @return $this
     */
    public function setIgnores(array $ignores): Signer
    {
        $this->ignores = $ignores;

        return $this;
    }

    /**
     * @param string $privateKey
     * @param int $alg
     *
     * @return string
     *
     * @throws Exception
     */
    public function signWithRSA(string $privateKey, int $alg = OPENSSL_ALGO_SHA1): string
    {
        $content = $this->getContentToSign();

        return $this->signContentWithRSA($content, $privateKey, $alg);
    }

    /**
     * @param string $content
     * @param string $privateKey
     * @param int $alg
     *
     * @return string
     *
     * @throws Exception
     */
    public function signContentWithRSA(string $content, string $privateKey, int $alg = OPENSSL_ALGO_SHA1): string
    {
        $privateKey = $this->prefix($privateKey);
        $privateKey = $this->format($privateKey, self::KEY_TYPE_PRIVATE);
        $res = openssl_pkey_get_private($privateKey);

        $sign = null;

        try {
            openssl_sign($content, $sign, $res, $alg);
        } catch (Exception $e) {
            if ($e->getCode() === 2) {
                $message = $e->getMessage();
                $message .= "\n应用私钥格式有误，见 https://github.com/lokielse/omnipay-alipay/wiki/FAQs";
                throw new Exception($message, $e->getCode(), $e);
            }
        }

        return base64_encode((string) $sign);
    }

    /**
     * Convert key to standard format
     *
     * @param $key
     * @param $type
     *
     * @return string
     */
    public function format($key, $type): string
    {
        if (is_file($key)) {
            $key = file_get_contents($key);
        }

        if (is_string($key) && ! str_contains($key, '-----')) {
            $key = $this->convertKey($key, $type);
        }

        return $key;
    }

    /**
     * Convert one line key to standard format
     *
     * @param string $key
     * @param int $type
     *
     * @return string
     */
    public function convertKey(string $key, int $type): string
    {
        $lines = [];

        if ($type === self::KEY_TYPE_PUBLIC) {
            $lines[] = '-----BEGIN PUBLIC KEY-----';
        } else {
            $lines[] = '-----BEGIN RSA PRIVATE KEY-----';
        }

        for ($i = 0; $i < strlen($key); $i += 64) {
            $lines[] = trim(substr($key, $i, 64));
        }

        if ($type === self::KEY_TYPE_PUBLIC) {
            $lines[] = '-----END PUBLIC KEY-----';
        } else {
            $lines[] = '-----END RSA PRIVATE KEY-----';
        }

        return implode("\n", $lines);
    }

    public function verifyWithMD5($content, $sign, $key): bool
    {
        return md5($content . $key) === $sign;
    }

    /**
     * @param string $content
     * @param string $sign
     * @param string $publicKey
     * @param int $alg
     *
     * @return bool
     *
     * @throws Exception
     */
    public function verifyWithRSA(string $content, string $sign, string $publicKey, int $alg = OPENSSL_ALGO_SHA1): bool
    {
        $publicKey = $this->prefix($publicKey);
        $publicKey = $this->format($publicKey, self::KEY_TYPE_PUBLIC);

        $res = openssl_pkey_get_public($publicKey);

        if (! $res) {
            $message = "The public key is invalid";
            $message .= "\n支付宝公钥格式有误，见 https://github.com/lokielse/omnipay-alipay/wiki/FAQs";
            throw new Exception($message);
        }

        return (bool) openssl_verify($content, base64_decode($sign), $res, $alg);
    }

    public function setSort(bool $sort): Signer
    {
        $this->sort = $sort;

        return $this;
    }

    public function setEncodePolicy(string $encodePolicy): Signer
    {
        $this->encodePolicy = $encodePolicy;

        return $this;
    }

    /**
     * @param $params
     */
    private function unsetKeys(&$params): void
    {
        foreach ($this->getIgnores() as $key) {
            unset($params[$key]);
        }
    }

    private function filter($params): array
    {
        return array_filter($params);
    }

    /**
     * @param $params
     */
    private function sort(&$params): void
    {
        ksort($params);
    }

    /**
     * Prefix the key path with 'file://'
     *
     * @param $key
     *
     * @return string
     */
    private function prefix($key): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' && is_file($key) && ! str_starts_with($key, 'file://')) {
            $key = 'file://' . $key;
        }

        return $key;
    }
}
