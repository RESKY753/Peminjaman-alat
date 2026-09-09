<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriPinjaman extends Model
{
    protected $table = "histori_pinjaman";
    protected $primaryKey = 'id_histori';
    public $timestamps = false;
    protected  $guarded = ['id_histori'];

    function user(){
        return $this->hasMany(User::class, 'id_user', 'id_user');
    }

    function peminjaman(){
        return $this->belongsTo(Peminjaman::class,'id_peminjaman', 'id_peminjaman');
    }
}
