<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

final class LegacyRefundNoPwdResponse extends AbstractLegacyResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->data['is_success'] === 'T';
    }
}
