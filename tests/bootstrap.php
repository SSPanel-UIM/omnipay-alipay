<?php

declare(strict_types=1);

// include the composer autoloader
$autoloader = require __DIR__ . '/../vendor/autoload.php';

// autoload abstract TestCase classes in test directory
$autoloader->add('Omnipay', __DIR__);

define('ALIPAY_ASSET_DIR', realpath(__DIR__ . '/Assets'));

$configFile = realpath(__DIR__ . '/../config.php');


const ALIPAY_PARTNER = '2088011436420182';
const ALIPAY_KEY = '18x8lAi0a1520st1hvxcnt7m4w1whkbs';
const ALIPAY_SELLER_ID = '2088011436420182';
const ALIPAY_PUBLIC_KEY = ALIPAY_ASSET_DIR . '/dist/aop/alipay_public_key.pem';
const ALIPAY_LEGACY_PRIVATE_KEY = ALIPAY_ASSET_DIR . '/dist/legacy/rsa_private_key.pem';
const ALIPAY_LEGACY_PUBLIC_KEY = ALIPAY_ASSET_DIR . '/dist/legacy/alipay_public_key.pem';
const ALIPAY_AOP_PUBLIC_KEY = ALIPAY_ASSET_DIR . '/dist/aop/alipay_public_key.pem';
const ALIPAY_AOP_PRIVATE_KEY = ALIPAY_ASSET_DIR . '/dist/aop/rsa_private_key.pem';

const ALIPAY_APP_ID = '2088011436421111';
const ALIPAY_APP_PRIVATE_KEY = ALIPAY_ASSET_DIR . '/dist/aop/rsa_private_key.pem';
const ALIPAY_APP_ENCRYPT_KEY = 'aGVsbG93b3JsZGhleWhleWhleQ==';


if (!function_exists('dd')) {
    function dd(): void
    {
        foreach (func_get_args() as $arg) {
            var_dump($arg);
        }
        exit(0);
    }
}
