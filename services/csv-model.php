<?php
namespace services;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CSVModal implements ToCollection
{
    private $data = [];
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            if (!empty($row[0])){
                array_push($this->data, [
                    "name" => $row[0],
                    "number" => $row[1],
//                    "time" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]),
//                    "invoice_no" => $row[2],
//                    "amount" => $row[3]
                ]);
            }
        }
    }

    public function getData(){
        return $this->data;
    }
}
