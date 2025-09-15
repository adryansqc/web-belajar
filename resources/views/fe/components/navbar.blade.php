{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/icon/ic-logo.png') }}" height="55" width="55" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('fe.index') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('materi.index') }}">Materi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('fe.latihan') }}">Latihan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('fe.nilai') }}">Nilai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('fe.video') }}">Vidio Belajar</a>
                </li>

            </ul>
            <div class="d-flex">
                <button class="btn btn-danger ">Register</button>
            </div>
        </div>
    </div>
</nav>
{{-- Navbar --}}