@extends('fe.layouts.app')

@section('title')
    Hasil Latihan - {{ $sesiLatihan->latihan->nama }}
@endsection

@push('style')
<style>
    .result-card {
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0 auto;
    }
    .high-score {
        background-color: #28a745;
        color: white;
    }
    .medium-score {
        background-color: #ffc107;
        color: white;
    }
    .low-score {
        background-color: #dc3545;
        color: white;
    }
    .answer-item {
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 8px;
    }
    .correct-answer {
        background-color: rgba(40, 167, 69, 0.1);
        border-left: 4px solid #28a745;
    }
    .wrong-answer {
        background-color: rgba(220, 53, 69, 0.1);
        border-left: 4px solid #dc3545;
    }
</style>
@endpush

@section('content')
<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Hasil Latihan</div>
            <h5>{{ $sesiLatihan->latihan->nama }}</h5>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card result-card mb-4">
                <div class="card-body text-center">
                    <h4 class="mb-4">Ringkasan Hasil</h4>
                    
                    @php
                        $percentage = ($sesiLatihan->total_benar / $sesiLatihan->total_soal) * 100;
                        $scoreClass = $percentage >= 80 ? 'high-score' : ($percentage >= 60 ? 'medium-score' : 'low-score');
                    @endphp
                    
                    <div class="score-circle {{ $scoreClass }} mb-4">
                        {{ number_format($percentage, 0) }}%
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h5>Total Soal</h5>
                            <p class="h3">{{ $sesiLatihan->total_soal }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Jawaban Benar</h5>
                            <p class="h3">{{ $sesiLatihan->total_benar }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Total Poin</h5>
                            <p class="h3">{{ $sesiLatihan->total_poin }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p><strong>Nama:</strong> {{ $sesiLatihan->nama_siswa }}</p>
                        <p><strong>Kelas:</strong> {{ $sesiLatihan->kelas }}</p>
                        <p><strong>Waktu Mulai:</strong> {{ $sesiLatihan->waktu_mulai->format('d/m/Y H:i') }}</p>
                        <p><strong>Waktu Selesai:</strong> {{ $sesiLatihan->waktu_selesai->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="card result-card">
                <div class="card-body">
                    <h4 class="mb-4">Detail Jawaban</h4>
                    
                    @foreach($sesiLatihan->jawabanSiswas as $jawaban)
                    <div class="answer-item {{ $jawaban->benar ? 'correct-answer' : 'wrong-answer' }}">
                        <h5>Soal {{ $loop->iteration }}</h5>
                        <p>{!! $jawaban->soal->pertanyaan !!}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Jawaban Anda:</strong> {{ $jawaban->jawaban_pilihan }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Jawaban Benar:</strong> {{ $jawaban->soal->jawaban_benar }}</p>
                            </div>
                        </div>
                        <p><small>Durasi: {{ $jawaban->durasi_pengerjaan }} detik | Poin: {{ $jawaban->poin }}</small></p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('fe.latihan') }}" class="btn btn-primary">Kembali ke Daftar Latihan</a>
            </div>
        </div>
    </div>
</div>
@endsection