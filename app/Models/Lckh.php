<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Lckh extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "lckh";
    protected $primaryKey = "id";
    protected $fillable = [
        'tanggal',
        'nama_lengkap',
        'kegiatan',
        'output',
        'keterangan',
        'nip',
    ];

    protected $casts = [
        'tanggal'    => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
