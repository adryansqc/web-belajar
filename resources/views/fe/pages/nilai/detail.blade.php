@extends('fe.layouts.app')

@section('title')
    Detail Nilai - {{ $latihan->nama }}
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Detail Nilai Latihan</div>
            <h5>{{ $latihan->nama }}</h5>
        </div>
    </div>
</section>

<section id="nilai-detail" class="py-5">
    <div class="container">
        <div class="header-nilai text-center mb-4">
            <h2 class="fw-bolds">Daftar Sesi {{ $latihan->nama }}</h2>
        </div>

        <div class="row">
            @forelse ($sesiLatihans as $index => $sesi)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sesi->nama_siswa }} Kelas {{ $sesi->kelas }}</h5>
                            <p class="card-text mb-1">
                                <small class="text-muted">Mulai: {{ $sesi->waktu_mulai->format('d M Y, H:i') }}</small>
                            </p>
                            <p class="card-text mb-3">
                                <small class="text-muted">Selesai: {{ $sesi->waktu_selesai ? $sesi->waktu_selesai->format('d M Y, H:i') : 'Belum Selesai' }}</small>
                            </p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Peringkat
                                    <span class="badge bg-warning text-dark rounded-pill">{{ $index + 1 }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Soal
                                    <span class="badge bg-primary rounded-pill">{{ $sesi->total_soal }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Jawaban Benar
                                    <span class="badge bg-success rounded-pill">{{ $sesi->total_benar }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Poin
                                    <span class="badge bg-info rounded-pill">{{ $sesi->total_poin }}</span>
                                </li>
                            </ul>
                            <a href="{{ route('latihan.hasil', $sesi->id) }}" class="btn btn-primary btn-sm">Lihat Detail Hasil</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead text-muted">Belum ada sesi latihan yang diselesaikan untuk latihan ini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $sesiLatihans->links() }}
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('fe.nilai') }}" class="btn btn-secondary">Kembali ke Daftar Latihan</a>
        </div>
    </div>
</section>

@endsection