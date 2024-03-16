<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/tamuwi', 'TamuwiController@index')->name('tamuwi');
Route::post('/buattamuwi', 'TamuwiController@store')->name('user.buattamuwi');



Route::group(['middleware' => ['auth','ceklevel:sales,sales_senior']], function(){
   
    Route::get('/tamu', 'User\TamuController@index')->name('user.tamu');
    Route::get('/buattamu', 'User\TamuController@create')->name('user.buattamu');
    Route::post('/tamu/simpan', 'User\TamuController@store')->name('user.tamu.simpan');
    Route::put('/tamu/ubahstatus/{id_tamu}', 'User\TamuController@update_status')->name('user.tamu.ubah.status');
    Route::get('/tamu/detail/{id_tamu}', 'User\TamuController@detail')->name('user.tamu.detail');
    Route::post('/historytamu/simpan', 'User\TamuController@store_history')->name('user.tamu.history.simpan');
    Route::put('/historytamu/ubah/{id}', 'User\TamuController@update_history')->name('user.tamu.history.ubah');

    Route::get('/getketerangan', 'User\TamuController@getKeterangan');
   
});

    Route::get('/profilkaryawan', 'User\ProfilkaryawanController@index')->name('user.profilkaryawan');
    Route::put('/profilkaryawan/ubah/{id}', 'User\ProfilkaryawanController@update')->name('user.profilkaryawan.ubah');
    Route::put('/password/ubah/{id}', 'User\ProfilkaryawanController@update_password')->name('user.password.ubah');

Route::group(['middleware' => ['auth','ceklevel:admin,manager']], function(){
    Route::put('/tamu/ubahstatustransaksi/{id_tamu}', 'User\TamuController@update_status')->name('user.tamu.ubahstatustransaksi.status');

    
    
    Route::get('/userlogin', 'Admin\UserController@index')->name('admin.user');
    Route::post('/userlogin/simpan', 'Admin\UserController@store')->name('admin.user.simpan');
    Route::put('/userlogin/ubah/{id}', 'Admin\UserController@update')->name('admin.user.ubah');
    Route::delete('/userlogin/hapus/{id}','Admin\UserController@destroy')->name('admin.user.hapus');
    //------
    Route::get('/mastertamu', 'User\TamuController@index')->name('admin.tamu');
    Route::get('/mastertamu/detail/{id_tamu}', 'User\TamuController@detail')->name('admin.tamu.detail');
    Route::post('/mastertamu/simpan', 'User\TamuController@store')->name('admin.tamu.simpan');
    Route::put('/mastertamu/ubah/{id_tamu}', 'User\TamuController@update')->name('admin.tamu.ubah');
    Route::delete('/mastertamu/hapus/{id_tamu}','User\TamuController@destroy')->name('admin.tamu.hapus');
    Route::get('/mastertamu/cari', 'User\TamuController@show_reporttamu')->name('admin.reporttamu.cari');
   
    //-------
    Route::post('/masterhistorytamu/simpan', 'Admin\HistorytamuController@store')->name('admin.historytamu.simpan');
    Route::put('/masterhistorytamu/ubah/{id_tamu}', 'Admin\HistorytamuController@update')->name('admin.historytamu.ubah');
    Route::delete('/masterhistorytamu/hapus/{id_tamu}','Admin\HistorytamuController@destroy')->name('admin.historytamu.hapus');
    //-------

    Route::get('/grafik_reporttamu', 'User\TamuController@grafik')->name('admin.grafik_reporttamu');
    Route::get('/grafik_reporttamu/cari', 'User\TamuController@show_grafik')->name('admin.grafik_reporttamu.cari');


    Route::get('/exportexcel_tamu', 'User\TamuController@exportexcel_tamu')->name('admin.exportexcel_tamu');
    Route::get('/exportexcel_sales', 'User\TamuController@exportexcel_sales')->name('admin.exportexcel_sales');
    Route::post('/importexcel_tamu', 'User\TamuController@importexcel_tamu')->name('admin.importexcel_tamu');
    
    //-------


    

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
