@extends('fe.layouts.app')

@section('title')
    Beranda
@endsection

@section('content')
<section id="hero" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Selamat Datang <br> Di Website Belajar Matematika</div>
            <h5>Yuk, belajar matematika jadi seru dan menyenangkan!
                Di sini kamu bisa belajar angka, bentuk, operasi hitung, dan banyak lagi.</h5>
        </div>
    </div>
</section>

<section id="program" style="margin-top: -30px">
    <div class="container col-xxl-9">
        <div class="row">
            <div class="col-lg-3 col-md-6 col col mb-2">
                <div class="bg-white rounded-3 shadow p-3 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <p>Matematika <br>Itu Mudah</p>
                    </div>
                    <img src="{{ asset('assets/icon/ic-book.png') }}" height="55" width="55" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col col mb-2">
                <div class="bg-white rounded-3 shadow p-3 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <p>Asah Logika <br> Matematika</p>
                    </div>
                    <img src="{{ asset('assets/icon/ic-globe.png') }}" height="55" width="55" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col col mb-2">
                <div class="bg-white rounded-3 shadow p-3 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <p>latihan <br> Soal</p>
                    </div>
                    <img src="{{ asset('assets/icon/ic-neraca.png') }}" height="55" width="55"
                        alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col col mb-2">
                <div class="bg-white rounded-3 shadow p-3 mb-2s d-flex justify-content-between align-items-center">
                    <div>
                        <p>Matematika <br> Digital</p>
                    </div>
                    <img src="{{ asset('assets/icon/ic-komputer.png') }}" height="55" width="55"
                        alt="">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- berita --}}

<section id="materi" class="py-5">
    <div class="container">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Materi Pembelajaran Dasar </h2>
        </div>

        <div class="row py-5">
            @forelse ($materi as $item)
            <div class="col-lg-4">
                <div class="card border-0">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('assets/images/il-Bilangan.jpg') }}" class="img-fluid mb-3"
                        style="border-radius:12px" alt="{{ $item->title }}">
                    <div class="konten-materi">
                        <p class="mb-3 text-secondary">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</p>
                        <h4 class="fw-bold mb-3">{{ $item->judul }}</h4>
                        <p class="text-secondary">#WebBelajar</p>
                        <a href="{{ route('materi.detail', $item->slug) }}" class="text-decoration-none text-danger">Selengkapnya</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada materi yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>

        <div class="footer-materi text-center">
            <a href="{{ route('materi.index') }}" class="btn btn-outline-danger">Materi Lainnya</a>
        </div>
    </div>
</section>

{{-- berita --}}

{{-- Register --}}

<section id="join" class="py-5">
    <div class="container py-5">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="stripe me-2sty"></div>
                    <h5>Masuk Siswa</h5>
                </div>
                <h2 class="fw-bold mb-2">Belajar Lebih Mudah, Wujudkan Impian Bersama Kami</h2>
                <p class="mb-3">
                    Tempat belajar modern yang membantu memahami pelajaran dengan cara yang menyenangkan dan
                    efektif.
                </p>
                <button class="btn btn-outline-danger">Register</button>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('assets/images/il-regist.png') }}" class="img-fluid" alt=""
                    srcset="">
            </div>
        </div>
    </div>
</section>

{{-- Register --}}

{{-- Vidio Pembelajaran --}}
<section id="vidio" class="py-5">
    <div class="container py-5">
        <div class="text-center">
            <iframe width="560" height="315"
                src="https://www.youtube.com/embed/SZccx2b2Cs0?si=rX-Bv_H36MGc00yv" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>
{{-- Vidio Pembelajaran --}}

{{-- Daftar Vidio --}}
<section id="Daftar_Vidio" class="py-5">
    <div class="container py-5">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Daftar Vidio Pembelajaran </h2>
        </div>

        <div class="row py-5">
            @forelse ($video as $item)
            <div class="col-lg-4">
                <iframe width="100%" height="215"
                    src="{{ $item->url }}"
                    title="{{ $item->judul }}" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada video pembelajaran yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
        <div class="footer-materi text-center">
            <a href="{{ route('fe.video') }}" class="btn btn-outline-danger">Vidio Lainnya</a>
        </div>
    </div>
</section>
{{-- Daftar Vidio --}}

{{-- Tentang --}}
<section id=" Tentang Web " class="section-tentang parallax">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex align-item-center">
                <div class="stripe-putih me-2 "></div>
                <h5 class="fw-bold text-white"> Tentang Website </h5>
            </div>
            <div>
                <a href="" class="btn btn-outline-white"> Lainnya </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-6">
                <img src="{{ asset('assets/images/il-berita-03.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <img src="{{ asset('assets/images/il-berita-03.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <img src="{{ asset('assets/images/il-berita-03.png') }}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <img src="{{ asset('assets/images/il-berita-03.png') }}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>

{{-- Fasilitas --}}
<section id="Fasilitas" class="py-5">
    <div class="container py-5">
        <div class="text-center">
            <h3 class="fw-bold">Fasilitas website</h3>
        </div>
        <img src=" {{ asset('assets/images/il-fasilitas.jpeg') }}" class="img-fluid py-5" alt="">

        <div class=" text-center">
            <a href="" class="btn btn-outline-danger">Fasilitas Lainnya</a>
        </div>
    </div>
</section>
{{-- Fasilitas --}}
@endsection