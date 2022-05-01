<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Stripe;

use App\Components\Stripe\StripeComponent;
use Tests\TestCase;

/**
 * Class StripeTest
 * @package tests\Unit\Components\Stripe
 *   php artisan test tests/Unit/Components/Stripe/StripeTest.php
 */
class StripeTest extends TestCase
{
    /** @var StripeComponent */
    protected $stripeComponent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stripeComponent = app()->make(StripeComponent::class);
    }

    /**
     * @test
     */
    public function StripeApiに接続できる()
    {
        $result = $this->stripeComponent->getCustomers([]);
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function パラメタを指定せず顧客を作成できる()
    {
        $customer = $this->stripeComponent->createCustomer([]);
        $this->assertNotNull($customer);
        $this->assertNotNUll($customer->id);
        $this->assertIsString($customer->id);
    }

    /**
     * @test
     */
    public function パラメタを指定して顧客を作成できる()
    {
        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'test@test.com',
        ];

        $customer = $this->stripeComponent->createCustomer($attributes);
        $this->assertNotNull($customer);

        // 指定したパラメタのデータが正しく入っているかの確認
        $this->assertSame($customer->name, $attributes['name']);
        $this->assertSame($customer->description, $attributes['description']);
        $this->assertSame($customer->email, $attributes['email']);
    }


    /**
     * @test
     */
    public function パラメタに不正な値を指定すると顧客が作成できない()
    {
        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'testtesttest',
        ];

        $customer = $this->stripeComponent->createCustomer($attributes);
        $this->assertNull($customer);
    }

    /**
     * @test
     */
    public function 存在しないパラメタを指定すると顧客が作成できない()
    {
        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'test@test.com',
            'not_exist_params' => 'test',
        ];

        $customer = $this->stripeComponent->createCustomer($attributes);
        $this->assertNull($customer);
    }

    /**
     * @test
     */
    public function 作成した顧客を削除できる()
    {
        $customer = $this->stripeComponent->createCustomer([]);

        $result = $this->stripeComponent->deleteCustomer($customer->id);
        $this->assertTrue($result);

        // 顧客が存在しないことの確認
        $customer = $this->stripeComponent->getCustomer($customer->id);
        $this->assertNull($customer);
    }

    /**
     * @test
     */
    public function 作成した顧客の情報を更新できる()
    {
        $customer = $this->stripeComponent->createCustomer([]);

        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'test@test.com'
        ];

        $customer = $this->stripeComponent->updateCustomer($customer->id, $attributes);
        $this->assertNotNull($customer);
        $this->assertSame($customer->name, $attributes['name']);
        $this->assertSame($customer->description, $attributes['description']);
        $this->assertSame($customer->email, $attributes['email']);
    }

    /**
     * @test
     */
    public function 顧客一覧を取得できる()
    {
        $customers = $this->stripeComponent->getCustomers([]);
        $this->assertNotNull($customers);
    }

    /**
     * @test
     */
    public function 顧客一覧を条件を指定して取得できる()
    {

        $attributes = [
            'limit' => 5,
        ];

        $customers = $this->stripeComponent->getCustomers($attributes);
        $this->assertNotNull($customers);
        $this->assertLessThanOrEqual(count($customers), $attributes['limit']);
    }

    /**
     * @test
     */
    public function カードトークンを作成できる()
    {

        $attributes = [
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 6,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($attributes);
        $this->assertNotNull($token);
        $this->assertIsString($token);
    }

    /**
     * @test
     */
    public function カード情報が不正でカードトークンを作成できない()
    {

        $attributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2020,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($attributes);
        $this->assertNull($token);
    }

    public function CVCが不正でカードトークンを作成できない()
    {

        $attributes = [
            'card' => [
                'number' => '4000000000000127',
                'exp_month' => 6,
                'exp_year'  => 2020,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($attributes);
        $this->assertNull($token);
    }

    /**
     * @test
     */
    public function 存在しないパラメタを指定してカードトークンを作成できない()
    {

        $attributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
                'not_exist' => 'test',
            ],
        ];

        $token = $this->stripeComponent->createToken($attributes);
        $this->assertNull($token);
    }

    /**
     * @test
     */
    public function トークンを使って円で支払いができる()
    {

        $cardAttributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($cardAttributes);

        $attributes = [
            'amount'      => 1000,
            'currency'    => 'jpy',
            'description' => 'test charge',
            'source'      => $token,
        ];

        $charge = $this->stripeComponent->createCharge($attributes);
        $this->assertNotNull($charge);
        $this->assertSame($charge->amount, $attributes['amount']);
        $this->assertSame($charge->currency, $attributes['currency']);
        $this->assertSame($charge->description, $attributes['description']);
    }

    /**
     * @test
     */
    public function トークンを使ってドルで支払いができる()
    {

        $cardAttributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($cardAttributes);

        $attributes = [
            'amount'      => 1000,
            'currency'    => 'usd',
            'description' => 'test charge',
            'source'      => $token,
        ];

        $charge = $this->stripeComponent->createCharge($attributes);
        $this->assertNotNull($charge);
        $this->assertSame($charge->amount, $attributes['amount']);
        $this->assertSame($charge->currency, $attributes['currency']);
        $this->assertSame($charge->description, $attributes['description']);
    }

    /**
     * @test
     */
    public function パラメタ不足でトークンを使って支払いができない()
    {

        $cardAttributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($cardAttributes);

        $attributes = [
            'amount'      => 1000,
            'description' => 'test charge',
            'source'      => $token,
        ];

        $charge = $this->stripeComponent->createCharge($attributes);
        $this->assertNull($charge->id);
    }

    /**
     * @test
     */
    public function カードトークンとともに顧客を作成できる()
    {

        $cardAttributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($cardAttributes);

        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'test@test.com',
            'source'      => $token,
        ];

        $customer = $this->stripeComponent->createCustomer($attributes);
        $this->assertNotNull($customer);

        // 指定したパラメタのデータが正しく入っているかの確認
        $this->assertSame($customer->name, $attributes['name']);
        $this->assertSame($customer->description, $attributes['description']);
        $this->assertSame($customer->email, $attributes['email']);
        $this->assertNotNull($customer->default_source);
    }

    /**
     * @test
     */
    public function 顧客情報から支払いができる()
    {

        $cardAttributes = [
            'card' => [
                'number'    => '4242424242424242',
                'exp_month' => 6,
                'exp_year'  => 2022,
                'cvc'       => '314',
            ],
        ];

        $token = $this->stripeComponent->createToken($cardAttributes);

        $attributes = [
            'name'        => 'test customer',
            'description' => 'this is a test customer',
            'email'       => 'test@test.com',
            'source'      => $token,
        ];

        $customer = $this->stripeComponent->createCustomer($attributes);

        $chargeAttributes = [
            'amount'      => 1000,
            'currency'    => 'jpy',
            'description' => 'test charge has metadata',
            'customer'    => $customer->id,
            'metadata'    => [
                'memo' => 'testtesttesttest',
            ],
        ];

        $charge = $this->stripeComponent->createCharge($chargeAttributes);
        $this->assertNotNull($charge);
        $this->assertSame($charge->amount, $chargeAttributes['amount']);
        $this->assertSame($charge->currency, $chargeAttributes['currency']);
        $this->assertSame($charge->description, $chargeAttributes['description']);
        $this->assertSame($charge->customer, $chargeAttributes['customer']);
        $this->assertNotNull($charge->metadata);
        $this->assertSame($charge->metadata['memo'], $chargeAttributes['metadata']['memo']);
    }
}
