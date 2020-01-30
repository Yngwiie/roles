<?php

namespace App\Exports;

use App\log;
use Maatwebsite\Excel\Concerns\FromCollection;

class LogExport implements FromCollection
{
    public function __construct($logs){
        $this->logs = $logs;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->logs;
    }
}
