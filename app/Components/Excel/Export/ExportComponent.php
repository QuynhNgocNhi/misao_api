<?php


namespace App\Components\Excel\Export;


use App\Components\Excel\Export\Notify\NotifyUserOfCompletedExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ExportComponent
 * @package App\Components\Excel\Export
 */
class ExportComponent
{
    const OUTPUT_TYPE_FILE = 'file';

    const OUTPUT_TYPE_MAIL = 'mail';

    const STORAGE_S3 = 's3';

    /**
     * @var FromCollection
     */
    private $export;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $outputType;

    /**
     * ExportComponent constructor.
     * @param FromCollection $export
     * @param string $fileName
     * @param string $outputType
     */
    public function __construct(FromCollection $export, string $fileName, string $outputType)
    {
        $this->export = $export;
        $this->fileName = $fileName;
        $this->outputType = $outputType;
    }

    /**
     * エクセルファイルを任意の形式で出力
     * @throws \Exception
     */
    public function export()
    {
        if ($this->outputType === self::OUTPUT_TYPE_FILE) {
            return Excel::download($this->export, $this->fileName);

        } elseif ($this->outputType === self::OUTPUT_TYPE_MAIL) {
            return Excel::queue($this->export, $this->fileName, self::STORAGE_S3)->chain([
                new NotifyUserOfCompletedExport(request()->user(), $this->fileName)
            ]);
        }

        throw new \Exception('正しい出力形式を選択してください。');
    }
}