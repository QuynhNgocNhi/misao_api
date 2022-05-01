<?php

namespace App\Components\Excel\Import;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * 具体的なモデルをインポートする際に継承する基底クラス。
 * Class ImportComponent
 * @package App\Components\Excel\Import
 */
abstract class ImportComponent implements ToModel, WithHeadingRow
{
    /**
     * @var int
     */
    private $batchSize;

    /**
     * @var int
     */
    private $chunkSize;

    /**
     * 各カラムのキーとなるヘッダ文言を指定する。
     * ex) カラム名がemail, nameであれば ['メールアドレス', '氏名'] のような配列を代入する。
     * @var array
     */
    protected $keys;

    /**
     * ImportComponent constructor.
     * @param int $batchSize
     * @param int $chunkSize
     */
    public function __construct(int $batchSize, int $chunkSize)
    {
        $this->batchSize = $batchSize;
        $this->chunkSize = $chunkSize;
    }

    /**
     * @param array $keys
     */
    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }
}
