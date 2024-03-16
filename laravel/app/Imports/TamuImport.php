<?php

namespace App\Imports;

use App\Tamu;
use Maatwebsite\Excel\Concerns\ToModel;

class TamuImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tamu([
            'nama'      => $row[0],
            'hp'        => $row[1], 
            'email'     => $row[2],
            'alamat_domisili'    => $row[3], 
            'tgl'       => date('Y-m-d', strtotime($row[4])),
            'sumber'    => $row[5], 
            'sales'     => $row[6],
            'status'    => $row[7], 
            'bulan'    => $row[8], 
            'tahun'    => $row[9], 

//            'nama', 'hp', 'email','alamat_domisili','tgl','sumber','sales','status_user',
        ]);
    }
}
