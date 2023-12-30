<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\DataServiceBillDownloadUrlQueryResponse;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class DataServiceBillDownloadUrlQueryRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/doc2/apiDetail.htm?apiId=1054&docType=4
 */
final class DataServiceBillDownloadUrlQueryRequest extends AbstractAopRequest
{
    protected string $method = 'alipay.data.dataservice.bill.downloadurl.query';

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        $data = parent::sendData($data);

        return $this->response = new DataServiceBillDownloadUrlQueryResponse($this, $data);
    }

    public function validateParams(): void
    {
        parent::validateParams();

        $this->validateBizContent(
            'bill_type',
            'bill_date'
        );
    }
}
