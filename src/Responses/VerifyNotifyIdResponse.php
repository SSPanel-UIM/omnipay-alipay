<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

final class VerifyNotifyIdResponse extends AbstractLegacyResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->data['result'] . '' === 'true';
    }
}
