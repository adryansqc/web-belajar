<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi; // <- ini yang penting

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::paginate(6);
        return view('fe.pages.materi.materi', compact('materi'));
    }

    public function show($id)
    {
        $materi = Materi::findOrFail($id);
        return view('fe.pages.materi.materi_detail', compact('materi'));
    }
}
