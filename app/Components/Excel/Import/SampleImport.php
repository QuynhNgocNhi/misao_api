<?php


namespace App\Components\Excel\Import;


use App\Models\Sample;

/**
 * Sampleのモデルをインポートする
 * Class SampleImport
 * @package App\Components\Excel\Import
 */
class SampleImport extends ImportComponent
{

    /**
     * @inheritDoc
     */
    public function model(array $row)
    {
        return new Sample([
            'sample_str' => $row[$this->keys[0]],
            'sample_int' => $row[$this->keys[1]]
        ]);
    }
}