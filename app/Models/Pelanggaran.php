<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pelanggaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pelanggaran';
    protected $timestamps = false;
    
    protected $casts = [
        'tgl_pel' => 'date',
    ];

    public function murid(): BelongsTo
    {
        return $this->belongsTo(Murid::class, 'nis', 'nis');
    }

    public function tanggapan(): HasOne
    {
        return $this->hasOne(Tanggapan::class, 'id_plg', 'id_plg');
    }
}
