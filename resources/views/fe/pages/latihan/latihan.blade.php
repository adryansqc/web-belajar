@extends('fe.layouts.app')

@section('title')
    Latihan
@endsection

@section('content')

<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">Latihan Soal Kelas 1 SD - Matematika</div>
            <h5>Pilih latihan untuk dikerjakan</h5>
        </div>
    </div>
</section>

<section id="materi" class="py-5">
    <div class="container">
        <div class="header-materi text-center">
            <h2 class="fw-bolds"> Daftar Latihan Soal </h2>
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
                            <button
                                class="btn btn-danger mulai-latihan"
                                data-latihan-id="{{ $item->id }}"
                                data-latihan-nama="{{ $item->nama }}"
                            >
                                Mulai Latihan
                            </button>
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

<!-- Modal Form Data Siswa -->
<div class="modal fade" id="modalDataSiswa" tabindex="-1" aria-labelledby="modalDataSiswaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="GET" action="{{ route('latihan.mulai') }}">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Data Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="latihan_id" id="inputLatihanId">
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" name="nama_siswa" required>
          </div>
          <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" class="form-control" name="kelas" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Mulai Latihan</button>
        </div>
      </div>
    </form>
  </div>
</div>



@push('scripts')
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
@endpush
@endsection
