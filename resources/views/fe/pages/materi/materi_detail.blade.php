@extends('fe.layouts.app')

@section('title')
    {{ $materi->judul }}
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Materi Kelas 1 SD - Matematika</div>
            <h5>{{ $materi->judul }}</h5>
        </div>
    </div>
</section>

<section id="materi-detail" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-sm mb-4">
                    <img src="{{ asset('storage/' . $materi->cover) }}" class="card-img-top" alt="{{ $materi->judul }}" style="max-height: 400px; object-fit: cover;">
                    <div class="card-body">
                        <h1 class="card-title fw-bold mb-3">{{ $materi->judul }}</h1>
                        <p class="card-text text-muted small mb-4">Diterbitkan pada: {{ $materi->created_at->format('d F Y') }}</p>
                        <div class="card-text mb-4">
                            {!! $materi->deskripsi !!}
                        </div>

                        <h3 class="fw-bold mb-3">File Materi (PDF)</h3>
                        <div class="embed-responsive embed-responsive-16by9" style="height: 800px;">
                            <embed src="{{ asset('storage/' . $materi->pdf) }}" type="application/pdf" width="100%" height="100%" />
                        </div>
                        <p class="text-center mt-3">
                            <a href="{{ asset('storage/' . $materi->pdf) }}" target="_blank" class="btn btn-primary">Unduh PDF</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection