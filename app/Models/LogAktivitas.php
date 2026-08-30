<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $guarded = ['id_log'];


    function user(){
        return $this->hasMany(User::class, 'id_user', 'id_user');
    }
}
