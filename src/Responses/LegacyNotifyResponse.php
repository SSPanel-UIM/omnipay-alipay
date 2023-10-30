<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\LegacyNotifyRequest;

final class LegacyNotifyResponse extends AbstractLegacyResponse
{
    /**
     * @var LegacyNotifyRequest
     */
    protected $request;

    public function getResponseText(): string
    {
        if ($this->isSuccessful()) {
            return 'success';
        }
        return 'fail';
    }

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return true;
    }
}
