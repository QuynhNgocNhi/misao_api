<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Twilio;

use App\Components\Twilio\SmsComponent;
use Tests\TestCase;

/**
 * Class SmsComponentTest
 * @package tests\Unit\Component\Twilio\SmsComponentTest
 * command:
 *   php artisan test tests/Unit/Components/Twilio/SmsComponentTest.php
 */
class SmsComponentTest extends TestCase
{
    /** @var SmsComponent */
    protected $sms;

    protected function setUp(): void
    {
        parent::setUp();

        try {
            $this->sms = app('App\Components\Twilio\SmsComponent');
        } catch (\Exception $e) {
            $this->markTestSkipped($e->getMessage());
        }
    }

    /**
     * @test
     */
    public function Smsを送信できる()
    {
        if (!$this->sms) {
            $this->markTestSkipped('環境変数にTWILIOの認証情報がセットされていません。');
        }

        $phoneNumber = config('services.twilio.twilio_test_phone_number');
        if (empty($phoneNumber)) {
            $this->assertTrue(false, 'テスト用の電話番号が環境変数に設定されていません。');
            return;
        }

        $result = $this->sms->send($phoneNumber, 'from text', 'body text');
        $this->assertTrue($result);
    }
}
