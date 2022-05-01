<?php


namespace App\Components\Excel\Export;


use App\Components\Excel;
use App\Models\Sample;
use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Sampleテーブルをエクスポートする際の形式を指定する。
 * Class SampleExport
 * @package App\Components\Excel\Export
 */
class SampleExport implements FromCollection
{
    public function collection()
    {
        return Sample::all();
    }
}