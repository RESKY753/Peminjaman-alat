<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = "peminjaman";
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;
    protected $guarded = ['id_peminjaman'];

    function alat(){
        return $this->belongsTo(Alat::class,'id_alat','id_alat');
    }

    function user(){
        return $this->belongsTo(User::class,'id_user','id_user');
    }

    function Histori(){
        return $this->hasOne(HistoriPinjaman::class,'id_peminjaman','id_peminjaman');
    }
}
