<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tamu_keterangan_prosfek extends Model
{
    protected $primaryKey = 'id_keterangan';
    protected $table = 'tabel_keterangan_prosfek';

    protected $fillable = [
        'status', 'keterangan',
    ];
    

}
