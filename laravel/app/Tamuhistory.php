<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tamuhistory extends Model
{
    protected $primaryKey = 'id_history_tamu';
    protected $table = 'tabel_tamu_history';

    protected $fillable = [
        'tgl', 'id_tamu','status_keterangan','keterangan','keterangan_lain',
    ];
    

    public function nama_tamu()
    {
    	return $this->belongsTo('App\Tamu','id_tamu');
    }

    public function keter()
    {
    	return $this->belongsTo('App\Tamu_keterangan_prosfek','keterangan');
    }

   
}
