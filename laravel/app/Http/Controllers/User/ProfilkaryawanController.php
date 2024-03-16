<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\User;
use Illuminate\Support\Facades\Hash;


class ProfilkaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set('Asia/Jakarta');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = \Auth::user()->id;

        $personal = User::where('id','=',$id)->first();
       

        return view('profil.index',
                    [
                        'personal' => $personal
                    ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $jabatan
     * @return \Illuminate\Http\Response
     */
   
    public function update_password(Request $request, $id)
    {
        $tabel = User::find($id);

        if (!empty($request->password)) {
                $tabel->password = Hash::make($request->password);
                $tabel->save();
        }
        

        return redirect()->back()->with('success','Password Anda berhasil diubah');
    }

    

}
