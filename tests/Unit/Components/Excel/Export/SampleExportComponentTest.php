<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Excel\Export;

use App\Components\Excel\Export\ExportComponent;
use App\Components\Excel\Export\Notify\NotifyUserOfCompletedExport;
use App\Components\Excel\Export\SampleExport;
use App\Models\Sample;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class SampleExportComponentTest
 * @package tests\Unit\Component\Twilio\SmsComponentTest
 * command:
 *   php artisan test tests/Unit/Components/Excel/Export/SampleExportComponentTest.php
 */
class SampleExportComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function Sampleのレコードをエクスポートできる_ローカルにエクスポート()
    {
        factory(Sample::class, 10)->create();

        Excel::fake();

        (new ExportComponent(
            new SampleExport, 'export_1.xlsx', 'file')
        )->export();

        Excel::assertDownloaded('export_1.xlsx', function (FromCollection $export) {
            return $export->collection()->count() === 10; //エクセルファイルの中に10件のデータが含まれているかアサーション
        });
    }

    /**
     * @test
     */
    public function Sampleのレコードをエクスポートできる_ローカルにエクスポート_APIコール()
    {
        Excel::fake();

        factory(Sample::class, 10)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'user')
            ->getJson('api/sample/export?'
                . http_build_query([
                    'output_type' => ExportComponent::OUTPUT_TYPE_FILE,
                    'file_name' => 'export_2'
                ])
            );

        $response->assertOk();

        (new ExportComponent(
            new SampleExport, 'export_2.xlsx', 'file')
        )->export();

        Excel::assertDownloaded('export_2.xlsx', function (FromCollection $export) {
            return $export->collection()->count() === 10; //エクセルファイルの中に10件のデータが含まれているかアサーション
        });
    }

    /**
     * ExportComponentではrequest()->user()が使われているため
     * APIエンドポイントからの呼び出しでactingAsを用いrequest()->user() = nullになることを防ぐ
     * 参考：https://laracasts.com/discuss/channels/testing/form-request-the-request-user-in-null
     * @test
     * @throws \Exception
     */
    public function Sampleのレコードをエクスポートできる_ジョブに入れてエクスポート_APIコール()
    {
        Excel::fake();

        factory(Sample::class, 10)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'user')
            ->getJson('api/sample/export?'
                . http_build_query([
                    'output_type' => ExportComponent::OUTPUT_TYPE_MAIL,
                    'file_name' => 'export_3'
                ])
            );

        $response->assertOk();

        Excel::assertQueued('export_3.xlsx', ExportComponent::STORAGE_S3, function (FromCollection $export) {
            return $export->collection()->count() === 10; //エクセルファイルの中に10件のデータが含まれているかアサーション
        });

        Excel::assertQueuedWithChain([
            new NotifyUserOfCompletedExport($user, 'export_3.xlsx')
        ]);
    }
}
