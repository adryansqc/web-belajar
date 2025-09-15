<?php

namespace App\Http\Controllers;

use App\Models\JawabanSiswa;
use App\Models\Latihan;
use App\Models\Materi;
use App\Models\SesiLatihan;
use App\Models\Soal;
use App\Models\Video;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $materi = Materi::latest()->take(3)->get();
        $video = Video::latest()->take(3)->get();
        return view('fe.pages.home', compact('materi', 'video'));
    }

    public function video()
    {
        $video = Video::latest()->paginate(6);
        return view('fe.pages.video.video', compact('video'));
    }

    public function latihan()
    {
        $latihan = Latihan::latest()->paginate(6);
        return view('fe.pages.latihan.latihan', compact('latihan'));
    }

    public function mulaiLatihan(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'latihan_id' => 'required|exists:latihans,id',
        ]);

        $latihan = Latihan::with('soals')->findOrFail($request->latihan_id);

        $sesiLatihan = SesiLatihan::create([
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'latihan_id' => $latihan->id,
            'waktu_mulai' => now(),
            'total_soal' => $latihan->soals->count(),
        ]);

        return view('fe.pages.latihan.mulai', [
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'latihan' => $latihan,
            'soals' => $latihan->soals,
            'sesi_latihan_id' => $sesiLatihan->id,
        ]);
    }

    public function simpanJawaban(Request $request)
    {
        $request->validate([
            'sesi_latihan_id' => 'required|exists:sesi_latihans,id',
            'soal_id' => 'required|exists:soals,id',
            'jawaban_pilihan' => 'required|in:A,B,C,D',
            'durasi_pengerjaan' => 'required|integer',
        ]);

        $soal = Soal::find($request->soal_id);
        $benar = $request->jawaban_pilihan === $soal->jawaban_benar;

        $poin = $benar ? $this->hitungPoin($request->durasi_pengerjaan, $soal->waktu_per_soal) : 0;

        // Cari jawaban yang sudah ada untuk soal ini dalam sesi latihan ini
        $jawaban = JawabanSiswa::where('sesi_latihan_id', $request->sesi_latihan_id)
            ->where('soal_id', $request->soal_id)
            ->first();

        if ($jawaban) {
            // Jika jawaban sudah ada, perbarui
            $jawaban->update([
                'jawaban_pilihan' => $request->jawaban_pilihan,
                'benar' => $benar,
                'waktu_dijawab' => now(),
                'durasi_pengerjaan' => $request->durasi_pengerjaan,
                'poin' => $poin,
            ]);
        } else {
            // Jika jawaban belum ada, buat yang baru
            $jawaban = JawabanSiswa::create([
                'sesi_latihan_id' => $request->sesi_latihan_id,
                'soal_id' => $request->soal_id,
                'jawaban_pilihan' => $request->jawaban_pilihan,
                'benar' => $benar,
                'waktu_dijawab' => now(),
                'durasi_pengerjaan' => $request->durasi_pengerjaan,
                'poin' => $poin,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'benar' => $benar,
            'poin' => $poin,
        ]);
    }

    private function hitungPoin($durasi, $waktuPerSoal)
    {
        // Contoh perhitungan poin:
        // - Jika menjawab dalam waktu <= 50% waktu: 100 poin
        // - Jika menjawab dalam waktu <= 75% waktu: 75 poin
        // - Jika menjawab dalam waktu <= 100% waktu: 50 poin
        // - Jika menjawab lebih dari waktu yang ditentukan: 25 poin

        if ($durasi <= $waktuPerSoal * 0.5) return 100;
        if ($durasi <= $waktuPerSoal * 0.75) return 75;
        if ($durasi <= $waktuPerSoal) return 50;
        return 25;
    }

    public function selesaiLatihan(Request $request)
    {
        try {
            $request->validate([
                'sesi_latihan_id' => 'required|exists:sesi_latihans,id',
            ]);

            $sesiLatihan = SesiLatihan::with('jawabanSiswas')->findOrFail($request->sesi_latihan_id);

            // Update sesi latihan
            $sesiLatihan->update([
                'waktu_selesai' => now(),
                'total_benar' => $sesiLatihan->jawabanSiswas->where('benar', true)->count(),
                'total_poin' => $sesiLatihan->jawabanSiswas->sum('poin'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Latihan berhasil diselesaikan',
                'redirect_url' => route('latihan.hasil', $sesiLatihan->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function hasilLatihan(SesiLatihan $sesiLatihan)
    {
        try {
            $sesiLatihan->load(['latihan', 'jawabanSiswas.soal']);
            return view('fe.pages.latihan.hasil', compact('sesiLatihan'));
        } catch (\Exception $e) {
            return redirect()->route('fe.latihan')
                ->with('error', 'Terjadi kesalahan saat memuat hasil latihan');
        }
    }

    public function nilai()
    {
        $latihan = Latihan::latest()->paginate(6);
        return view('fe.pages.nilai.nilai', compact('latihan'));
    }

    public function detailNilai(Latihan $latihan)
    {
        $sesiLatihans = SesiLatihan::where('latihan_id', $latihan->id)
            ->orderBy('total_poin', 'desc')
            ->paginate(10);
        return view('fe.pages.nilai.detail', compact('latihan', 'sesiLatihans'));
    }
}
