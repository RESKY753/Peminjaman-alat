<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = "alat";
    protected $primaryKey = 'id_alat';
    protected $guarded = ['id_alat'];

    function Kategori(){
        return $this->hasOne(Kategori::class, 'id_kategori','id_kategori');
    }
    function peminjaman(){
        return $this->hasOne(Peminjaman::class,'id_peminjaman','id_peminjaman');
    }
}
