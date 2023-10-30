<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

final class AopTradeAppPayResponse extends AbstractResponse
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

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getOrderString()
    {
        return $this->data['order_string'];
    }
}
