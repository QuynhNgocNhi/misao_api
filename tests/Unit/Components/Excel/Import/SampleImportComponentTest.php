<?php
declare(strict_types=1);

namespace Tests\Unit\Components\Excel\Import;

use App\Components\Excel\Import\SampleImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

/**
 * Class SmsComponentTest
 * @package tests\Unit\Component\Twilio\SmsComponentTest
 * command:
 *   php artisan test tests/Unit/Components/Excel/Import/SampleImportComponentTest.php
 */
class SampleImportComponentTest extends TestCase
{
    use RefreshDatabase;

    /** @var SampleImport */
    protected $sampleImport;

    /**
     * @test
     */
    public function Sampleのレコードをインポートできる()
    {
        $path = './tests/Unit/Components/Excel/Import/data/Sampleのレコードをインポートできる_カラムに対応するkeyを指定した場合.xlsx';

        $sampleImport = new SampleImport(10, 100);
        $sampleImport->setKeys([
            'サンプル文字列',
            'サンプル数値'
        ]);

        Excel::import($sampleImport, $path);

        $this->assertDatabaseHas('samples', [
            'sample_str' => 'あああ',
            'sample_int' => 3,
        ]);
        $this->assertDatabaseHas('samples', [
            'sample_str' => 'いいい',
            'sample_int' => 4,
        ]);
    }
}
