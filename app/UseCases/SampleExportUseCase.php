<?php
declare(strict_types=1);

namespace App\UseCases;

use App\Components\Excel\Export\ExportComponent;
use App\Components\Excel\Export\SampleExport;
use App\Models\Sample;
use App\Models\SampleChild;
use App\Repositories\SampleChildRepository;
use App\Repositories\SampleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use function Composer\Autoload\includeFile;

/**
 * Class SampleExportUseCase
 * @package App\UseCases
 */
class SampleExportUseCase
{

    /**
     * エクセルファイルをエクスポートする
     * @throws \Exception
     */
    public function export(string $fileName, string $outputType)
    {
        (new ExportComponent(
            new SampleExport, $fileName . '.xlsx', $outputType)
        )->export();
    }
}
