<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::orderBy('id','asc')->get();
        $data_sales_senior = User::where('level','=','sales_senior')->orderBy('id','asc')->get();
        return view('user.index',['data_user' => $data,'data_sales_senior' => $data_sales_senior]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        

        $tabel = new User;
        $tabel->name = $request->nama;
        $tabel->email = $request->email;
        $tabel->password = Hash::make(12345);
        $tabel->level = $request->level;
        $tabel->status_user = $request->status_user;
        $tabel->id_sales_senior = $request->id_sales_senior;


        $tabel->save();

        return redirect('/userlogin');

    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $agama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tabel = User::find($id);

        $tabel->name = $request->nama;
        $tabel->email = $request->email;
            if (!empty($request->password)) {
                $tabel->password = Hash::make($request->password);
            }
        $tabel->level = $request->level;
        $tabel->status_user = $request->status_user;
        $tabel->id_sales_senior = $request->id_sales_senior;
        $tabel->save();

        return redirect('/userlogin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agama  $agama
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tabel = User::find($id);
        $tabel->delete();
        return redirect('/userlogin');
    }
}
