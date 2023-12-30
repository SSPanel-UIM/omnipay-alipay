<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTransferToAccountQueryRequest;

final class AopTransferToAccountQueryResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_fund_trans_order_query_response';

    /**
     * @var AopTransferToAccountQueryRequest
     */
    protected $request;
}
