<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Import the Storage facade

class Materi extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // When a Materi record is being deleted, delete its associated files
        static::deleting(function ($materi) {
            if ($materi->cover) {
                Storage::disk('public')->delete($materi->cover);
            }
            if ($materi->pdf) {
                Storage::disk('public')->delete($materi->pdf);
            }
        });

        static::updating(function ($materi) {
            if ($materi->isDirty('cover') && $materi->getOriginal('cover')) {
                Storage::disk('public')->delete($materi->getOriginal('cover'));
            }

            if ($materi->isDirty('pdf') && $materi->getOriginal('pdf')) {
                Storage::disk('public')->delete($materi->getOriginal('pdf'));
            }
        });
    }
}
