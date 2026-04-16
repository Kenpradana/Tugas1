<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Poli;

   class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',       // <-- PASTIKAN INI ADA
        'email',
        'no_ktp',     // <-- PASTIKAN INI ADA
        'no_hp',      // <-- PASTIKAN INI ADA
        'alamat',     // <-- PASTIKAN INI ADA
        'password',
        'role',
        'id_poli',
        'password',

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

    public function poli()
        {
            return $this->belongsTo(Poli::class, 'id_poli', 'id');
        }

    public function jadwalPeriksa()
    {
        return $this->hasMany(JadwalPeriksa::class, 'dokter_id');
    }

    
}

