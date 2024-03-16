<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Tamu;
use App\Tamu_keterangan_prosfek;
use App\User;
use App\Tamuhistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\tamu\TamuExport;
use App\Exports\user\UserExport;
use App\Imports\TamuImport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Http\Request;
class TamuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Asia/Jakarta');
    }
    
    public function importexcel_tamu(Request $request) 
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');
        $nama_file = rand().$file->getClientOriginalName();
        $file->move('assets_backend/img/tamu',$nama_file);

        Excel::import(new TamuImport, public_path('/assets_backend/img/tamu/'.$nama_file));
        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    public function exportexcel_tamu(Request $request){
        $today = date('Y-m-d');
         return Excel::download(new TamuExport($request->id_sales,$request->id_sales_senior,$request->tgl_awal,$request->tgl_akhir), $today.'_exportexcel_tamu.xlsx');
         
        
     } 

     public function exportexcel_sales(){
        $today = date('Y-m-d');
         return Excel::download(new UserExport(), $today.'_exportexcel_sales.xlsx');
         
        
     } 

     

    public function show_reporttamu(Request $request){
            $sales = $request->id_sales;
            $id_sales_senior = $request->id_sales_senior;
            $cari1 = $request->tgl_awal;
            $cari2 = $request->tgl_akhir;
        
            if($request->id_sales == '' && $request->id_sales_senior == ''){
                $total = Tamu::whereDate('tgl','<=',$cari2)
                                ->whereDate('tgl','>=',$cari1)
                                ->get()->count("id_tamu");


                $data = Tamu::whereDate('tgl','<=',$cari2)
                                    ->whereDate('tgl','>=',$cari1)
                                    ->orderBy('tgl','asc')
                                    ->get();

                

            }else if($request->id_sales == '' && $request->id_sales_senior !== ''){

                $total = Tamu::where('id_sales_senior','=',$id_sales_senior)->whereDate('tgl','<=',$cari2)
                                ->whereDate('tgl','>=',$cari1)
                                ->get()->count("id_tamu");


                $data = Tamu::where('id_sales_senior','=',$id_sales_senior)->whereDate('tgl','<=',$cari2)
                                    ->whereDate('tgl','>=',$cari1)
                                    ->orderBy('tgl','asc')
                                    ->get();

                

            }else if($request->id_sales !== '' && $request->id_sales_senior == ''){

                $total = Tamu::where('sales','=',$sales)->whereDate('tgl','<=',$cari2)
                                ->whereDate('tgl','>=',$cari1)
                                ->get()->count("id_tamu");


                $data = Tamu::where('sales','=',$sales)->whereDate('tgl','<=',$cari2)
                                    ->whereDate('tgl','>=',$cari1)
                                    ->orderBy('tgl','asc')
                                    ->get();

                

            }else{

                $total = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
                ->whereDate('tgl','<=',$cari2)
                ->whereDate('tgl','>=',$cari1)
                ->get()->count("id_tamu");


                $data = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
                                ->whereDate('tgl','<=',$cari2)
                                    ->whereDate('tgl','>=',$cari1)
                                    ->orderBy('tgl','asc')
                                    ->get();

                
            }

            $sales = User::where('level','=','sales')->get();
            $sales_senior = User::where('level','=','sales_senior')->get();

        return view('tamu.index',['data_user' => $data,'data_sales' => $sales, 'total'=>$total, 'sales_senior' => $sales_senior]);
    }

    public function index_home()
    {
            return view('dashboard.index');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level = \Auth::user()->level;
        if($level == 'sales'){
            $id = \Auth::user()->id;
            $data = Tamu::where('sales','=',$id)->orderBy('tgl','desc')->get();
            $data_keterangan = Tamu_keterangan_prosfek::all();

            return view('tamu.index',['data_user' => $data, 'data_keterangan' => $data_keterangan]);

        }else if($level == 'sales_senior'){
            $id = \Auth::user()->id;
            $data = Tamu::where('id_sales_senior','=',$id)->orderBy('tgl','desc')->get();
            $data_keterangan = Tamu_keterangan_prosfek::all();

            return view('tamu.index',['data_user' => $data, 'data_keterangan' => $data_keterangan]);

        }else{
            $data = Tamu::orderBy('tgl','desc')->get();
            $sales = User::where('level','=','sales')->get();
            $sales_senior = User::where('level','=','sales_senior')->get();
            return view('tamu.index',['data_user' => $data, 'data_sales' => $sales, 'sales_senior' => $sales_senior]);
        }
        
        
    }

    public function detail($id)
    {
      //  $id_user = \Auth::user()->id;
       // $decrypted = Crypt::decryptString($id);
       $decript = Crypt::decrypt($id);
        $data = Tamu::where('id_tamu','=',$decript)->first();
        $data_history = Tamuhistory::where('id_tamu','=',$decript)->get();

        $data_keterangan = Tamu_keterangan_prosfek::get();
          
        return view('tamu.detail',['data_tamu' => $data, 'data_history' => $data_history, 'data_keterangan' => $data_keterangan]);
        
        
        
    }

    public function getKeterangan(Request $request){
        $data_keterangan = Tamu_keterangan_prosfek::where("status",$request->status)->pluck('id_keterangan','keterangan');
        return response()->json($data_keterangan);
    }


    public function create()
    {
        
        return view('tamu.tambah');
    }

    public function create_at_recepsionis()
    {
        $data = User::where('level','=','sales')->get();
        return view('tamu.tambah',['sales' => $data]);
    }

    public function grafik()
    {
        $data = Tamu::all();
        $sales = User::where('level','=','sales')->get();
        $sales_senior = User::where('level','=','sales_senior')->get();
        return view('tamu.grafik',['data_user' => $data, 'data_sales' => $sales, 'sales_senior' => $sales_senior]);
    }

    public function show_grafik(Request $request){
        $sales = $request->id_sales;
        $id_sales_senior = $request->id_sales_senior;
        $tahun = $request->tahun;
    
        if($request->id_sales == '' && $request->id_sales_senior == ''){
            // sumber_informasi
            // media_publikasi
            $total_keseluruhan_jan_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            // website
            $total_keseluruhan_jan_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_website = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('sumber','=','website')
            ->count("id_tamu");
            // social_media
            
            $total_keseluruhan_jan_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            // database
          
            $total_keseluruhan_jan_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_database = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('sumber','=','database')
            ->count("id_tamu");
            // lain
            $total_keseluruhan_jan_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('sumber','=','lain')
            ->count("id_tamu");

            //===============================================================================================================


            // segmen by umur
            //all umur 18-24
            $total_keseluruhan_jan_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 25-34
            $total_keseluruhan_jan_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            

            //------------------------------------------------------------------------------------------------===================

            //all umur 35-44
            $total_keseluruhan_jan_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 45-54
            $total_keseluruhan_jan_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur 55-64
            $total_keseluruhan_jan_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur >65
            $total_keseluruhan_jan_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('umur','>=','65')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_65 = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");







            //================================
            //================================
            // segmen by jenis kelamin
            //all pria
            $total_keseluruhan_jan_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_feb_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_mar_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_pria = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')->where('jk','=','pria')
            ->count("id_tamu");


            // all wanita
            
            $total_keseluruhan_jan_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_feb_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mar_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_agu_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_wanita = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')->where('jk','=','wanita')
            ->count("id_tamu");



            //----------
            //---------------------------------------------------------------
        
            $total_keseluruhan_jan = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->count("id_tamu");

            $total_keseluruhan_feb = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->count("id_tamu");

            $total_keseluruhan_mar = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->count("id_tamu");

            $total_keseluruhan_apr = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->count("id_tamu");

            $total_keseluruhan_mei = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->count("id_tamu");

            $total_keseluruhan_jun = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->count("id_tamu");

            $total_keseluruhan_jul = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->count("id_tamu");

            $total_keseluruhan_agu = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->count("id_tamu");

            $total_keseluruhan_sep = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->count("id_tamu");

            $total_keseluruhan_okt = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->count("id_tamu");

            $total_keseluruhan_nov = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->count("id_tamu");

            $total_keseluruhan_des = Tamu::where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->count("id_tamu");

            //bulan jan
            $total_baru_jan = Tamu::where('status','=','baru')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
                            ->get()->count("id_tamu");
                            
            $total_proses_jan = Tamu::where('status','=','proses')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
                            ->get()->count("id_tamu");

            $total_closing_jan = Tamu::where('status','=','closing')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
                            ->get()->count("id_tamu");

            $total_batal_jan = Tamu::where('status','=','batal')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
                            ->get()->count("id_tamu");

            $total_reserve_jan = Tamu::where('status','=','reserve')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
                            ->get()->count("id_tamu");

            //------------
            //bulan Feb
            $total_baru_feb = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','02')
                            ->get()->count("id_tamu");
                            
            $total_proses_feb = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','02')
                            ->get()->count("id_tamu");

            $total_closing_feb = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','02')
                            ->get()->count("id_tamu");

            $total_batal_feb = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','02')
                            ->get()->count("id_tamu");
            
            $total_reserve_feb = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','02')
                            ->get()->count("id_tamu");

            //------------
            //bulan Mar
            $total_baru_mar = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
                            
            $total_proses_mar = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_closing_mar = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_batal_mar = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
                            
            $total_reserve_mar = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
            //------------
            //bulan apr
            $total_baru_apr = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");
                            
            $total_proses_apr = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_closing_apr = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_batal_apr = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_reserve_apr = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            //------------
            //bulan mei
            $total_baru_mei = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");
                            
            $total_proses_mei = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_closing_mei = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_batal_mei = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_reserve_mei = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            //------------
            //bulan juni
            $total_baru_jun = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");
                            
            $total_proses_jun = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_closing_jun = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_batal_jun = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_reserve_jun = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            //------------
            //bulan juli
            $total_baru_jul = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");
                            
            $total_proses_jul = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_closing_jul = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_batal_jul = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_reserve_jul = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            //------------

            //bulan agu
            $total_baru_agu = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");
                            
            $total_proses_agu = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_closing_agu = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_batal_agu = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_reserve_agu = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            //------------
            //bulan sept
            $total_baru_sep = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");
                            
            $total_proses_sep = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_closing_sep = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_batal_sep = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_reserve_sep = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            //------------
            //bulan okt
            $total_baru_okt = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");
                            
            $total_proses_okt = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_closing_okt = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_batal_okt = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");
                           
            $total_reserve_okt = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            //------------
            //bulan nov
            $total_baru_nov = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");
                            
            $total_proses_nov = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_closing_nov = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_batal_nov = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_reserve_nov = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            //------------
            //bulan des
            $total_baru_des = Tamu::where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");
                            
            $total_proses_des = Tamu::where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_closing_des = Tamu::where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_batal_des = Tamu::where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_reserve_des = Tamu::where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            //------------

          
        }else if($request->id_sales !== '' && $request->id_sales_senior == ''){

            // sumber_informasi
            // media_publikasi
            $total_keseluruhan_jan_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            // website
            $total_keseluruhan_jan_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','website')
            ->count("id_tamu");
            // social_media
            $total_keseluruhan_jan_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            // database
            $total_keseluruhan_jan_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','database')
            ->count("id_tamu");
            // lain
            $total_keseluruhan_jan_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','lain')
            ->count("id_tamu");

            //===============================================================================================================


            // segmen by umur
            //all umur 18-24
            $total_keseluruhan_jan_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 25-34
            $total_keseluruhan_jan_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            

            //------------------------------------------------------------------------------------------------===================

            //all umur 35-44
            $total_keseluruhan_jan_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 45-54
            $total_keseluruhan_jan_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur 55-64
            $total_keseluruhan_jan_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur >65
            $total_keseluruhan_jan_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','>=','65')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");






             // segmen by jenis kelamin
            //all pria
            $total_keseluruhan_jan_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_feb_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_mar_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_pria = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')->where('jk','=','pria')
            ->count("id_tamu");


            // all wanita
            
            $total_keseluruhan_jan_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_feb_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','02')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mar_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','03')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','04')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','05')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','06')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','07')->where('jk','=','prwanitaia')
            ->count("id_tamu");

            $total_keseluruhan_agu_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','08')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','09')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','10')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','11')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_wanita = Tamu::where('tahun','=',$tahun)->where('sales','=',$sales)
            ->where('bulan','=','12')->where('jk','=','wanita')
            ->count("id_tamu");



            //----------
            //---------------------------------------------------------------


            $total_keseluruhan_jan = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->count("id_tamu");

            $total_keseluruhan_feb = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->count("id_tamu");

            $total_keseluruhan_mar = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->count("id_tamu");

            $total_keseluruhan_apr = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->count("id_tamu");

            $total_keseluruhan_mei = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->count("id_tamu");

            $total_keseluruhan_jun = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->count("id_tamu");

            $total_keseluruhan_jul = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->count("id_tamu");

            $total_keseluruhan_agu = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->count("id_tamu");

            $total_keseluruhan_sep = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->count("id_tamu");

            $total_keseluruhan_okt = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->count("id_tamu");

            $total_keseluruhan_nov = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->count("id_tamu");

            $total_keseluruhan_des = Tamu::where('sales','=',$sales)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->count("id_tamu");

            //bulan jan
            $total_baru_jan = Tamu::where('sales','=',$sales)->where('status','=','baru')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_proses_jan = Tamu::where('sales','=',$sales)->where('status','=','proses')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_closing_jan = Tamu::where('sales','=',$sales)->where('status','=','closing')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");
            
            $total_batal_jan = Tamu::where('sales','=',$sales)->where('status','=','batal')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_reserve_jan = Tamu::where('sales','=',$sales)->where('status','=','reserve')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");


           //--------

           //bulan feb
           $total_baru_feb = Tamu::where('sales','=',$sales)->where('status','=','baru')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_proses_feb = Tamu::where('sales','=',$sales)->where('status','=','proses')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_closing_feb = Tamu::where('sales','=',$sales)->where('status','=','closing')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");
           
           $total_batal_feb = Tamu::where('sales','=',$sales)->where('status','=','batal')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_reserve_feb = Tamu::where('sales','=',$sales)->where('status','=','reserve')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

            //bulan Mar
            $total_baru_mar = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
                            
            $total_proses_mar = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_closing_mar = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_batal_mar = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_reserve_mar = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            //------------
            //bulan apr
            $total_baru_apr = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");
                            
            $total_proses_apr = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_closing_apr = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_batal_apr = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_reserve_apr = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            //------------
            //bulan mei
            $total_baru_mei = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");
                            
            $total_proses_mei = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_closing_mei = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_batal_mei = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_reserve_mei = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            //------------
            //bulan juni
            $total_baru_jun = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");
                            
            $total_proses_jun = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_closing_jun = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_batal_jun = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_reserve_jun = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            //------------
            //bulan juli
            $total_baru_jul = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");
                            
            $total_proses_jul = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_closing_jul = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_batal_jul = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

                            $total_reserve_jul = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            //------------

            //bulan agu
            $total_baru_agu = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");
                            
            $total_proses_agu = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_closing_agu = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_batal_agu = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

                            $total_reserve_agu = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            //------------
            //bulan sept
            $total_baru_sep = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");
                            
            $total_proses_sep = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_closing_sep = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_batal_sep = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

                            $total_reserve_sep = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            //------------
            //bulan okt
            $total_baru_okt = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");
                            
            $total_proses_okt = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_closing_okt = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_batal_okt = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

                            $total_reserve_okt = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            //------------
            //bulan nov
            $total_baru_nov = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");
                            
            $total_proses_nov = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_closing_nov = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_batal_nov = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

                            $total_reserve_nov = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            //------------
            //bulan des
            $total_baru_des = Tamu::where('sales','=',$sales)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");
                            
            $total_proses_des = Tamu::where('sales','=',$sales)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_closing_des = Tamu::where('sales','=',$sales)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_batal_des = Tamu::where('sales','=',$sales)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

                            $total_reserve_des = Tamu::where('sales','=',$sales)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            //------------
          //--------
        }else if($request->id_sales == '' && $request->id_sales_senior !== ''){
            // sumber_informasi
            // media_publikasi
            $total_keseluruhan_jan_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            // website
            $total_keseluruhan_jan_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('sumber','=','website')
            ->count("id_tamu");
            // social_media
            $total_keseluruhan_jan_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            // database
            $total_keseluruhan_jan_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('sumber','=','database')
            ->count("id_tamu");
            // lain
            $total_keseluruhan_jan_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('sumber','=','lain')
            ->count("id_tamu");

            //===============================================================================================================


            // segmen by umur
            //all umur 18-24
            $total_keseluruhan_jan_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 25-34
            $total_keseluruhan_jan_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            

            //------------------------------------------------------------------------------------------------===================

            //all umur 35-44
            $total_keseluruhan_jan_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 45-54
            $total_keseluruhan_jan_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur 55-64
            $total_keseluruhan_jan_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur >65
            $total_keseluruhan_jan_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('umur','>=','65')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");





            // segmen by jenis kelamin
            //all pria
            $total_keseluruhan_jan_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_feb_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_mar_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')->where('jk','=','pria')
            ->count("id_tamu");


            // all wanita
            
            $total_keseluruhan_jan_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_feb_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','02')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mar_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','03')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','04')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','05')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','06')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','07')->where('jk','=','prwanitaia')
            ->count("id_tamu");

            $total_keseluruhan_agu_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','08')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','09')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','10')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','11')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)
            ->where('bulan','=','12')->where('jk','=','wanita')
            ->count("id_tamu");



            //----------
            //---------------------------------------------------------------



            $total_keseluruhan_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->count("id_tamu");

            $total_keseluruhan_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->count("id_tamu");

            $total_keseluruhan_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->count("id_tamu");

            $total_keseluruhan_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->count("id_tamu");

            $total_keseluruhan_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->count("id_tamu");

            $total_keseluruhan_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->count("id_tamu");

            $total_keseluruhan_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->count("id_tamu");

            $total_keseluruhan_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->count("id_tamu");

            $total_keseluruhan_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->count("id_tamu");

            $total_keseluruhan_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->count("id_tamu");

            $total_keseluruhan_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->count("id_tamu");

            $total_keseluruhan_des = Tamu::where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->count("id_tamu");

            //bulan jan
            $total_baru_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_proses_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_closing_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");
            
            $total_batal_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_reserve_jan = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");


           //--------

           //bulan feb
           $total_baru_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_proses_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_closing_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");
           
           $total_batal_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_reserve_feb = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

            //bulan Mar
            $total_baru_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
                            
            $total_proses_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_closing_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_batal_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_reserve_mar = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            //------------
            //bulan apr
            $total_baru_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");
                            
            $total_proses_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_closing_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_batal_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_reserve_apr = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            //------------
            //bulan mei
            $total_baru_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");
                            
            $total_proses_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_closing_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_batal_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_reserve_mei = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            //------------
            //bulan juni
            $total_baru_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");
                            
            $total_proses_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_closing_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_batal_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_reserve_jun = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            //------------
            //bulan juli
            $total_baru_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");
                            
            $total_proses_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_closing_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_batal_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

                            $total_reserve_jul = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            //------------

            //bulan agu
            $total_baru_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");
                            
            $total_proses_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_closing_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_batal_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

                            $total_reserve_agu = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            //------------
            //bulan sept
            $total_baru_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");
                            
            $total_proses_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_closing_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_batal_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

                            $total_reserve_sep = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            //------------
            //bulan okt
            $total_baru_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");
                            
            $total_proses_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_closing_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_batal_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

                            $total_reserve_okt = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            //------------
            //bulan nov
            $total_baru_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");
                            
            $total_proses_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_closing_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_batal_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

                            $total_reserve_nov = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            //------------
            //bulan des
            $total_baru_des = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','baru')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");
                            
            $total_proses_des = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','proses')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_closing_des = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','closing')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_batal_des = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','batal')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

                            $total_reserve_des = Tamu::where('id_sales_senior','=',$id_sales_senior)->where('status','=','reserve')
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            
        }else{

            // sumber_informasi
            // media_publikasi
            $total_keseluruhan_jan_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_media_publikasi = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','media_publikasi')
            ->count("id_tamu");
            // website
            $total_keseluruhan_jan_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','website')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_website = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','website')
            ->count("id_tamu");
            // social_media
            $total_keseluruhan_jan_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_social_media = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','social_media')
            ->count("id_tamu");
            // database
            $total_keseluruhan_jan_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','database')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_database = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','database')
            ->count("id_tamu");
            // lain
            $total_keseluruhan_jan_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_feb_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mar_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_apr_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_mei_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jun_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_jul_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_agu_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_sep_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_okt_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_nov_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('sumber','=','lain')
            ->count("id_tamu");
            $total_keseluruhan_des_sumber_informasi_lain = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('sumber','=','lain')
            ->count("id_tamu");

            //===============================================================================================================


            // segmen by umur
            //all umur 18-24
            $total_keseluruhan_jan_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_18_24 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','24')
            ->where('umur','>=','18')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 25-34
            $total_keseluruhan_jan_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_25_34 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','34')
            ->where('umur','>=','25')
            ->count("id_tamu");
            

            //------------------------------------------------------------------------------------------------===================

            //all umur 35-44
            $total_keseluruhan_jan_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_35_44 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','44')
            ->where('umur','>=','35')
            ->count("id_tamu");

            //------------------------------------------------------------------------------------------------===================

            //all umur 45-54
            $total_keseluruhan_jan_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_45_54 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','54')
            ->where('umur','>=','45')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur 55-64
            $total_keseluruhan_jan_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_55_64 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','<=','64')
            ->where('umur','>=','55')
            ->count("id_tamu");


            //------------------------------------------------------------------------------------------------===================

            //all umur >65
            $total_keseluruhan_jan_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_all_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('umur','>=','65')
            ->count("id_tamu");

            //-------------------

            $total_keseluruhan_jan_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_agu_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_pria_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','pria')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            //-------------------
            
            $total_keseluruhan_jan_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_feb_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mar_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_apr_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_mei_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jun_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_jul_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_sep_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_okt_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_nov_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");

            $total_keseluruhan_des_wanita_umur_65 = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')
            ->where('jk','=','wanita')
            ->where('umur','>=','65')
            ->count("id_tamu");





            // segmen by jenis kelamin
            //all pria
            $total_keseluruhan_jan_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_feb_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_mar_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')->where('jk','=','pria')
            ->count("id_tamu");
            
            $total_keseluruhan_agu_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')->where('jk','=','pria')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_pria = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')->where('jk','=','pria')
            ->count("id_tamu");


            // all wanita
            
            $total_keseluruhan_jan_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','01')
            ->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_feb_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','02')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mar_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','03')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_apr_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','04')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_mei_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','05')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jun_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','06')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_jul_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','07')->where('jk','=','prwanitaia')
            ->count("id_tamu");

            $total_keseluruhan_agu_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','08')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_sep_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','09')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_okt_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','10')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_nov_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','11')->where('jk','=','wanita')
            ->count("id_tamu");

            $total_keseluruhan_des_jk_wanita = Tamu::where('tahun','=',$tahun)->where('id_sales_senior','=',$id_sales_senior)->where('sales','=',$sales)
            ->where('bulan','=','12')->where('jk','=','wanita')
            ->count("id_tamu");



            //----------
            //---------------------------------------------------------------


            
            $total_keseluruhan_jan = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->count("id_tamu");

            $total_keseluruhan_feb = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','02')
            ->count("id_tamu");

            $total_keseluruhan_mar = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','03')
            ->count("id_tamu");

            $total_keseluruhan_apr = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','04')
            ->count("id_tamu");

            $total_keseluruhan_mei = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','05')
            ->count("id_tamu");

            $total_keseluruhan_jun = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','06')
            ->count("id_tamu");

            $total_keseluruhan_jul = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','07')
            ->count("id_tamu");

            $total_keseluruhan_agu = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','08')
            ->count("id_tamu");

            $total_keseluruhan_sep = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','09')
            ->count("id_tamu");

            $total_keseluruhan_okt = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','10')
            ->count("id_tamu");

            $total_keseluruhan_nov = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','11')
            ->count("id_tamu");

            $total_keseluruhan_des = Tamu::where('sales','=',$sales)->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','12')
            ->count("id_tamu");

            //bulan jan
            $total_baru_jan = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_proses_jan = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_closing_jan = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");
            
            $total_batal_jan = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");

            $total_reserve_jan = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
            ->where('tahun','=',$tahun)
            ->where('bulan','=','01')
            ->get()->count("id_tamu");


           //--------

           //bulan feb
           $total_baru_feb = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_proses_feb = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_closing_feb = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");
           
           $total_batal_feb = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

           $total_reserve_feb = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
           ->where('tahun','=',$tahun)
           ->where('bulan','=','02')
           ->get()->count("id_tamu");

            //bulan Mar
            $total_baru_mar = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");
                            
            $total_proses_mar = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_closing_mar = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_batal_mar = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            $total_reserve_mar = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','03')
                            ->get()->count("id_tamu");

            //------------
            //bulan apr
            $total_baru_apr = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");
                            
            $total_proses_apr = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_closing_apr = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_batal_apr = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            $total_reserve_apr = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','04')
                            ->get()->count("id_tamu");

            //------------
            //bulan mei
            $total_baru_mei = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");
                            
            $total_proses_mei = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_closing_mei = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_batal_mei = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            $total_reserve_mei = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','05')
                            ->get()->count("id_tamu");

            //------------
            //bulan juni
            $total_baru_jun = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");
                            
            $total_proses_jun = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_closing_jun = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_batal_jun = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            $total_reserve_jun = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','06')
                            ->get()->count("id_tamu");

            //------------
            //bulan juli
            $total_baru_jul = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");
                            
            $total_proses_jul = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_closing_jul = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            $total_batal_jul = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

                            $total_reserve_jul = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','07')
                            ->get()->count("id_tamu");

            //------------

            //bulan agu
            $total_baru_agu = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");
                            
            $total_proses_agu = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_closing_agu = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            $total_batal_agu = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

                            $total_reserve_agu = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','08')
                            ->get()->count("id_tamu");

            //------------
            //bulan sept
            $total_baru_sep = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");
                            
            $total_proses_sep = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_closing_sep = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            $total_batal_sep = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

                            $total_reserve_sep = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','09')
                            ->get()->count("id_tamu");

            //------------
            //bulan okt
            $total_baru_okt = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");
                            
            $total_proses_okt = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_closing_okt = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            $total_batal_okt = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

                            $total_reserve_okt = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','10')
                            ->get()->count("id_tamu");

            //------------
            //bulan nov
            $total_baru_nov = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");
                            
            $total_proses_nov = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_closing_nov = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            $total_batal_nov = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

                            $total_reserve_nov = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','11')
                            ->get()->count("id_tamu");

            //------------
            //bulan des
            $total_baru_des = Tamu::where('sales','=',$sales)->where('status','=','baru')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");
                            
            $total_proses_des = Tamu::where('sales','=',$sales)->where('status','=','proses')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_closing_des = Tamu::where('sales','=',$sales)->where('status','=','closing')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

            $total_batal_des = Tamu::where('sales','=',$sales)->where('status','=','batal')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

                            $total_reserve_des = Tamu::where('sales','=',$sales)->where('status','=','reserve')->where('id_sales_senior','=',$id_sales_senior)
                            ->where('tahun','=',$tahun)
                            ->where('bulan','=','12')
                            ->get()->count("id_tamu");

           
            
        }
        $sales = User::where('level','=','sales')->get();
        $sales_senior = User::where('level','=','sales_senior')->get();


        return view('tamu.grafik',['data_sales' => $sales, 'sales_senior' => $sales_senior,
                                    //----------------------------------sumber informasi
                                    //media_publikasi
                                    'total_keseluruhan_jan_sumber_informasi_media_publikasi'=>$total_keseluruhan_jan_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_feb_sumber_informasi_media_publikasi'=>$total_keseluruhan_feb_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_mar_sumber_informasi_media_publikasi'=>$total_keseluruhan_mar_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_apr_sumber_informasi_media_publikasi'=>$total_keseluruhan_apr_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_mei_sumber_informasi_media_publikasi'=>$total_keseluruhan_mei_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_jun_sumber_informasi_media_publikasi'=>$total_keseluruhan_jun_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_jul_sumber_informasi_media_publikasi'=>$total_keseluruhan_jul_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_agu_sumber_informasi_media_publikasi'=>$total_keseluruhan_agu_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_sep_sumber_informasi_media_publikasi'=>$total_keseluruhan_sep_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_okt_sumber_informasi_media_publikasi'=>$total_keseluruhan_okt_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_nov_sumber_informasi_media_publikasi'=>$total_keseluruhan_nov_sumber_informasi_media_publikasi,
                                    'total_keseluruhan_des_sumber_informasi_media_publikasi'=>$total_keseluruhan_des_sumber_informasi_media_publikasi,

                                    //website
                                    'total_keseluruhan_jan_sumber_informasi_website'=>$total_keseluruhan_jan_sumber_informasi_website,
                                    'total_keseluruhan_feb_sumber_informasi_website'=>$total_keseluruhan_feb_sumber_informasi_website,
                                    'total_keseluruhan_mar_sumber_informasi_website'=>$total_keseluruhan_mar_sumber_informasi_website,
                                    'total_keseluruhan_apr_sumber_informasi_website'=>$total_keseluruhan_apr_sumber_informasi_website,
                                    'total_keseluruhan_mei_sumber_informasi_website'=>$total_keseluruhan_mei_sumber_informasi_website,
                                    'total_keseluruhan_jun_sumber_informasi_website'=>$total_keseluruhan_jun_sumber_informasi_website,
                                    'total_keseluruhan_jul_sumber_informasi_website'=>$total_keseluruhan_jul_sumber_informasi_website,
                                    'total_keseluruhan_agu_sumber_informasi_website'=>$total_keseluruhan_agu_sumber_informasi_website,
                                    'total_keseluruhan_sep_sumber_informasi_website'=>$total_keseluruhan_sep_sumber_informasi_website,
                                    'total_keseluruhan_okt_sumber_informasi_website'=>$total_keseluruhan_okt_sumber_informasi_website,
                                    'total_keseluruhan_nov_sumber_informasi_website'=>$total_keseluruhan_nov_sumber_informasi_website,
                                    'total_keseluruhan_des_sumber_informasi_website'=>$total_keseluruhan_des_sumber_informasi_website,

                                    //social_media
                                    'total_keseluruhan_jan_sumber_informasi_social_media'=>$total_keseluruhan_jan_sumber_informasi_social_media,
                                    'total_keseluruhan_feb_sumber_informasi_social_media'=>$total_keseluruhan_feb_sumber_informasi_social_media,
                                    'total_keseluruhan_mar_sumber_informasi_social_media'=>$total_keseluruhan_mar_sumber_informasi_social_media,
                                    'total_keseluruhan_apr_sumber_informasi_social_media'=>$total_keseluruhan_apr_sumber_informasi_social_media,
                                    'total_keseluruhan_mei_sumber_informasi_social_media'=>$total_keseluruhan_mei_sumber_informasi_social_media,
                                    'total_keseluruhan_jun_sumber_informasi_social_media'=>$total_keseluruhan_jun_sumber_informasi_social_media,
                                    'total_keseluruhan_jul_sumber_informasi_social_media'=>$total_keseluruhan_jul_sumber_informasi_social_media,
                                    'total_keseluruhan_agu_sumber_informasi_social_media'=>$total_keseluruhan_agu_sumber_informasi_social_media,
                                    'total_keseluruhan_sep_sumber_informasi_social_media'=>$total_keseluruhan_sep_sumber_informasi_social_media,
                                    'total_keseluruhan_okt_sumber_informasi_social_media'=>$total_keseluruhan_okt_sumber_informasi_social_media,
                                    'total_keseluruhan_nov_sumber_informasi_social_media'=>$total_keseluruhan_nov_sumber_informasi_social_media,
                                    'total_keseluruhan_des_sumber_informasi_social_media'=>$total_keseluruhan_des_sumber_informasi_social_media,

                                    //database
                                    'total_keseluruhan_jan_sumber_informasi_database'=>$total_keseluruhan_jan_sumber_informasi_database,
                                    'total_keseluruhan_feb_sumber_informasi_database'=>$total_keseluruhan_feb_sumber_informasi_database,
                                    'total_keseluruhan_mar_sumber_informasi_database'=>$total_keseluruhan_mar_sumber_informasi_database,
                                    'total_keseluruhan_apr_sumber_informasi_database'=>$total_keseluruhan_apr_sumber_informasi_database,
                                    'total_keseluruhan_mei_sumber_informasi_database'=>$total_keseluruhan_mei_sumber_informasi_database,
                                    'total_keseluruhan_jun_sumber_informasi_database'=>$total_keseluruhan_jun_sumber_informasi_database,
                                    'total_keseluruhan_jul_sumber_informasi_database'=>$total_keseluruhan_jul_sumber_informasi_database,
                                    'total_keseluruhan_agu_sumber_informasi_database'=>$total_keseluruhan_agu_sumber_informasi_database,
                                    'total_keseluruhan_sep_sumber_informasi_database'=>$total_keseluruhan_sep_sumber_informasi_database,
                                    'total_keseluruhan_okt_sumber_informasi_database'=>$total_keseluruhan_okt_sumber_informasi_database,
                                    'total_keseluruhan_nov_sumber_informasi_database'=>$total_keseluruhan_nov_sumber_informasi_database,
                                    'total_keseluruhan_des_sumber_informasi_database'=>$total_keseluruhan_des_sumber_informasi_database,

                                    //lain
                                    'total_keseluruhan_jan_sumber_informasi_lain'=>$total_keseluruhan_jan_sumber_informasi_lain,
                                    'total_keseluruhan_feb_sumber_informasi_lain'=>$total_keseluruhan_feb_sumber_informasi_lain,
                                    'total_keseluruhan_mar_sumber_informasi_lain'=>$total_keseluruhan_mar_sumber_informasi_lain,
                                    'total_keseluruhan_apr_sumber_informasi_lain'=>$total_keseluruhan_apr_sumber_informasi_lain,
                                    'total_keseluruhan_mei_sumber_informasi_lain'=>$total_keseluruhan_mei_sumber_informasi_lain,
                                    'total_keseluruhan_jun_sumber_informasi_lain'=>$total_keseluruhan_jun_sumber_informasi_lain,
                                    'total_keseluruhan_jul_sumber_informasi_lain'=>$total_keseluruhan_jul_sumber_informasi_lain,
                                    'total_keseluruhan_agu_sumber_informasi_lain'=>$total_keseluruhan_agu_sumber_informasi_lain,
                                    'total_keseluruhan_sep_sumber_informasi_lain'=>$total_keseluruhan_sep_sumber_informasi_lain,
                                    'total_keseluruhan_okt_sumber_informasi_lain'=>$total_keseluruhan_okt_sumber_informasi_lain,
                                    'total_keseluruhan_nov_sumber_informasi_lain'=>$total_keseluruhan_nov_sumber_informasi_lain,
                                    'total_keseluruhan_des_sumber_informasi_lain'=>$total_keseluruhan_des_sumber_informasi_lain,
            
                                    //========================================
                                    //----------------------------------18_24
                                    'total_keseluruhan_jan_all_umur_18_24'=>$total_keseluruhan_jan_all_umur_18_24,
                                    'total_keseluruhan_feb_all_umur_18_24'=>$total_keseluruhan_feb_all_umur_18_24,
                                    'total_keseluruhan_mar_all_umur_18_24'=>$total_keseluruhan_mar_all_umur_18_24,
                                    'total_keseluruhan_apr_all_umur_18_24'=>$total_keseluruhan_apr_all_umur_18_24,
                                    'total_keseluruhan_mei_all_umur_18_24'=>$total_keseluruhan_mei_all_umur_18_24,
                                    'total_keseluruhan_jun_all_umur_18_24'=>$total_keseluruhan_jun_all_umur_18_24,
                                    'total_keseluruhan_jul_all_umur_18_24'=>$total_keseluruhan_jul_all_umur_18_24,
                                    'total_keseluruhan_agu_all_umur_18_24'=>$total_keseluruhan_agu_all_umur_18_24,
                                    'total_keseluruhan_sep_all_umur_18_24'=>$total_keseluruhan_sep_all_umur_18_24,
                                    'total_keseluruhan_okt_all_umur_18_24'=>$total_keseluruhan_okt_all_umur_18_24,
                                    'total_keseluruhan_nov_all_umur_18_24'=>$total_keseluruhan_nov_all_umur_18_24,
                                    'total_keseluruhan_des_all_umur_18_24'=>$total_keseluruhan_des_all_umur_18_24,


                                    'total_keseluruhan_jan_pria_umur_18_24'=>$total_keseluruhan_jan_pria_umur_18_24,
                                    'total_keseluruhan_feb_pria_umur_18_24'=>$total_keseluruhan_feb_pria_umur_18_24,
                                    'total_keseluruhan_mar_pria_umur_18_24'=>$total_keseluruhan_mar_pria_umur_18_24,
                                    'total_keseluruhan_apr_pria_umur_18_24'=>$total_keseluruhan_apr_pria_umur_18_24,
                                    'total_keseluruhan_mei_pria_umur_18_24'=>$total_keseluruhan_mei_pria_umur_18_24,
                                    'total_keseluruhan_jun_pria_umur_18_24'=>$total_keseluruhan_jun_pria_umur_18_24,
                                    'total_keseluruhan_jul_pria_umur_18_24'=>$total_keseluruhan_jul_pria_umur_18_24,
                                    'total_keseluruhan_agu_pria_umur_18_24'=>$total_keseluruhan_agu_pria_umur_18_24,
                                    'total_keseluruhan_sep_pria_umur_18_24'=>$total_keseluruhan_sep_pria_umur_18_24,
                                    'total_keseluruhan_okt_pria_umur_18_24'=>$total_keseluruhan_okt_pria_umur_18_24,
                                    'total_keseluruhan_nov_pria_umur_18_24'=>$total_keseluruhan_nov_pria_umur_18_24,
                                    'total_keseluruhan_des_pria_umur_18_24'=>$total_keseluruhan_des_pria_umur_18_24,


                                    'total_keseluruhan_jan_wanita_umur_18_24'=>$total_keseluruhan_jan_wanita_umur_18_24,
                                    'total_keseluruhan_feb_wanita_umur_18_24'=>$total_keseluruhan_feb_wanita_umur_18_24,
                                    'total_keseluruhan_mar_wanita_umur_18_24'=>$total_keseluruhan_mar_wanita_umur_18_24,
                                    'total_keseluruhan_apr_wanita_umur_18_24'=>$total_keseluruhan_apr_wanita_umur_18_24,
                                    'total_keseluruhan_mei_wanita_umur_18_24'=>$total_keseluruhan_mei_wanita_umur_18_24,
                                    'total_keseluruhan_jun_wanita_umur_18_24'=>$total_keseluruhan_jun_wanita_umur_18_24,
                                    'total_keseluruhan_jul_wanita_umur_18_24'=>$total_keseluruhan_jul_wanita_umur_18_24,
                                    'total_keseluruhan_agu_wanita_umur_18_24'=>$total_keseluruhan_agu_wanita_umur_18_24,
                                    'total_keseluruhan_sep_wanita_umur_18_24'=>$total_keseluruhan_sep_wanita_umur_18_24,
                                    'total_keseluruhan_okt_wanita_umur_18_24'=>$total_keseluruhan_okt_wanita_umur_18_24,
                                    'total_keseluruhan_nov_wanita_umur_18_24'=>$total_keseluruhan_nov_wanita_umur_18_24,
                                    'total_keseluruhan_des_wanita_umur_18_24'=>$total_keseluruhan_des_wanita_umur_18_24,

                                    //---------------------------------25_34

                                    'total_keseluruhan_jan_all_umur_25_34'=>$total_keseluruhan_jan_all_umur_25_34,
                                    'total_keseluruhan_feb_all_umur_25_34'=>$total_keseluruhan_feb_all_umur_25_34,
                                    'total_keseluruhan_mar_all_umur_25_34'=>$total_keseluruhan_mar_all_umur_25_34,
                                    'total_keseluruhan_apr_all_umur_25_34'=>$total_keseluruhan_apr_all_umur_25_34,
                                    'total_keseluruhan_mei_all_umur_25_34'=>$total_keseluruhan_mei_all_umur_25_34,
                                    'total_keseluruhan_jun_all_umur_25_34'=>$total_keseluruhan_jun_all_umur_25_34,
                                    'total_keseluruhan_jul_all_umur_25_34'=>$total_keseluruhan_jul_all_umur_25_34,
                                    'total_keseluruhan_agu_all_umur_25_34'=>$total_keseluruhan_agu_all_umur_25_34,
                                    'total_keseluruhan_sep_all_umur_25_34'=>$total_keseluruhan_sep_all_umur_25_34,
                                    'total_keseluruhan_okt_all_umur_25_34'=>$total_keseluruhan_okt_all_umur_25_34,
                                    'total_keseluruhan_nov_all_umur_25_34'=>$total_keseluruhan_nov_all_umur_25_34,
                                    'total_keseluruhan_des_all_umur_25_34'=>$total_keseluruhan_des_all_umur_25_34,


                                    'total_keseluruhan_jan_pria_umur_25_34'=>$total_keseluruhan_jan_pria_umur_25_34,
                                    'total_keseluruhan_feb_pria_umur_25_34'=>$total_keseluruhan_feb_pria_umur_25_34,
                                    'total_keseluruhan_mar_pria_umur_25_34'=>$total_keseluruhan_mar_pria_umur_25_34,
                                    'total_keseluruhan_apr_pria_umur_25_34'=>$total_keseluruhan_apr_pria_umur_25_34,
                                    'total_keseluruhan_mei_pria_umur_25_34'=>$total_keseluruhan_mei_pria_umur_25_34,
                                    'total_keseluruhan_jun_pria_umur_25_34'=>$total_keseluruhan_jun_pria_umur_25_34,
                                    'total_keseluruhan_jul_pria_umur_25_34'=>$total_keseluruhan_jul_pria_umur_25_34,
                                    'total_keseluruhan_agu_pria_umur_25_34'=>$total_keseluruhan_agu_pria_umur_25_34,
                                    'total_keseluruhan_sep_pria_umur_25_34'=>$total_keseluruhan_sep_pria_umur_25_34,
                                    'total_keseluruhan_okt_pria_umur_25_34'=>$total_keseluruhan_okt_pria_umur_25_34,
                                    'total_keseluruhan_nov_pria_umur_25_34'=>$total_keseluruhan_nov_pria_umur_25_34,
                                    'total_keseluruhan_des_pria_umur_25_34'=>$total_keseluruhan_des_pria_umur_25_34,


                                    'total_keseluruhan_jan_wanita_umur_25_34'=>$total_keseluruhan_jan_wanita_umur_25_34,
                                    'total_keseluruhan_feb_wanita_umur_25_34'=>$total_keseluruhan_feb_wanita_umur_25_34,
                                    'total_keseluruhan_mar_wanita_umur_25_34'=>$total_keseluruhan_mar_wanita_umur_25_34,
                                    'total_keseluruhan_apr_wanita_umur_25_34'=>$total_keseluruhan_apr_wanita_umur_25_34,
                                    'total_keseluruhan_mei_wanita_umur_25_34'=>$total_keseluruhan_mei_wanita_umur_25_34,
                                    'total_keseluruhan_jun_wanita_umur_25_34'=>$total_keseluruhan_jun_wanita_umur_25_34,
                                    'total_keseluruhan_jul_wanita_umur_25_34'=>$total_keseluruhan_jul_wanita_umur_25_34,
                                    'total_keseluruhan_agu_wanita_umur_25_34'=>$total_keseluruhan_agu_wanita_umur_25_34,
                                    'total_keseluruhan_sep_wanita_umur_25_34'=>$total_keseluruhan_sep_wanita_umur_25_34,
                                    'total_keseluruhan_okt_wanita_umur_25_34'=>$total_keseluruhan_okt_wanita_umur_25_34,
                                    'total_keseluruhan_nov_wanita_umur_25_34'=>$total_keseluruhan_nov_wanita_umur_25_34,
                                    'total_keseluruhan_des_wanita_umur_25_34'=>$total_keseluruhan_des_wanita_umur_25_34,

                                    //---------------------------------35-44

                                    'total_keseluruhan_jan_all_umur_35_44'=>$total_keseluruhan_jan_all_umur_35_44,
                                    'total_keseluruhan_feb_all_umur_35_44'=>$total_keseluruhan_feb_all_umur_35_44,
                                    'total_keseluruhan_mar_all_umur_35_44'=>$total_keseluruhan_mar_all_umur_35_44,
                                    'total_keseluruhan_apr_all_umur_35_44'=>$total_keseluruhan_apr_all_umur_35_44,
                                    'total_keseluruhan_mei_all_umur_35_44'=>$total_keseluruhan_mei_all_umur_35_44,
                                    'total_keseluruhan_jun_all_umur_35_44'=>$total_keseluruhan_jun_all_umur_35_44,
                                    'total_keseluruhan_jul_all_umur_35_44'=>$total_keseluruhan_jul_all_umur_35_44,
                                    'total_keseluruhan_agu_all_umur_35_44'=>$total_keseluruhan_agu_all_umur_35_44,
                                    'total_keseluruhan_sep_all_umur_35_44'=>$total_keseluruhan_sep_all_umur_35_44,
                                    'total_keseluruhan_okt_all_umur_35_44'=>$total_keseluruhan_okt_all_umur_35_44,
                                    'total_keseluruhan_nov_all_umur_35_44'=>$total_keseluruhan_nov_all_umur_35_44,
                                    'total_keseluruhan_des_all_umur_35_44'=>$total_keseluruhan_des_all_umur_35_44,


                                    'total_keseluruhan_jan_pria_umur_35_44'=>$total_keseluruhan_jan_pria_umur_35_44,
                                    'total_keseluruhan_feb_pria_umur_35_44'=>$total_keseluruhan_feb_pria_umur_35_44,
                                    'total_keseluruhan_mar_pria_umur_35_44'=>$total_keseluruhan_mar_pria_umur_35_44,
                                    'total_keseluruhan_apr_pria_umur_35_44'=>$total_keseluruhan_apr_pria_umur_35_44,
                                    'total_keseluruhan_mei_pria_umur_35_44'=>$total_keseluruhan_mei_pria_umur_35_44,
                                    'total_keseluruhan_jun_pria_umur_35_44'=>$total_keseluruhan_jun_pria_umur_35_44,
                                    'total_keseluruhan_jul_pria_umur_35_44'=>$total_keseluruhan_jul_pria_umur_35_44,
                                    'total_keseluruhan_agu_pria_umur_35_44'=>$total_keseluruhan_agu_pria_umur_35_44,
                                    'total_keseluruhan_sep_pria_umur_35_44'=>$total_keseluruhan_sep_pria_umur_35_44,
                                    'total_keseluruhan_okt_pria_umur_35_44'=>$total_keseluruhan_okt_pria_umur_35_44,
                                    'total_keseluruhan_nov_pria_umur_35_44'=>$total_keseluruhan_nov_pria_umur_35_44,
                                    'total_keseluruhan_des_pria_umur_35_44'=>$total_keseluruhan_des_pria_umur_35_44,


                                    'total_keseluruhan_jan_wanita_umur_35_44'=>$total_keseluruhan_jan_wanita_umur_35_44,
                                    'total_keseluruhan_feb_wanita_umur_35_44'=>$total_keseluruhan_feb_wanita_umur_35_44,
                                    'total_keseluruhan_mar_wanita_umur_35_44'=>$total_keseluruhan_mar_wanita_umur_35_44,
                                    'total_keseluruhan_apr_wanita_umur_35_44'=>$total_keseluruhan_apr_wanita_umur_35_44,
                                    'total_keseluruhan_mei_wanita_umur_35_44'=>$total_keseluruhan_mei_wanita_umur_35_44,
                                    'total_keseluruhan_jun_wanita_umur_35_44'=>$total_keseluruhan_jun_wanita_umur_35_44,
                                    'total_keseluruhan_jul_wanita_umur_35_44'=>$total_keseluruhan_jul_wanita_umur_35_44,
                                    'total_keseluruhan_agu_wanita_umur_35_44'=>$total_keseluruhan_agu_wanita_umur_35_44,
                                    'total_keseluruhan_sep_wanita_umur_35_44'=>$total_keseluruhan_sep_wanita_umur_35_44,
                                    'total_keseluruhan_okt_wanita_umur_35_44'=>$total_keseluruhan_okt_wanita_umur_35_44,
                                    'total_keseluruhan_nov_wanita_umur_35_44'=>$total_keseluruhan_nov_wanita_umur_35_44,
                                    'total_keseluruhan_des_wanita_umur_35_44'=>$total_keseluruhan_des_wanita_umur_35_44,


                                    //---------------------------------45-54

                                    'total_keseluruhan_jan_all_umur_45_54'=>$total_keseluruhan_jan_all_umur_45_54,
                                    'total_keseluruhan_feb_all_umur_45_54'=>$total_keseluruhan_feb_all_umur_45_54,
                                    'total_keseluruhan_mar_all_umur_45_54'=>$total_keseluruhan_mar_all_umur_45_54,
                                    'total_keseluruhan_apr_all_umur_45_54'=>$total_keseluruhan_apr_all_umur_45_54,
                                    'total_keseluruhan_mei_all_umur_45_54'=>$total_keseluruhan_mei_all_umur_45_54,
                                    'total_keseluruhan_jun_all_umur_45_54'=>$total_keseluruhan_jun_all_umur_45_54,
                                    'total_keseluruhan_jul_all_umur_45_54'=>$total_keseluruhan_jul_all_umur_45_54,
                                    'total_keseluruhan_agu_all_umur_45_54'=>$total_keseluruhan_agu_all_umur_45_54,
                                    'total_keseluruhan_sep_all_umur_45_54'=>$total_keseluruhan_sep_all_umur_45_54,
                                    'total_keseluruhan_okt_all_umur_45_54'=>$total_keseluruhan_okt_all_umur_45_54,
                                    'total_keseluruhan_nov_all_umur_45_54'=>$total_keseluruhan_nov_all_umur_45_54,
                                    'total_keseluruhan_des_all_umur_45_54'=>$total_keseluruhan_des_all_umur_45_54,


                                    'total_keseluruhan_jan_pria_umur_45_54'=>$total_keseluruhan_jan_pria_umur_45_54,
                                    'total_keseluruhan_feb_pria_umur_45_54'=>$total_keseluruhan_feb_pria_umur_45_54,
                                    'total_keseluruhan_mar_pria_umur_45_54'=>$total_keseluruhan_mar_pria_umur_45_54,
                                    'total_keseluruhan_apr_pria_umur_45_54'=>$total_keseluruhan_apr_pria_umur_45_54,
                                    'total_keseluruhan_mei_pria_umur_45_54'=>$total_keseluruhan_mei_pria_umur_45_54,
                                    'total_keseluruhan_jun_pria_umur_45_54'=>$total_keseluruhan_jun_pria_umur_45_54,
                                    'total_keseluruhan_jul_pria_umur_45_54'=>$total_keseluruhan_jul_pria_umur_45_54,
                                    'total_keseluruhan_agu_pria_umur_45_54'=>$total_keseluruhan_agu_pria_umur_45_54,
                                    'total_keseluruhan_sep_pria_umur_45_54'=>$total_keseluruhan_sep_pria_umur_45_54,
                                    'total_keseluruhan_okt_pria_umur_45_54'=>$total_keseluruhan_okt_pria_umur_45_54,
                                    'total_keseluruhan_nov_pria_umur_45_54'=>$total_keseluruhan_nov_pria_umur_45_54,
                                    'total_keseluruhan_des_pria_umur_45_54'=>$total_keseluruhan_des_pria_umur_45_54,


                                    'total_keseluruhan_jan_wanita_umur_45_54'=>$total_keseluruhan_jan_wanita_umur_45_54,
                                    'total_keseluruhan_feb_wanita_umur_45_54'=>$total_keseluruhan_feb_wanita_umur_45_54,
                                    'total_keseluruhan_mar_wanita_umur_45_54'=>$total_keseluruhan_mar_wanita_umur_45_54,
                                    'total_keseluruhan_apr_wanita_umur_45_54'=>$total_keseluruhan_apr_wanita_umur_45_54,
                                    'total_keseluruhan_mei_wanita_umur_45_54'=>$total_keseluruhan_mei_wanita_umur_45_54,
                                    'total_keseluruhan_jun_wanita_umur_45_54'=>$total_keseluruhan_jun_wanita_umur_45_54,
                                    'total_keseluruhan_jul_wanita_umur_45_54'=>$total_keseluruhan_jul_wanita_umur_45_54,
                                    'total_keseluruhan_agu_wanita_umur_45_54'=>$total_keseluruhan_agu_wanita_umur_45_54,
                                    'total_keseluruhan_sep_wanita_umur_45_54'=>$total_keseluruhan_sep_wanita_umur_45_54,
                                    'total_keseluruhan_okt_wanita_umur_45_54'=>$total_keseluruhan_okt_wanita_umur_45_54,
                                    'total_keseluruhan_nov_wanita_umur_45_54'=>$total_keseluruhan_nov_wanita_umur_45_54,
                                    'total_keseluruhan_des_wanita_umur_45_54'=>$total_keseluruhan_des_wanita_umur_45_54,

                                    //---------------------------------55-64

                                    'total_keseluruhan_jan_all_umur_55_64'=>$total_keseluruhan_jan_all_umur_55_64,
                                    'total_keseluruhan_feb_all_umur_55_64'=>$total_keseluruhan_feb_all_umur_55_64,
                                    'total_keseluruhan_mar_all_umur_55_64'=>$total_keseluruhan_mar_all_umur_55_64,
                                    'total_keseluruhan_apr_all_umur_55_64'=>$total_keseluruhan_apr_all_umur_55_64,
                                    'total_keseluruhan_mei_all_umur_55_64'=>$total_keseluruhan_mei_all_umur_55_64,
                                    'total_keseluruhan_jun_all_umur_55_64'=>$total_keseluruhan_jun_all_umur_55_64,
                                    'total_keseluruhan_jul_all_umur_55_64'=>$total_keseluruhan_jul_all_umur_55_64,
                                    'total_keseluruhan_agu_all_umur_55_64'=>$total_keseluruhan_agu_all_umur_55_64,
                                    'total_keseluruhan_sep_all_umur_55_64'=>$total_keseluruhan_sep_all_umur_55_64,
                                    'total_keseluruhan_okt_all_umur_55_64'=>$total_keseluruhan_okt_all_umur_55_64,
                                    'total_keseluruhan_nov_all_umur_55_64'=>$total_keseluruhan_nov_all_umur_55_64,
                                    'total_keseluruhan_des_all_umur_55_64'=>$total_keseluruhan_des_all_umur_55_64,


                                    'total_keseluruhan_jan_pria_umur_55_64'=>$total_keseluruhan_jan_pria_umur_55_64,
                                    'total_keseluruhan_feb_pria_umur_55_64'=>$total_keseluruhan_feb_pria_umur_55_64,
                                    'total_keseluruhan_mar_pria_umur_55_64'=>$total_keseluruhan_mar_pria_umur_55_64,
                                    'total_keseluruhan_apr_pria_umur_55_64'=>$total_keseluruhan_apr_pria_umur_55_64,
                                    'total_keseluruhan_mei_pria_umur_55_64'=>$total_keseluruhan_mei_pria_umur_55_64,
                                    'total_keseluruhan_jun_pria_umur_55_64'=>$total_keseluruhan_jun_pria_umur_55_64,
                                    'total_keseluruhan_jul_pria_umur_55_64'=>$total_keseluruhan_jul_pria_umur_55_64,
                                    'total_keseluruhan_agu_pria_umur_55_64'=>$total_keseluruhan_agu_pria_umur_55_64,
                                    'total_keseluruhan_sep_pria_umur_55_64'=>$total_keseluruhan_sep_pria_umur_55_64,
                                    'total_keseluruhan_okt_pria_umur_55_64'=>$total_keseluruhan_okt_pria_umur_55_64,
                                    'total_keseluruhan_nov_pria_umur_55_64'=>$total_keseluruhan_nov_pria_umur_55_64,
                                    'total_keseluruhan_des_pria_umur_55_64'=>$total_keseluruhan_des_pria_umur_55_64,


                                    'total_keseluruhan_jan_wanita_umur_55_64'=>$total_keseluruhan_jan_wanita_umur_55_64,
                                    'total_keseluruhan_feb_wanita_umur_55_64'=>$total_keseluruhan_feb_wanita_umur_55_64,
                                    'total_keseluruhan_mar_wanita_umur_55_64'=>$total_keseluruhan_mar_wanita_umur_55_64,
                                    'total_keseluruhan_apr_wanita_umur_55_64'=>$total_keseluruhan_apr_wanita_umur_55_64,
                                    'total_keseluruhan_mei_wanita_umur_55_64'=>$total_keseluruhan_mei_wanita_umur_55_64,
                                    'total_keseluruhan_jun_wanita_umur_55_64'=>$total_keseluruhan_jun_wanita_umur_55_64,
                                    'total_keseluruhan_jul_wanita_umur_55_64'=>$total_keseluruhan_jul_wanita_umur_55_64,
                                    'total_keseluruhan_agu_wanita_umur_55_64'=>$total_keseluruhan_agu_wanita_umur_55_64,
                                    'total_keseluruhan_sep_wanita_umur_55_64'=>$total_keseluruhan_sep_wanita_umur_55_64,
                                    'total_keseluruhan_okt_wanita_umur_55_64'=>$total_keseluruhan_okt_wanita_umur_55_64,
                                    'total_keseluruhan_nov_wanita_umur_55_64'=>$total_keseluruhan_nov_wanita_umur_55_64,
                                    'total_keseluruhan_des_wanita_umur_55_64'=>$total_keseluruhan_des_wanita_umur_55_64,

                                    //--------------------------------->65

                                    'total_keseluruhan_jan_all_umur_65'=>$total_keseluruhan_jan_all_umur_65,
                                    'total_keseluruhan_feb_all_umur_65'=>$total_keseluruhan_feb_all_umur_65,
                                    'total_keseluruhan_mar_all_umur_65'=>$total_keseluruhan_mar_all_umur_65,
                                    'total_keseluruhan_apr_all_umur_65'=>$total_keseluruhan_apr_all_umur_65,
                                    'total_keseluruhan_mei_all_umur_65'=>$total_keseluruhan_mei_all_umur_65,
                                    'total_keseluruhan_jun_all_umur_65'=>$total_keseluruhan_jun_all_umur_65,
                                    'total_keseluruhan_jul_all_umur_65'=>$total_keseluruhan_jul_all_umur_65,
                                    'total_keseluruhan_agu_all_umur_65'=>$total_keseluruhan_agu_all_umur_65,
                                    'total_keseluruhan_sep_all_umur_65'=>$total_keseluruhan_sep_all_umur_65,
                                    'total_keseluruhan_okt_all_umur_65'=>$total_keseluruhan_okt_all_umur_65,
                                    'total_keseluruhan_nov_all_umur_65'=>$total_keseluruhan_nov_all_umur_65,
                                    'total_keseluruhan_des_all_umur_65'=>$total_keseluruhan_des_all_umur_65,


                                    'total_keseluruhan_jan_pria_umur_65'=>$total_keseluruhan_jan_pria_umur_65,
                                    'total_keseluruhan_feb_pria_umur_65'=>$total_keseluruhan_feb_pria_umur_65,
                                    'total_keseluruhan_mar_pria_umur_65'=>$total_keseluruhan_mar_pria_umur_65,
                                    'total_keseluruhan_apr_pria_umur_65'=>$total_keseluruhan_apr_pria_umur_65,
                                    'total_keseluruhan_mei_pria_umur_65'=>$total_keseluruhan_mei_pria_umur_65,
                                    'total_keseluruhan_jun_pria_umur_65'=>$total_keseluruhan_jun_pria_umur_65,
                                    'total_keseluruhan_jul_pria_umur_65'=>$total_keseluruhan_jul_pria_umur_65,
                                    'total_keseluruhan_agu_pria_umur_65'=>$total_keseluruhan_agu_pria_umur_65,
                                    'total_keseluruhan_sep_pria_umur_65'=>$total_keseluruhan_sep_pria_umur_65,
                                    'total_keseluruhan_okt_pria_umur_65'=>$total_keseluruhan_okt_pria_umur_65,
                                    'total_keseluruhan_nov_pria_umur_65'=>$total_keseluruhan_nov_pria_umur_65,
                                    'total_keseluruhan_des_pria_umur_65'=>$total_keseluruhan_des_pria_umur_65,


                                    'total_keseluruhan_jan_wanita_umur_65'=>$total_keseluruhan_jan_wanita_umur_65,
                                    'total_keseluruhan_feb_wanita_umur_65'=>$total_keseluruhan_feb_wanita_umur_65,
                                    'total_keseluruhan_mar_wanita_umur_65'=>$total_keseluruhan_mar_wanita_umur_65,
                                    'total_keseluruhan_apr_wanita_umur_65'=>$total_keseluruhan_apr_wanita_umur_65,
                                    'total_keseluruhan_mei_wanita_umur_65'=>$total_keseluruhan_mei_wanita_umur_65,
                                    'total_keseluruhan_jun_wanita_umur_65'=>$total_keseluruhan_jun_wanita_umur_65,
                                    'total_keseluruhan_jul_wanita_umur_65'=>$total_keseluruhan_jul_wanita_umur_65,
                                    'total_keseluruhan_agu_wanita_umur_65'=>$total_keseluruhan_agu_wanita_umur_65,
                                    'total_keseluruhan_sep_wanita_umur_65'=>$total_keseluruhan_sep_wanita_umur_65,
                                    'total_keseluruhan_okt_wanita_umur_65'=>$total_keseluruhan_okt_wanita_umur_65,
                                    'total_keseluruhan_nov_wanita_umur_65'=>$total_keseluruhan_nov_wanita_umur_65,
                                    'total_keseluruhan_des_wanita_umur_65'=>$total_keseluruhan_des_wanita_umur_65,


                                    //=====================================

                                    'total_keseluruhan_jan_jk_pria'=>$total_keseluruhan_jan_jk_pria,
                                    'total_keseluruhan_feb_jk_pria'=>$total_keseluruhan_feb_jk_pria,
                                    'total_keseluruhan_mar_jk_pria'=>$total_keseluruhan_mar_jk_pria,
                                    'total_keseluruhan_apr_jk_pria'=>$total_keseluruhan_apr_jk_pria,
                                    'total_keseluruhan_mei_jk_pria'=>$total_keseluruhan_mei_jk_pria,
                                    'total_keseluruhan_jun_jk_pria'=>$total_keseluruhan_jun_jk_pria,
                                    'total_keseluruhan_jul_jk_pria'=>$total_keseluruhan_jul_jk_pria,

                                    'total_keseluruhan_agu_jk_pria'=>$total_keseluruhan_agu_jk_pria,
                                    'total_keseluruhan_sep_jk_pria'=>$total_keseluruhan_sep_jk_pria,
                                    'total_keseluruhan_okt_jk_pria'=>$total_keseluruhan_okt_jk_pria,
                                    'total_keseluruhan_nov_jk_pria'=>$total_keseluruhan_nov_jk_pria,
                                    'total_keseluruhan_des_jk_pria'=>$total_keseluruhan_des_jk_pria,

                                    'total_keseluruhan_jan_jk_wanita'=>$total_keseluruhan_jan_jk_wanita,
                                    'total_keseluruhan_feb_jk_wanita'=>$total_keseluruhan_feb_jk_wanita,
                                    'total_keseluruhan_mar_jk_wanita'=>$total_keseluruhan_mar_jk_wanita,
                                    'total_keseluruhan_apr_jk_wanita'=>$total_keseluruhan_apr_jk_wanita,
                                    'total_keseluruhan_mei_jk_wanita'=>$total_keseluruhan_mei_jk_wanita,
                                    'total_keseluruhan_jun_jk_wanita'=>$total_keseluruhan_jun_jk_wanita,
                                    'total_keseluruhan_jul_jk_wanita'=>$total_keseluruhan_jul_jk_wanita,

                                    'total_keseluruhan_agu_jk_wanita'=>$total_keseluruhan_agu_jk_wanita,
                                    'total_keseluruhan_sep_jk_wanita'=>$total_keseluruhan_sep_jk_wanita,
                                    'total_keseluruhan_okt_jk_wanita'=>$total_keseluruhan_okt_jk_wanita,
                                    'total_keseluruhan_nov_jk_wanita'=>$total_keseluruhan_nov_jk_wanita,
                                    'total_keseluruhan_des_jk_wanita'=>$total_keseluruhan_des_jk_wanita,

                                    'total_keseluruhan_jan'=>$total_keseluruhan_jan,
                                    'total_keseluruhan_feb'=>$total_keseluruhan_feb,
                                    'total_keseluruhan_mar'=>$total_keseluruhan_mar,
                                    'total_keseluruhan_apr'=>$total_keseluruhan_apr,
                                    'total_keseluruhan_mei'=>$total_keseluruhan_mei,
                                    'total_keseluruhan_jun'=>$total_keseluruhan_jun,
                                    'total_keseluruhan_jul'=>$total_keseluruhan_jul,
                                    'total_keseluruhan_agu'=>$total_keseluruhan_agu,
                                    'total_keseluruhan_sep'=>$total_keseluruhan_sep,
                                    'total_keseluruhan_okt'=>$total_keseluruhan_okt,
                                    'total_keseluruhan_nov'=>$total_keseluruhan_nov,
                                    'total_keseluruhan_des'=>$total_keseluruhan_des,

                                    'total_baru_jan'=>$total_baru_jan,
                                    'total_proses_jan'=>$total_proses_jan,
                                    'total_closing_jan'=>$total_closing_jan,
                                    'total_batal_jan'=>$total_batal_jan,
                                    'total_reserve_jan'=>$total_reserve_jan,

                                    'total_baru_feb'=>$total_baru_feb,
                                    'total_proses_feb'=>$total_proses_feb,
                                    'total_closing_feb'=>$total_closing_feb,
                                    'total_batal_feb'=>$total_batal_feb,
                                    'total_reserve_feb'=>$total_reserve_feb,

                                    'total_baru_mar'=>$total_baru_mar,
                                    'total_proses_mar'=>$total_proses_mar,
                                    'total_closing_mar'=>$total_closing_mar,
                                    'total_batal_mar'=>$total_batal_mar,
                                    'total_reserve_mar'=>$total_reserve_mar,

                                    'total_baru_apr'=>$total_baru_apr,
                                    'total_proses_apr'=>$total_proses_apr,
                                    'total_closing_apr'=>$total_closing_apr,
                                    'total_batal_apr'=>$total_batal_apr,
                                    'total_reserve_apr'=>$total_reserve_apr,

                                    'total_baru_mei'=>$total_baru_mei,
                                    'total_proses_mei'=>$total_proses_mei,
                                    'total_closing_mei'=>$total_closing_mei,
                                    'total_batal_mei'=>$total_batal_mei,
                                    'total_reserve_mei'=>$total_reserve_mei,

                                    'total_baru_jun'=>$total_baru_jun,
                                    'total_proses_jun'=>$total_proses_jun,
                                    'total_closing_jun'=>$total_closing_jun,
                                    'total_batal_jun'=>$total_batal_jun,
                                    'total_reserve_jun'=>$total_reserve_jun,

                                    'total_baru_jul'=>$total_baru_jul,
                                    'total_proses_jul'=>$total_proses_jul,
                                    'total_closing_jul'=>$total_closing_jul,
                                    'total_batal_jul'=>$total_batal_jul,
                                    'total_reserve_jul'=>$total_reserve_jul,

                                    'total_baru_agu'=>$total_baru_agu,
                                    'total_proses_agu'=>$total_proses_agu,
                                    'total_closing_agu'=>$total_closing_agu,
                                    'total_batal_agu'=>$total_batal_agu,
                                    'total_reserve_agu'=>$total_reserve_agu,

                                    'total_baru_sep'=>$total_baru_sep,
                                    'total_proses_sep'=>$total_proses_sep,
                                    'total_closing_sep'=>$total_closing_sep,
                                    'total_batal_sep'=>$total_batal_sep,
                                    'total_reserve_sep'=>$total_reserve_sep,

                                    'total_baru_okt'=>$total_baru_okt,
                                    'total_proses_okt'=>$total_proses_okt,
                                    'total_closing_okt'=>$total_closing_okt,
                                    'total_batal_okt'=>$total_batal_okt,
                                    'total_reserve_okt'=>$total_reserve_okt,

                                    'total_baru_nov'=>$total_baru_nov,
                                    'total_proses_nov'=>$total_proses_nov,
                                    'total_closing_nov'=>$total_closing_nov,
                                    'total_batal_nov'=>$total_batal_nov,
                                    'total_reserve_nov'=>$total_reserve_nov,

                                    'total_baru_des'=>$total_baru_des,
                                    'total_proses_des'=>$total_proses_des,
                                    'total_closing_des'=>$total_closing_des,
                                    'total_batal_des'=>$total_batal_des,
                                    'total_reserve_des'=>$total_reserve_des,
]);

   
}

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $today = date('Y-m-d');

        $cekdata = Tamu::where('hp','=',$request->hp)->count("id_tamu");

        if($cekdata > 1){
            if($level == 'sales'){
                return redirect('/home')->with('warning','Data sudah ada di database, anda tidak bisa melakukan input ganda, silahkan masukan data tamu yang lain yaa..');
            }else{
                return redirect()->back()->with('warning','Data sudah ada di database, anda tidak bisa melakukan input ganda, silahkan masukan data tamu yang lain yaa..');
            }
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
    
    
            $level = \Auth::user()->level;
            if($level == 'sales'){
                return redirect('/home')->with('success','Data berhasil disimpan');
            }else{
                return redirect()->back()->with('success','Data berhasil disimpan');
            }
        }
        

    }

    public function store_history(Request $request)
    {        
        $today = date('Y-m-d');

        $tabel = new Tamuhistory;
        $tabel->status_keterangan = $request->status;
        $tabel->keterangan = $request->status_keterangan;
        $tabel->keterangan_lain = $request->keterangan_lain;
        $tabel->id_tamu = $request->id_tamu;
        $tabel->tgl = $today;

        $tabel->save();

        $tabel1 = Tamu::find($request->id_tamu);
        $tabel1->status = $request->status;
        $tabel1->keterangan_status = $request->status_keterangan;
        $tabel1->save();
        
        return redirect()->back()->with('success','Data berhasil disimpan');

    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tamu  $agama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tabel = Tamu::find($id);

        $tabel->nama = $request->nama;
        $tabel->hp = $request->hp;
        $tabel->email = $request->email;
        $tabel->alamat_domisili = $request->alamat;
        $tabel->sumber = $request->sumber;
        $tabel->sumberlain = $request->sumberlain;
        $tabel->referensi = $request->referensi;
        $tabel->sales = $request->sales;

        $sales_senior = User::where('id','=',$request->sales)->first();
        $tabel->id_sales_senior = $sales_senior->id_sales_senior;

        $tabel->tgl_lahir = $request->tgl_lahir;
        $tabel->jk = $request->jk;
        $tabel->status = $request->status;
        
        $awal  = date_create($request->tgl_lahir);
        $akhir = date_create(); // waktu sekarang
        $diff  = date_diff( $awal, $akhir );

        
        $tabel->umur = $diff->y;
    
        $tabel->save();

        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    public function update_status(Request $request, $id)
    {
        $tabel = Tamu::find($id);

        $tabel->status = $request->status;
        $tabel->keterangan_status = $request->status_keterangan;
        $tabel->save();

        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    public function update_history(Request $request, $id)
    {
        $tabel = Tamuhistory::find($id);

        $tabel->status_keterangan = $request->status;
        $tabel->keterangan = $request->status_keterangan;
        $tabel->keterangan_lain = $request->keterangan_lain;
        $tabel->save();

        return redirect()->back()->with('success','Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tamu  $agama
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tabel = Tamu::find($id);
        $tabel->delete();
        return redirect()->back()->with('success','Data berhasil dihapus');
    }
}
