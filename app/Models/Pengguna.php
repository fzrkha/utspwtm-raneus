<?php

namespace App\Models;

use Illumanate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illumanate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'pengguna';
    protected $guarded = ['id'];
    protected $timestamps = false;

    protected $fillable = [
        'nip',
        'nama',
        'username',
        'password',
        'telp',
        'email',
        'level'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function tanggapan(): HasMany
    {
        return $this->hasMany(Tanggapan::class, 'nip', 'nip');
    }
}
