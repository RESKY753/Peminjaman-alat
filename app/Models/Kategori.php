<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $guarded = ['id_kategori'];

    public function alat(){
        return $this->belongsTo(Alat::class ,'id_alat','id_alat');
    }
}
