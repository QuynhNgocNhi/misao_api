<?php
declare(strict_types=1);

namespace App\UseCases\User;

use App\Components\Stripe\StripeComponent;
use App\Http\Requests\User\PaymentMethodRequest;
use App\Models\UserStripeInformation;
use App\Repositories\User\UserStripeInformationRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentMethodUseCase
 * @package App\UseCases\User
 */
class PaymentMethodUseCase
{
    private $userStripeRepository;
    private $stripe;
    private $user;

    public function __construct(UserStripeInformationRepository $userStripeRepository, StripeComponent $stripe)
    {
        $this->user = auth('user')->user();
        $this->userStripeRepository = $userStripeRepository;
        $this->stripe = $stripe;
    }

    /**
     * Stripeの顧客を作成しトークンを保存する
     * @param string $token
     * @return UserStripeInformation|null
     */
    public function registerUserStripe(string $token)
    {
        DB::beginTransaction();

        try {
            $attributes = [
                'source' => $token,
                'name'   => $this->user->full_name,
                'email'  => $this->user->email,
            ];

            $stripeCustomer = $this->stripe->createCustomer($attributes);

            if (!$stripeCustomer) {
                throw new \Exception('顧客の登録に失敗しました');
            }

            // TODO : 項目の追加
            $stripeCustomerAttributes = [
                'user_id' => $this->user->id,
                'customer_id' => $stripeCustomer->id,
            ];

            $userStripe = $this->userStripeRepository->create($stripeCustomerAttributes);
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error($e->getMessage());
            return null;
        }

        DB::commit();

        return $userStripe;
    }
}
