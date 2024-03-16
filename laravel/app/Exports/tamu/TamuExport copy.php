<?php

namespace App\Exports\tamu;
use Illuminate\Support\Facades\DB;
use App\Tamu;
use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class TamuExport implements FromView
{
       
    protected $id_sales;
    protected $tgl_awal;
    protected $tgl_akhir;

    function __construct($id_sales,$tgl_awal,$tgl_akhir) {
            $this->id_sales = $id_sales;
            $this->tgl_awal = $tgl_awal;
            $this->tgl_akhir = $tgl_akhir;
    }



    public function view(): View
    {
           if($this->id_sales == ''){
                                $total = Tamu::whereDate('tgl','<=',$this->tgl_akhir)
                                                ->whereDate('tgl','>=',$this->tgl_awal)
                                                ->get()->count("id_tamu");
                
                
                                $data = Tamu::whereDate('tgl','<=',$this->tgl_akhir)
                                                    ->whereDate('tgl','>=',$this->tgl_awal)
                                                    ->orderBy('tgl','asc')
                                                    ->get();
                
            }else{
                                $total = Tamu::where('sales','=',$this->id_sales)
                                ->whereDate('tgl','<=',$this->tgl_akhir)
                                ->whereDate('tgl','>=',$this->tgl_awal)
                                ->get()->count("id_tamu");
                
                
                                $data = Tamu::where('sales','=',$this->id_sales)
                                                ->whereDate('tgl','<=',$this->tgl_akhir)
                                                    ->whereDate('tgl','>=',$this->tgl_awal)
                                                    ->orderBy('tgl','asc')
                                                    ->get();
                
            }
       
        return view('tamu.exportexcel_tamu', [
            'data' => $data,'total' => $total
        ]);
    }

}
