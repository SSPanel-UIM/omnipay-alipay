<?php

declare(strict_types=1);

namespace Omnipay\Alipay;

use Omnipay\Alipay\Requests\AopTradePagePayRequest;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class AopPageGateway
 *
 * @package Omnipay\Alipay
 *
 * @link    https://docs.open.alipay.com/api_1/alipay.trade.page.pay
 *
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = [])
 */
final class AopPageGateway extends AbstractAopGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName(): string
    {
        return 'Alipay Page Gateway';
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
    public function setReturnUrl($value): AopPageGateway
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
        return $this->createRequest(AopTradePagePayRequest::class, $parameters);
    }
}
