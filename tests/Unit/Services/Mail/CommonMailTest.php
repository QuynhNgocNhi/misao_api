<?php
declare(strict_types=1);

namespace tests\Unit\Services\Mail;

use App\Mail\CommonEmail;
use \Exception;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CommonEmailTest extends TestCase
{
    /**
     * @test
     */
    public function 共通テンプレートのメールを送信する_ボタンあり()
    {
        $this->sendMail(true);
    }

    /**
     * @test
     */
    public function 共通テンプレートのメールを送信する_ボタンなし()
    {
        $this->sendMail(false);
    }

    private function sendMail($putButton)
    {
        // テストで実際にメールを送信しない
        Mail::fake();

        /** @var string $recipient */
        $recipient = config('mail.test.recipient_address');

        if (is_null($recipient)) {
            $this->assertTrue(
                false,
                '.envに "TEST_RECIPIENT_ADDRESS (テスト時の送信先のメールアドレス)" を設定してください。'
            );
        }

        /** @var string $buttonLink */
        $buttonLink = config('app.url');
        $subject = 'テスト送信';
        $body = <<<EOT
        これはテストです。
        これはテストです。
        これはテストです。
        EOT;
        $buttonText = 'サイトへアクセス';

        try {
            if ($putButton) {
                $email = new CommonEmail($recipient, $subject, $body, $buttonLink, $buttonText);
            } else {
                $email = new CommonEmail($recipient, $subject, $body);
            }
            $this->assertInstanceOf('App\Mail\EmailBase', $email);

            $email->sendMail();
        } catch (Exception $e) {
            $this->assertTrue(false, $e->getMessage());
        }
    }
}
