<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\DataServiceBillDownloadUrlQueryRequest;

final class DataServiceBillDownloadUrlQueryResponse extends AbstractAopResponse
{
    protected $key = 'alipay_data_dataservice_bill_downloadurl_query_response';

    /**
     * @var DataServiceBillDownloadUrlQueryRequest
     */
    protected $request;
}
