<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

final class LegacyQueryResponse extends AbstractLegacyResponse
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

    /**
     * Is the trade paid?
     *
     * @return bool
     */
    public function isPaid(): bool
    {
        $response = array_get($this->data, 'response');
        if ($response) {
            $trade = array_get($response, 'trade');
            if (array_get($trade, 'trade_status')) {
                if (array_get($trade, 'trade_status') === 'TRADE_SUCCESS') {
                    return true;
                }
                if (array_get($trade, 'trade_status') === 'TRADE_FINISHED') {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }
}
