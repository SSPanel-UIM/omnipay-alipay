<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTransferToAccountRequest;

final class AopTransferToAccountResponse extends AbstractAopResponse
{
    protected string $key = 'alipay_fund_trans_toaccount_transfer_response';

    /**
     * @var AopTransferToAccountRequest
     */
    protected $request;
}
