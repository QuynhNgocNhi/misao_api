<?php

declare(strict_types=1);

namespace Tests\Feature\Services\Sample;

use App\Models\Sample;
use App\Models\SampleChild;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

/**
 * Class SampleTest
 * @package Tests\Feature\Services\Sample
 * command:
 *   php artisan test tests/Feature/Services/Sample/SampleTest.php
 */
class SampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * DB初期化
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function Sampleの一覧を取得する()
    {
        $dataCount = 5;

        // dataCount数分データを挿入
        factory(Sample::class, $dataCount)->create()
            ->each(
                function ($sample) use (&$index) {
                    factory(SampleChild::class, 1)->create([
                        'sample_id' => $sample->id
                    ]);
                }
            );

        // POSTリクエスト
        $response = $this->post(route('sample.list'));

        // データ件数チェック
        $this->assertEquals($dataCount, Sample::count());
        $this->assertEquals($dataCount, SampleChild::count());

        // レスポンスチェック
        $response
            // ステータスコードが200か
            ->assertOK()
            // JSONで返されているか
            ->assertHeader('content_type', 'application/json')
            // データチェック
            ->assertJsonFragment(['success' => true])
            // データが件数分取得できているか
            ->assertJsonCount($dataCount, 'data.samples');
    }

    /**
     * @test
     */
    public function Sampleデータを追加する()
    {
        // 時間固定
        Carbon::setTestNow();

        // POSTリクエスト
        $params = [
            'parent_sample_str' => 'oya',
            'parent_sample_int' => 1,
            'child_sample_str'  => 'ko',
            'child_sample_int'  => 2,
        ];
        $response = $this->post(route('sample.input'), $params);

        // レスポンスチェック
        $response
            // ステータスコードが200か
            ->assertOK()
            // JSONで返されているか
            ->assertHeader('content_type', 'application/json')
            // データチェック
            ->assertJsonFragment(['success' => true]);

        // データチェック
        $this->assertDatabaseHas('samples', [
            'sample_str' => $params['parent_sample_str'],
            'sample_int' => $params['parent_sample_int'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->assertDatabaseHas('sample_children', [
            'sample_str' => $params['child_sample_str'],
            'sample_int' => $params['child_sample_int'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * @test
     */
    public function データ不足でSampleデータ追加時にvalidationが動作する()
    {
        $params = [
            'parent_sample_str' => null,
            'parent_sample_int' => null,
            'child_sample_str'  => null,
            'child_sample_int'  => null,
        ];

        // POSTリクエスト
        $response = $this->post(route('sample.input'), $params);

        // レスポンスチェック
        $response
            // ステータスコードが422か
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            // JSONで返されているか
            ->assertHeader('content_type', 'application/json')
            // データチェック
            ->assertJsonFragment([
                 'success' => false,
                 'message' => 'Validation was failed',
             ])
            // エラーメッセージが不正なパラメータ分あるか
            ->assertJsonCount(count($params), 'errors');

        // データが入っていないのを確認
        $this->assertDatabaseMissing('samples', []);
    }
}
