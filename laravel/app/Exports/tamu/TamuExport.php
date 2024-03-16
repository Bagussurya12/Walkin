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
    protected $id_sales_senior;
    protected $tgl_awal;
    protected $tgl_akhir;

    function __construct($id_sales,$id_sales_senior,$tgl_awal,$tgl_akhir) {
            $this->id_sales = $id_sales;
            $this->id_sales_senior = $id_sales_senior;
            $this->tgl_awal = $tgl_awal;
            $this->tgl_akhir = $tgl_akhir;
    }



    public function view(): View
    {

        if($this->id_sales == '' && $this->id_sales_senior == ''){
            $total = Tamu::whereDate('tgl','<=',$this->tgl_akhir)
                            ->whereDate('tgl','>=',$this->tgl_awal)
                            ->get()->count("id_tamu");

            $data =  DB::table('tabel_tamu')
                    ->join('users', 'users.id', '=', 'tabel_tamu.sales')
                    ->whereDate('tabel_tamu.tgl','<=',$this->tgl_akhir)
                    ->whereDate('tabel_tamu.tgl','>=',$this->tgl_awal)
                    ->orderBy('tgl','asc')
                    ->get();

             foreach ($data as $key => $value) {
                $nama = DB::table('users')
                        ->select('name')
                        ->where('id','=',$value->id_sales_senior)
                        ->get();

                $data[$key]->namaSalesManager = $nama->name;       
            }        

            $data2 =  DB::table('tabel_tamu')
                    ->join('users', 'users.id', '=', 'tabel_tamu.id_sales_senior')
                    ->whereDate('tabel_tamu.tgl','<=',$this->tgl_akhir)
                    ->whereDate('tabel_tamu.tgl','>=',$this->tgl_awal)
                    ->orderBy('tgl','asc')
                    ->get();

                    $get = 1;


            // $data = Tamu::whereDate('tabel_tamu.tgl','<=',$this->tgl_akhir)
            //                     ->join('users', 'users.id', '=', 'tabel_tamu.sales')
            //                     ->whereDate('tabel_tamu.tgl','>=',$this->tgl_awal)
            //                     ->orderBy('tabel_tamu.tgl','asc')
            //                     ->select('tabel_tamu.* , users.name as namaSales')
            //                     ->get();

            

        }else if($this->id_sales == '' && $this->id_sales_senior !== ''){

            $total = Tamu::where('id_sales_senior','=',$this->id_sales_senior)->whereDate('tgl','<=',$this->tgl_akhir)
                            ->whereDate('tgl','>=',$this->tgl_awal)
                            ->get()->count("id_tamu");


            $data = Tamu::where('id_sales_senior','=',$this->id_sales_senior)->whereDate('tgl','<=',$this->tgl_akhir)
                                ->whereDate('tgl','>=',$this->tgl_awal)
                                ->orderBy('tgl','asc')
                                ->get();

                                $get = 0;

            

        }else if($this->id_sales !== '' && $this->id_sales_senior == ''){

            $total = Tamu::where('sales','=',$this->id_sales)->whereDate('tgl','<=',$this->tgl_akhir)
                            ->whereDate('tgl','>=',$this->tgl_awal)
                            ->get()->count("id_tamu");


            $data = Tamu::where('sales','=',$this->id_sales)->whereDate('tgl','<=',$this->tgl_akhir)
                                ->whereDate('tgl','>=',$this->tgl_awal)
                                ->orderBy('tgl','asc')
                                ->get();
                                $get = 0;

            

        }else{

            $total = Tamu::where('sales','=',$this->id_sales)->where('id_sales_senior','=',$this->id_sales_senior)
            ->whereDate('tgl','<=',$this->tgl_akhir)
            ->whereDate('tgl','>=',$this->tgl_awal)
            ->get()->count("id_tamu");


            $data = Tamu::where('sales','=',$this->id_sales)->where('id_sales_senior','=',$this->id_sales_senior)
                            ->whereDate('tgl','<=',$this->tgl_akhir)
                                ->whereDate('tgl','>=',$this->tgl_awal)
                                ->orderBy('tgl','asc')
                                ->get();
                                $get = 0;

            
        }
       
        return view('tamu.exportexcel_tamu', [
            'data' => $data,'total' => $total, 'get' => $data2
        ]);
    }

}
