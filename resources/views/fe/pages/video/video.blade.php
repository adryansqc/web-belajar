@extends('fe.layouts.app')

@section('title')
    Video
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Materi Kelas 1 SD - Matematika</div>
            <h5>Video Pembelajaran</h5>
        </div>
    </div>
</section>

<section id="materi" class="py-5">
    <div class="container">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Video Pembelajaran </h2>
        </div>

        <div class="row py-5">
            @forelse ($video as $item)
                <div class="col-lg-4">
                    <div class="card border-0">
                        @php
                            $videoId = '';

                            if (str_contains($item->url, 'youtube.com/watch?v=')) {
                                parse_str(parse_url($item->url, PHP_URL_QUERY), $params);
                                $videoId = $params['v'] ?? '';
                            } elseif (str_contains($item->url, 'youtu.be/')) {
                                $videoId = Str::after($item->url, 'youtu.be/');
                                $videoId = Str::before($videoId, '?');
                            }
                            $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : $item->url;
                        @endphp

                        @if($videoId)
                            <div class="embed-responsive embed-responsive-16by9 mb-3" style="border-radius:12px; overflow: hidden;">
                                <iframe class="embed-responsive-item" src="{{ $embedUrl }}" allowfullscreen frameborder="0"></iframe>
                            </div>
                        @else
                            <img src="{{ asset('assets/images/il-Bilangan.jpg') }}" class="img-fluid mb-3"
                                style="border-radius:12px" alt="{{ $item->judul }}">
                        @endif
                        <div class="konten-materi">
                            <p class="mb-3 text-secondary">{{ $item->created_at->format('d/m/Y') }}</p>
                            <h4 class="fw-bold mb-3">{{ $item->judul }}</h4>
                            <a href="{{ $item->url }}" target="_blank" class="text-decoration-none text-danger">Lihat Video</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead text-muted">Video belum tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $video->links() }}
        </div>
    </div>
</section>
@endsection