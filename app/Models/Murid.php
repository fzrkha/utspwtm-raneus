<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'murid';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama',
        'kelas'
    ];

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'nis', 'nis');
    }
}
