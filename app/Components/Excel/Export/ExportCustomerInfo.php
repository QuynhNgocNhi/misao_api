<?php


namespace App\Components\Excel\Export;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportCustomerInfo implements FromCollection
{
    protected $exportData;

    public function __construct($exportData)
    {
        $this->exportData = $exportData;
    }

    public function collection()
    {
        return collect($this->exportData);
    }
}