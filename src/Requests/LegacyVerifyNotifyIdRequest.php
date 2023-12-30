<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\VerifyNotifyIdResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Psr\Http\Client\Exception\NetworkException;
use Psr\Http\Client\Exception\RequestException;

/**
 * https://doc.open.alipay.com/docs/doc.htm?treeId=58&articleId=103597&docType=1
 * Class LegacyVerifyNotifyIdRequest
 *
 * @package Omnipay\Alipay\Requests
 */
final class LegacyVerifyNotifyIdRequest extends AbstractLegacyRequest
{
    protected string $service = 'notify_verify';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     *
     * @throws InvalidRequestException
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'partner',
            'notify_id'
        );

        $data = $this->parameters->all();
        $data['service'] = $this->service;

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     *
     * @throws NetworkException
     * @throws RequestException
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $url = sprintf('%s?%s', $this->getEndpoint(), http_build_query($data));

        $response = $this->httpClient->request('GET', $url)->getBody();

        $data = [
            'result' => $response,
        ];

        return $this->response = new VerifyNotifyIdResponse($this, $data);
    }

    public function getNotifyId(): mixed
    {
        return $this->getParameter('notify_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyId($value): LegacyVerifyNotifyIdRequest
    {
        return $this->setParameter('notify_id', $value);
    }
}
