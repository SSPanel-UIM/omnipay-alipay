<?php

declare(strict_types=1);

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopTradeWapPayRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class AopWapGateway
 *
 * @package Omnipay\Alipay
 *
 * @link    https://docs.open.alipay.com/203/105288
 *
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface capture(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 */
final class AopWapGateway extends AbstractAopGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName(): string
    {
        return 'Alipay WAP Gateway';
    }

    public function getReturnUrl(): mixed
    {
        return $this->getParameter('return_url');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setReturnUrl($value): AopWapGateway
    {
        return $this->setParameter('return_url', $value);
    }

    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function purchase(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(AopTradeWapPayRequest::class, $parameters);
    }
}
