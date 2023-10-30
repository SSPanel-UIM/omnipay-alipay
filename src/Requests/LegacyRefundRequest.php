<?php

declare(strict_types=1);

namespace Omnipay\Alipay\Requests;

use Omnipay\Alipay\Responses\LegacyRefundResponse;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Class LegacyRefundRequest
 *
 * @package Omnipay\Alipay\Requests
 *
 * @link    https://doc.open.alipay.com/docs/doc.htm?treeId=66&articleId=103600&docType=1
 */
final class LegacyRefundRequest extends AbstractLegacyRequest
{
    protected $service = 'refund_fastpay_by_platform_pwd';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->setDefaults();

        $this->validate(
            'partner',
            '_input_charset',
            'refund_date',
            'batch_no',
            'refund_items'
        );

        $this->validateOne(
            'seller_user_id',
            'seller_email'
        );

        $this->setBatchNum(count($this->getRefundItems()));
        $this->setRefundDetail($this->getDetailData());

        $data = [
            'service' => $this->service,
            'partner' => $this->getPartner(),
            'notify_url' => $this->getNotifyUrl(),
            'seller_user_id' => $this->getPartner(),
            'refund_date' => $this->getRefundDate(),
            'batch_no' => $this->getBatchNo(),
            'batch_num' => $this->getBatchNum(),
            'detail_data' => $this->getDetailData(),
            '_input_charset' => $this->getInputCharset(),
        ];

        $data['sign'] = $this->sign($data, $this->getSignType());
        $data['sign_type'] = $this->getSignType();

        return $data;
    }

    public function getRefundDate(): mixed
    {
        return $this->getParameter('refund_date');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setRefundDate($value): LegacyRefundRequest
    {
        return $this->setParameter('refund_date', $value);
    }

    public function getBatchNo(): mixed
    {
        return $this->getParameter('batch_no');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBatchNo($value): LegacyRefundRequest
    {
        return $this->setParameter('batch_no', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setBatchNum($value): LegacyRefundRequest
    {
        return $this->setParameter('batch_num', $value);
    }

    public function getRefundItems(): mixed
    {
        return $this->getParameter('refund_items');
    }

    public function getPartner(): mixed
    {
        return $this->getParameter('partner');
    }

    public function getNotifyUrl(): mixed
    {
        return $this->getParameter('notify_url');
    }

    public function getBatchNum(): mixed
    {
        return $this->getParameter('batch_num');
    }

    public function getInputCharset(): mixed
    {
        return $this->getParameter('_input_charset');
    }

    public function getPaymentType(): mixed
    {
        return $this->getParameter('payment_type');
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setPaymentType($value): AbstractLegacyRequest
    {
        return $this->setParameter('payment_type', $value);
    }

    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData(mixed $data): ResponseInterface
    {
        return $this->response = new LegacyRefundResponse($this, $data);
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setPartner($value): AbstractLegacyRequest
    {
        return $this->setParameter('partner', $value);
    }

    /**
     * @param $value
     *
     * @return AbstractLegacyRequest
     */
    public function setInputCharset($value): AbstractLegacyRequest
    {
        return $this->setParameter('_input_charset', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setNotifyUrl($value): LegacyRefundRequest
    {
        return $this->setParameter('notify_url', $value);
    }

    public function getSellerEmail(): mixed
    {
        return $this->getParameter('seller_email');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerEmail($value): LegacyRefundRequest
    {
        return $this->setParameter('seller_email', $value);
    }

    public function getSellerId(): mixed
    {
        return $this->getSellerUserId();
    }

    public function getSellerUserId(): mixed
    {
        return $this->getParameter('seller_user_id');
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerId($value): LegacyRefundRequest
    {
        return $this->setSellerUserId($value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setSellerUserId($value): LegacyRefundRequest
    {
        return $this->setParameter('seller_user_id', $value);
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setRefundItems($value): LegacyRefundRequest
    {
        return $this->setParameter('refund_items', $value);
    }

    protected function setDefaults(): void
    {
        if (! $this->getRefundDate()) {
            $this->setRefundDate(date('Y-m-d H:i:s'));
        }

        if (! $this->getBatchNo()) {
            $this->setBatchNo(date('Ymd') . mt_rand(1000, 9999));
        }
    }

    /**
     * @param $value
     *
     * @return $this
     */
    protected function setRefundDetail($value): LegacyRefundRequest
    {
        return $this->setParameter('refund_detail', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    protected function getDetailData(): string
    {
        $strings = [];

        foreach ($this->getRefundItems() as $item) {
            $item = (array) $item;

            if (! isset($item['out_trade_no'])) {
                throw new InvalidRequestException('The field `out_trade_no` is not exist in item');
            }

            if (! isset($item['amount'])) {
                throw new InvalidRequestException('The field `amount` is not exist in item');
            }

            if (! isset($item['reason'])) {
                throw new InvalidRequestException('The field `reason` is not exist in item');
            }

            $strings[] = implode('^', [$item['out_trade_no'], $item['amount'], $item['reason']]);
        }

        return implode('#', $strings);
    }

    protected function getRefundDetail(): mixed
    {
        return $this->getParameter('refund_detail');
    }
}
