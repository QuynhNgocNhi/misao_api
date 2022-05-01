<?php
declare(strict_types=1);

namespace tests\Unit\Services\Mail;

use App\Services\BounceMail\BounceMailService;
use Aws\DynamoDb\DynamoDbClient;
use Tests\TestCase;

class BounceMailTest extends TestCase
{
    /**
     * @var DynamoDbClient
     */
    protected $dynamoDbClient;

    /**
     * @test
     */
    public function メールアドレスがバウンスメールリストにあることを確認する()
    {
        $this->markTestSkipped('AWSへの接続が必要なのでスキップします。');

        $emailAddress = 'sakatabeika-test@test.com';
        $isBounceMail = $this->isBounceMail($emailAddress);

        $this->assertTrue($isBounceMail, 'バウンスメールリストにヒットしませんでした。');
    }

    /**
     * @test
     */
    public function メールアドレスがバウンスメールリストに無いことを確認する()
    {
        $this->markTestSkipped('AWSへの接続が必要なのでスキップします。');

        $emailAddress = 'inoue@aidiot.jp';
        $isBounceMail = $this->isBounceMail($emailAddress);

        $this->assertNotTrue($isBounceMail, 'バウンスメールリストにヒットしてしまいました。');
    }

    /**
     * @param string $emailAddress
     * @return bool
     */
    private function isBounceMail(string $emailAddress): bool
    {
        $dynamoDbClient = new DynamoDbClient(config('bm_dynamodb'));
        $bounceMailService = new BounceMailService($dynamoDbClient);
        return $bounceMailService->isBounceMail($emailAddress);
    }
}
