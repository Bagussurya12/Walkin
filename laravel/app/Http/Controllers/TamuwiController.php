<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Tamu;
use Illuminate\Support\Facades\DB;

class TamuwiController extends Controller
{
    
    public function index()
    {
        $sales = User::where('level','=','sales')->get();
        
        return view('tamuwi',['data_sales' => $sales]);

        
    }

    public function store(Request $request)
    {        
        $today = date('Y-m-d');

        $cekdata = Tamu::where('hp','=',$request->hp)->count("id_tamu");

        if($cekdata > 1){
          
            return redirect()->back()->with('warning','Data sudah ada di database, anda tidak bisa melakukan input ganda, silahkan masukan data tamu yang lain yaa..');
            
        }else{

        $tabel = new Tamu;
        $tabel->nama = $request->nama;
        $tabel->hp = $request->hp;
        $tabel->email = $request->email;
        $tabel->alamat_domisili = $request->alamat;
        
        $tabel->sumber = $request->sumber;
        $tabel->sumberlain = $request->sumberlain;
        $tabel->referensi = $request->referensi;
        $tabel->sales = $request->sales;
        $tabel->tgl = $today;
        $tabel->bulan = date('m', strtotime($today));
        $tabel->tahun = date('Y', strtotime($today));

        $tabel->status = 'baru';

        $sales_senior = User::where('id','=',$request->sales)->first();
        $tabel->id_sales_senior = $sales_senior->id_sales_senior;

        
        $tabel->jk = $request->jk;

        if($request->tgl_lahir !== null){
            $awal  = date_create($request->tgl_lahir);
            $akhir = date_create(); // waktu sekarang
            $diff  = date_diff( $awal, $akhir );
    
            
            $tabel->umur = $diff->y;
            $tabel->tgl_lahir = $request->tgl_lahir;
        }else{
            $tabel->umur = null;
            $tabel->tgl_lahir = null;
        }
        
        $tabel->save();

        return redirect()->back()->with('success','Data berhasil disimpan');

        }
        

    }
}
