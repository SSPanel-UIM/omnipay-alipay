<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Tests;

use Omnipay\Tests\GatewayTestCase;

abstract class AbstractGatewayTestCase extends GatewayTestCase
{
    protected string $partner = ALIPAY_PARTNER;

    protected string $key = ALIPAY_KEY;

    protected string $sellerId = ALIPAY_SELLER_ID;

    protected string $appId = ALIPAY_APP_ID;

    protected string $appPrivateKey = ALIPAY_APP_PRIVATE_KEY;

    protected string $alipayPublicKey = ALIPAY_PUBLIC_KEY;

    protected string $appEncryptKey = ALIPAY_APP_ENCRYPT_KEY;
}
