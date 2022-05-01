<?php
declare(strict_types=1);

namespace tests\Unit\Services\Sample;

use App\Models\Sample;
use App\Services\SampleService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class SampleTest
 * @package tests\Unit\Sample
 */
class SampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function Sampleを登録した後に取得できる()
    {
        // 時間固定
        Carbon::setTestNow();

        // 登録
        $attributes = [
            'parent' => [
                'sample_str' => 'sample_p',
                'sample_int' => 1234,
            ],
            'child' => [
                'sample_str' => 'sample_c',
                'sample_int' => 5678,
            ],
        ];

        $sampleService = new SampleService();
        /** @var Sample $sample */
        $sample = $sampleService->registerSample($attributes);

        $now = Carbon::now();

        // データが正しいか確認
        $this->assertDatabaseHas('samples', [
            'id' => $sample->id,
            'sample_str' => $attributes['parent']['sample_str'],
            'sample_int' => $attributes['parent']['sample_int'],
            'created_at' => $now->toDateTimeString(),
            'updated_at' => $now->toDateTimeString(),
        ]);

        $this->assertDatabaseHas('sample_children', [
            'sample_id' => $sample->id,
            'sample_str' => $attributes['child']['sample_str'],
            'sample_int' => $attributes['child']['sample_int'],
            'created_at' => $now->toDateTimeString(),
            'updated_at' => $now->toDateTimeString(),
        ]);
    }
}
