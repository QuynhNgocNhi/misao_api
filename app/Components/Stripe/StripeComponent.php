<?php

declare(strict_types=1);

namespace App\Components\Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeComponent
{
    protected $stripe;

    /**
     * Stripeのcallbackの呼び出し元のIPアドレスのリスト
     */
    const CALLBACK_IP_ADDRESS_LIST = [
        '127.0.0.1', // 開発用

        '3.18.12.63',
        '3.130.192.231',
        '13.235.14.237',
        '13.235.122.149',
        '35.154.171.200',
        '52.15.183.38',
        '54.187.174.169',
        '54.187.205.235',
        '54.187.216.72',
        '54.241.31.99',
        '54.241.31.102',
        '54.241.34.107',
    ];

    /**
     * StripeComponent constructor.
     */
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.secret'));
    }

    /**
     * 顧客の一覧を取得する
     * @param array $attributes
     * @return \Stripe\Collection|null
     */
    public function getCustomers(array $attributes)
    {
        try {
            return $this->stripe->customers->all($attributes);
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return null;
        }
    }

    /**
     * 顧客IDから顧客情報を取得する
     * @param string $customerId
     * @return \Stripe\Customer|null
     */
    public function getCustomer(string $customerId)
    {
        try {
            $customer = $this->stripe->customers->retrieve($customerId);

            if ($customer->isDeleted()) {
                return null;
            }

            return $customer;
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return null;
        }
    }

    /**
     * Customerの作成
     * @param array $attributes
     * @return \Stripe\Customer|null
     */
    public function createCustomer(array $attributes)
    {
        try {
            return $this->stripe->customers->create($attributes);
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return null;
        }
    }

    /**
     * 顧客情報を削除する
     * @param string $customerId
     * @return bool
     */
    public function deleteCustomer(string $customerId): bool
    {
        try {
            $this->stripe->customers->delete($customerId);
            return true;
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return false;
        }
    }

    /**
     * 顧客情報を更新する
     * @param string $customerId
     * @param array $attributes
     * @return \Stripe\Customer|null
     */
    public function updateCustomer(string $customerId, array $attributes)
    {
        try {
            return $this->stripe->customers->update($customerId, $attributes);
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return null;
        }
    }

    /**
     * カードトークンを作成する
     * @param array $attributes
     * @return string|null
     */
    public function createToken(array $attributes)
    {
        try {
            $token = $this->stripe->tokens->create($attributes);
            return $token->id;
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return null;
        }
    }

    /**
     * 支払いを行う
     * @param array $attributes
     * @return \Stripe\Charge|\Stripe\ErrorObject
     */
    public function createCharge(array $attributes)
    {
        try {
            return $this->stripe->charges->create($attributes);
        } catch (ApiErrorException $e) {
            logger($e->getError());
            logger($e->getMessage());
            return $e->getError();
        }
    }
}
