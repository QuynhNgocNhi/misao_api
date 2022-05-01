<?php
declare(strict_types=1);

namespace App\UseCases\User;

use App\Components\Stripe\StripeComponent;
use App\Models\UserStripePayment;
use App\Models\UserStripePaymentLog;
use App\Repositories\User\UserStripeInformationRepository;
use App\Repositories\User\UserStripePaymentCallbackLogRepository;
use App\Repositories\User\UserStripePaymentLogRepository;
use App\Repositories\User\UserStripePaymentRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentUseCase
 * @package App\UseCases\User
 */
class PaymentUseCase
{
    private $userStripePaymentRepository;
    private $userStripePaymentLogRepository;
    private $userStripePaymentCallbackLogRepository;
    private $stripe;
    private $user;
    private $userStripeInformationRepository;

    public function __construct(
        UserStripePaymentRepository $userStripePaymentRepository,
        StripeComponent $stripe,
        UserStripeInformationRepository $userStripeInformationRepository,
        UserStripePaymentLogRepository $userStripePaymentLogRepository,
        UserStripePaymentCallbackLogRepository $userStripePaymentCallbackLogRepository
    ) {
        if (auth('user')) {
            $this->user = auth('user')->user();
        }
        $this->userStripePaymentRepository = $userStripePaymentRepository;
        $this->userStripePaymentLogRepository = $userStripePaymentLogRepository;
        $this->userStripePaymentCallbackLogRepository = $userStripePaymentCallbackLogRepository;
        $this->stripe = $stripe;
        $this->userStripeInformationRepository = $userStripeInformationRepository;
    }

    /**
     * クレジットカードトークンを使って支払いを行う
     * @param array $attributes
     * @return bool
     */
    public function createPaymentByToken(array $attributes): bool
    {
        DB::beginTransaction();

        try {
            $payment = $this->createPayment($attributes);

            if (!$payment) {
                throw new \Exception('支払いに失敗しました');
            }

            $stripeChargeAttributes = [
                'source'   => $attributes['token'],
                'currency' => $attributes['currency'],
                'amount'   => $attributes['amount'],
            ];

            $charge = $this->stripe->createCharge($stripeChargeAttributes);

            if ($charge->id) {
                $logAttributes = [
                    'amount'                 => $payment->amount,
                    'currency'               => $payment->currency,
                    'request_params'         => $stripeChargeAttributes,
                    'response'               => $charge->toArray(),
                    'status'                 => UserStripePaymentLog::STATUS_SUCCEEDED,
                    'user_id'                => $this->user->id,
                    'user_stripe_payment_id' => $payment->id,
                    'charge_id'              => $charge->id,
                ];
                $this->userStripePaymentLogRepository->create($logAttributes);
                $payment->update([
                    'charge_id' => $charge->id,
                    'status' => UserStripePayment::STATUS_SUCCEEDED
                ]);
            } else {
                $logAttributes = [
                    'amount'                 => $payment->amount,
                    'currency'               => $payment->currency,
                    'request_params'         => $stripeChargeAttributes,
                    'response'               => $charge->toArray(),
                    'status'                 => UserStripePaymentLog::STATUS_FAILED,
                    'user_id'                => $this->user->id,
                    'user_stripe_payment_id' => $payment->id,
                ];
                $this->userStripePaymentLogRepository->create($logAttributes);
                $payment->update([
                    'status' => UserStripePayment::STATUS_FAILED
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            return false;
        }

        DB::commit();
        if ($payment->status === UserStripePayment::STATUS_FAILED) return false;

        return true;
    }

    /**
     * 顧客に紐づけられた支払い情報を使って支払いを行う
     * @param array $attributes
     * @return bool
     */
    public function createPaymentByCustomer(array $attributes): bool
    {
        DB::beginTransaction();

        try {
            $userStripe = $this->user->stripe;
            if (!$userStripe) {
                throw new \Exception('支払い方法が登録されていません');
            }

            $stripeCustomer = $this->stripe->getCustomer($userStripe->customer_id);

            $attributes['token']   = $stripeCustomer->default_source;
            $payment = $this->createPayment($attributes);

            if (!$payment) {
                throw new \Exception('支払いに失敗しました');
            }

            $stripeChargeAttributes = [
                'customer' => $userStripe->customer_id,
                'currency' => $attributes['currency'],
                'amount'   => $attributes['amount'],
            ];

            $charge = $this->stripe->createCharge($stripeChargeAttributes);

            if ($charge->id) {
                $logAttributes = [
                    'amount'                 => $payment->amount,
                    'currency'               => $payment->currency,
                    'request_params'         => $stripeChargeAttributes,
                    'response'               => $charge->toArray(),
                    'status'                 => UserStripePaymentLog::STATUS_SUCCEEDED,
                    'user_id'                => $this->user->id,
                    'user_stripe_payment_id' => $payment->id,
                ];
                // ログの作成
                $this->userStripePaymentLogRepository->create($logAttributes);

                $this->userStripePaymentRepository->update($payment->id, [
                    'charge_id' => $charge->id,
                    'status' => UserStripePayment::STATUS_SUCCEEDED
                ]);
            } else {
                $logAttributes = [
                    'amount'                 => $payment->amount,
                    'currency'               => $payment->currency,
                    'request_params'         => $stripeChargeAttributes,
                    'response'               => $charge->toArray(),
                    'status'                 => UserStripePaymentLog::STATUS_FAILED,
                    'user_id'                => $this->user->id,
                    'user_stripe_payment_id' => $payment->id,
                ];
                // ログの作成
                $this->userStripePaymentLogRepository->create($logAttributes);

                $this->userStripePaymentRepository->update($payment->id, [
                    'status' => UserStripePayment::STATUS_FAILED
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getFile() . ' ' . $e->getLine());
            logger()->error($e->getMessage());
            return false;
        }

        DB::commit();
        if ($payment->status === UserStripePayment::STATUS_FAILED) return false;

        return true;
    }

    /**
     * 支払いのためのデータを作成する
     * @param array $attributes
     * @return UserStripePayment
     */
    public function createPayment(array $attributes): UserStripePayment
    {
        $attributes['user_id'] = $this->user->id;
        return $this->userStripePaymentRepository->create($attributes);
    }

    /**
     * StripeからCallbackが呼び出された時に支払い情報を更新する
     * @param array $attributes
     */
    public function updatePaymentByCallback(array $attributes)
    {
        $charge = $attributes['data']['object'];
        if (!$charge) {
            throw new \InvalidArgumentException('Charge Objectが見つかりませんでした');
        }

        if (!isset($charge['metadata']['payment_id'])) {
            throw new \InvalidArgumentException('payment_idが見つかりませんでした');
        }

        $paymentId = $charge['metadata']['payment_id'];

        $callbackLogAttributes = [
            'user_stripe_payment_id' => $paymentId,
            'status'                 => $charge['status'],
            'request_params'         => $attributes,
            'amount'                 => $charge['amount'],
            'currency'               => $charge['currency'],
            'charge_id'              => $charge['id'],
        ];

        $paymentAttributes = [
            'status' => $charge['status'],
        ];

        if ($charge['status'] === UserStripePayment::STATUS_SUCCEEDED) {
            $paymentAttributes['charge_id'] = $charge['id'];
        }

        DB::beginTransaction();
        try {
            $this->userStripePaymentRepository->update($paymentId, $paymentAttributes);

            $this->userStripePaymentCallbackLogRepository->create($callbackLogAttributes);
        } catch (\Exception $e) {
            logger($e->getMessage());
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
