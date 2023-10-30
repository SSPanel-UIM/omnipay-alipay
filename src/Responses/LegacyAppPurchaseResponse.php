<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

final class LegacyAppPurchaseResponse extends AbstractLegacyResponse
{
    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return true;
    }

    public function getOrderString()
    {
        return $this->data['order_string'];
    }
}
