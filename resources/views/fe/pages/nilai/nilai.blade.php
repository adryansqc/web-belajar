@extends('fe.layouts.app')

@section('title')
    Nilai
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Nilai Latihan</div>
            <h5>Nilai latihan yang telah dikerjakan</h5>
        </div>
    </div>
</section>

<section id="materi" class="py-5">
    <div class="container">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Daftar Latihan </h2>
        </div>

        <div class="row py-5">
            @forelse ($latihan as $item)
                <div class="col-lg-4">
                    <div class="card border-0">
                        <img src="{{ asset('assets/images/il-Bilangan.jpg') }}" class="img-fluid mb-3"
                            style="border-radius:12px" alt="{{ $item->nama }}">
                        <div class="konten-materi">
                            <p class="mb-3 text-secondary">{{ $item->created_at->format('d/m/Y') }}</p>
                            <h4 class="fw-bold mb-3">{{ $item->nama }}</h4>
                            <a href="{{ route('fe.nilai.detail', $item->id) }}"
                                class="btn btn-danger"
                            >
                                Lihat Nilai
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="lead text-muted">Latihan belum tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $latihan->links() }}
        </div>
    </div>
</section>

{{-- @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const buttons = document.querySelectorAll('.mulai-latihan');
            const modalElement = document.getElementById('modalDataSiswa');

            if (!modalElement) {
                console.error('Modal element not found');
                return;
            }

            const modal = new bootstrap.Modal(modalElement);
            const inputLatihanId = document.getElementById('inputLatihanId');

            buttons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const latihanId = this.getAttribute('data-latihan-id');
                    console.log('Button clicked, latihan ID:', latihanId);
                    inputLatihanId.value = latihanId;
                    modal.show();
                });
            });
        } catch (error) {
            console.error('Error initializing modal:', error);
        }
    });
</script>
@endpush --}}
@endsection
