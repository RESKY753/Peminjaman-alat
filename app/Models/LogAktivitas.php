<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $guarded = ['id_log'];

    static function catat($aktifitas, $keterangan)
    {
        // Kalau $idUser diisi manual pakai itu, kalau kosong baru ambil dari Auth::user()
        $userId = $idUser ?? (Auth::check() ? Auth::user()->id_user : null);

        // Kalau tidak ada ID user sama sekali, batalkan insert biar gak error 1048
        if (!$userId) {
            return null;
        }

        return self::create([
            'id_user' => $userId,
            'aktifitas' => $aktifitas,
            'keterangan' => $keterangan,
        ]);
    }
    function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
