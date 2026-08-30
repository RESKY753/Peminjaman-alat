<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'id_user';

    protected $table = 'users';

    protected $guarded = ['id_user'];

    protected $fillable = [
        'username',
        'email',
        'telp',
        'password',
        'role',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function logaktifitas()
    {
        return $this->hasMany(LogAktivitas::class, 'id_log', 'id_log');
    }
     function Histori(){
        return $this->hasMany(HistoriPinjaman::class,'id_histori','id_histori');
    }

}
