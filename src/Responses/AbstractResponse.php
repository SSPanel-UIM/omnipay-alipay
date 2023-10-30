<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Responses;

use Omnipay\Common\Message\AbstractResponse as Response;

abstract class AbstractResponse extends Response
{
    public function data($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->data;
        }
        return array_get($this->data, $key, $default);
    }
}
