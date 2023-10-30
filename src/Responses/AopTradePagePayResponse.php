<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Alipay\Requests\AopTradeWapPayRequest;
use Omnipay\Common\Message\RedirectResponseInterface;

final class AopTradePagePayResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var AopTradeWapPayRequest
     */
    protected $request;

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return true;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    /**
     * Gets the redirect target url.
     */
    public function getRedirectUrl(): ?string
    {
        return sprintf('%s?%s', $this->request->getEndpoint(), http_build_query($this->data));
    }

    /**
     * Get the required redirect method (either GET or POST).
     */
    public function getRedirectMethod(): string
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
