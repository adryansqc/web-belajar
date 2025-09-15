<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sesiLatihan()
    {
        return $this->belongsTo(SesiLatihan::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
