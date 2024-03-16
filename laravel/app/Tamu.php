<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $primaryKey = 'id_tamu';
    protected $table = 'tabel_tamu';

    protected $fillable = [
        'nama', 'hp', 'email','alamat_domisili','tgl','sumber','sales','status','keterangan_status','bulan','tahun','sumberlain','referensi','id_sales_senior','tgl_lahir','umur','jk',
    ];
    

    public function nama_sale()
    {
    	return $this->belongsTo('App\User','sales');
    }
    public function keter()
    {
    	return $this->belongsTo('App\Tamu_keterangan_prosfek','keterangan_status');
    }

    public function sales_senior()
    {
    	return $this->belongsTo('App\User','id_sales_senior');
    }
}
