<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiLatihan extends Model
{
    protected $fillable = [
        'nama_siswa',
        'kelas',
        'latihan_id',
        'waktu_mulai',
        'waktu_selesai',
        'total_soal',
        'total_benar',
        'total_poin'
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function latihan()
    {
        return $this->belongsTo(Latihan::class);
    }

    public function jawabanSiswas()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}
