@extends('fe.layouts.app')

@section('title')
    Materi
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Materi Kelas 1 SD - Matematika</div>
            <h5>Pilih materi untuk belajar</h5>
        </div>
    </div>
</section>

<section id="materi" class="py-5">
    <div class="container">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Materi Pembelajaran Dasar </h2>
        </div>

        <div class="row py-5">
            @forelse ($materi as $item)
                <div class="col-lg-4">
                    <div class="card border-0">
                        <img src="{{ $item->cover ? asset('storage/' . $item->cover) : asset('assets/images/il-Bilangan.jpg') }}" class="img-fluid mb-3"
                            style="border-radius:12px" alt="{{ $item->judul }}">
                        <div class="konten-materi">
                            <p class="mb-3 text-secondary">{{ $item->created_at->format('d/m/Y') }}</p>
                            <h4 class="fw-bold mb-3">{{ $item->judul }}</h4>
                            <p class="text-secondary">{{ Str::limit($item->deskripsi, 80) }}</p>
                            <a href="{{ route('materi.detail', ['id' => $item->id]) }}" class="text-decoration-none text-danger">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead text-muted">Materi belum tersedia.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $materi->links() }}
        </div>
    </div>
</section>
@endsection