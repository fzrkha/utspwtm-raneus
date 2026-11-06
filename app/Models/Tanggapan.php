<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tanggapan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'tanggapan';
    public $timestamps = false;

    protected $casts = [
        'tgl_tanggapan' => 'date',
    ];

    public function pelanggaran(): BelongsTo
    {
        return $this->belongsTo(Pelanggaran::class, 'id_plg', 'id_plg');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'nip', 'nip');
    }
}
