@extends('fe.layouts.app')

@section('title')
    {{ $latihan->nama }}
@endsection

@push('style')
<style>
    .question-number {
        padding: 10px;
        margin: 5px;
        border-radius: 5px;
        cursor: pointer;
        background-color: #f8f9fa;
    }
    .question-answered {
        background-color: #28a745;
        color: white;
    }
    .current-question {
        border: 2px solid #007bff;
    }
    #timer {
        font-size: 1.5rem;
        font-weight: bold;
        color: #dc3545;
    }
    .timer-warning {
        color: #ff6b35 !important;
    }
    .timer-danger {
        color: #dc3545 !important;
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.3; }
    }
</style>
@endpush

@section('content')
<section id="hero2" class="px-0">
    <div class="container text-center text-white">
        <div class="hero-title">
            <div class="hero-text">{{ $latihan->nama }}</div>
            <h5>Silahkan dikerjakan dengan baik</h5>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row">
        <!-- Kolom Soal (8) -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="timer" class="text-center mb-4"></div>
                    @foreach($soals as $index => $soal)
                    <div class="question-container" id="question-{{ $index + 1 }}" style="{{ $index > 0 ? 'display:none;' : '' }}"
                         data-soal-id="{{ $soal->id }}" data-waktu="{{ $soal->waktu_per_soal }}">
                        <h5 class="mb-4">Soal {{ $index + 1 }} dari {{ count($soals) }}</h5>
                        <div class="question mb-4">
                            {!! $soal->pertanyaan !!}
                        </div>
                        <div class="options">
                            <div class="form-check mb-2">
                                <input class="form-check-input answer-option" type="radio"
                                       name="answer-{{ $soal->id }}" value="A"
                                       data-question="{{ $index + 1 }}">
                                <label class="form-check-label">A. {{ $soal->pilihan_a }}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input answer-option" type="radio"
                                       name="answer-{{ $soal->id }}" value="B"
                                       data-question="{{ $index + 1 }}">
                                <label class="form-check-label">B. {{ $soal->pilihan_b }}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input answer-option" type="radio"
                                       name="answer-{{ $soal->id }}" value="C"
                                       data-question="{{ $index + 1 }}">
                                <label class="form-check-label">C. {{ $soal->pilihan_c }}</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input answer-option" type="radio"
                                       name="answer-{{ $soal->id }}" value="D"
                                       data-question="{{ $index + 1 }}">
                                <label class="form-check-label">D. {{ $soal->pilihan_d }}</label>
                            </div>
                        </div>
                        <div class="mt-4">
                            @if($index > 0)
                                <button class="btn btn-secondary prev-question" data-question="{{ $index + 1 }}">Sebelumnya</button>
                            @endif
                            @if($index < count($soals) - 1)
                                <button class="btn btn-primary next-question" data-question="{{ $index + 1 }}">Selanjutnya</button>
                            @else
                                <button class="btn btn-success" id="selesai-latihan">Selesai</button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Kolom Navigasi Soal (4) -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Navigasi Soal</h5>
                    <div class="d-flex flex-wrap" id="question-navigator">
                        @foreach($soals as $index => $soal)
                            <div class="question-number" data-question="{{ $index + 1 }}">
                                {{ $index + 1 }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = {{ count($soals) }};
    let currentQuestion = 1;
    let timerInterval;
    let isFinishing = false; // Flag untuk mencegah multiple click pada tombol selesai
    let exerciseInProgress = true; // Flag baru: true jika latihan sedang berjalan

    // Object untuk menyimpan waktu start dan durasi tiap soal
    const questionTimers = {};

    // Inisialisasi timer untuk setiap soal
    @foreach($soals as $index => $soal)
        questionTimers[{{ $index + 1 }}] = {
            startTime: null,
            maxTime: {{ $soal->waktu_per_soal }},
            elapsedTime: 0,
            soalId: {{ $soal->id }},
            isAnswered: false,
            selectedAnswer: null,
            isPaused: false
        };
    @endforeach

    // Fungsi untuk memulai timer global
    function startGlobalTimer() {
        clearInterval(timerInterval);

        timerInterval = setInterval(() => {
            updateAllTimers();
        }, 1000);
    }

    // Fungsi untuk update semua timer (termasuk yang tidak aktif)
    function updateAllTimers() {
        // Update timer untuk semua soal yang sudah dimulai
        for (let questionNumber in questionTimers) {
            const questionTimer = questionTimers[questionNumber];

            // Jika timer sudah dimulai dan belum selesai
            if (questionTimer.startTime && !questionTimer.isPaused) {
                const totalElapsed = Math.floor((Date.now() - questionTimer.startTime) / 1000);
                questionTimer.elapsedTime = totalElapsed;

                // Jika waktu habis dan soal belum dijawab
                if (totalElapsed >= questionTimer.maxTime && !questionTimer.isAnswered) {
                    questionTimer.isPaused = true;
                    questionTimer.elapsedTime = questionTimer.maxTime;

                    // Jika ini soal yang sedang aktif, handle time up
                    if (parseInt(questionNumber) === currentQuestion) {
                        handleTimeUp();
                    }
                }
            }
        }

        // Update tampilan timer untuk soal yang sedang aktif
        updateCurrentQuestionDisplay();
    }

    // Fungsi untuk update tampilan timer soal yang sedang aktif
    function updateCurrentQuestionDisplay() {
        const questionTimer = questionTimers[currentQuestion];
        const timerDisplay = document.getElementById('timer');

        if (!questionTimer.startTime) {
            return;
        }

        const remaining = questionTimer.maxTime - questionTimer.elapsedTime;

        if (remaining <= 0 || questionTimer.isPaused) {
            timerDisplay.textContent = `Waktu: 0:00`;
            timerDisplay.classList.add('timer-danger');
        } else {
            // Update tampilan timer
            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;
            timerDisplay.textContent = `Waktu: ${minutes}:${seconds.toString().padStart(2, '0')}`;

            // Ubah warna timer berdasarkan sisa waktu
            timerDisplay.classList.remove('timer-warning', 'timer-danger');
            if (remaining <= 10) {
                timerDisplay.classList.add('timer-danger');
            } else if (remaining <= 30) {
                timerDisplay.classList.add('timer-warning');
            }
        }
    }

    // Fungsi ketika waktu habis
    function handleTimeUp() {
        const questionTimer = questionTimers[currentQuestion];

        // Jika belum dijawab, simpan sebagai tidak dijawab
        if (!questionTimer.isAnswered) {
            saveAnswer(questionTimer.soalId, '', questionTimer.maxTime);
        }

        // Pindah ke soal berikutnya
        if (currentQuestion < totalQuestions) {
            nextQuestion();
        } else {
            // Jika sudah soal terakhir, selesaikan latihan
            finishExercise();
        }
    }

    // Fungsi untuk menampilkan soal tertentu
    function showQuestion(questionNumber) {
        // Simpan nomor soal yang sedang aktif sebelum diperbarui
        const oldCurrentQuestion = currentQuestion;

        // Jika ada soal sebelumnya dan belum dijawab, pause timernya
        if (oldCurrentQuestion && questionTimers[oldCurrentQuestion] && !questionTimers[oldCurrentQuestion].isAnswered) {
            questionTimers[oldCurrentQuestion].isPaused = true;
        }

        // Sembunyikan semua soal
        document.querySelectorAll('.question-container').forEach(q => q.style.display = 'none');

        // Tampilkan soal yang dipilih
        const questionContainer = document.querySelector(`#question-${questionNumber}`);
        questionContainer.style.display = 'block';

        // Update current question
        currentQuestion = questionNumber;

        // Dapatkan objek timer untuk soal yang baru aktif
        const questionTimer = questionTimers[questionNumber];

        // Mulai timer untuk soal ini jika belum pernah dimulai
        if (!questionTimer.startTime) {
            questionTimer.startTime = Date.now();
        }
        // Pastikan timer untuk soal yang sedang aktif tidak dalam keadaan paused
        // Ini penting jika pengguna kembali ke soal yang belum dijawab
        questionTimer.isPaused = false;

        // Update indikator soal aktif
        document.querySelectorAll('.question-number').forEach(num => {
            num.classList.remove('current-question');
        });
        document.querySelector(`.question-number[data-question="${questionNumber}"]`).classList.add('current-question');

        // Restore jawaban jika sudah pernah dijawab
        restoreAnswer(questionNumber);

        // Update tampilan timer
        updateCurrentQuestionDisplay();
    }

    // Fungsi untuk merestore jawaban yang sudah dipilih
    function restoreAnswer(questionNumber) {
        const questionTimer = questionTimers[questionNumber];
        if (questionTimer.selectedAnswer) {
            const answerInput = document.querySelector(`input[name="answer-${questionTimer.soalId}"][value="${questionTimer.selectedAnswer}"]`);
            if (answerInput) {
                answerInput.checked = true;
            }
        }
    }

    // Fungsi untuk menyimpan jawaban
    async function saveAnswer(soalId, jawaban, durasi) {
        try {
            const response = await fetch('{{ route("latihan.jawab") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    sesi_latihan_id: {{ $sesi_latihan_id }},
                    soal_id: soalId,
                    jawaban_pilihan: jawaban,
                    durasi_pengerjaan: durasi
                })
            });
            return await response.json();
        } catch (error) {
            console.error('Error saving answer:', error);
            throw error;
        }
    }

    // Fungsi untuk pindah ke soal berikutnya
    function nextQuestion() {
        if (currentQuestion < totalQuestions) {
            showQuestion(currentQuestion + 1);
        }
    }

    // Fungsi untuk pindah ke soal sebelumnya
    function prevQuestion() {
        if (currentQuestion > 1) {
            showQuestion(currentQuestion - 1);
        }
    }

    // Fungsi untuk menyelesaikan latihan (dengan protection dari multiple click)
    async function finishExercise() {
        // Cek apakah sedang dalam proses finishing
        if (isFinishing) {
            return;
        }

        if (confirm('Anda yakin ingin menyelesaikan latihan?')) {
            isFinishing = true; // Set flag untuk mencegah multiple click

            // Disable tombol selesai untuk mencegah click berulang
            const finishButton = document.getElementById('selesai-latihan');
            if (finishButton) {
                finishButton.disabled = true;
                finishButton.textContent = 'Menyelesaikan...';
            }

            document.getElementById('loading-overlay').style.display = 'flex';

            try {
                const response = await fetch('{{ route("latihan.selesai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sesi_latihan_id: {{ $sesi_latihan_id }}
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Set flag latihan selesai menjadi false
                    exerciseInProgress = false;
                    // Stop timer sebelum redirect
                    clearInterval(timerInterval);
                    window.location.href = '{{ url("/latihan/hasil") }}/' + {{ $sesi_latihan_id }};
                } else {
                    throw new Error(data.message || 'Failed to finish');
                }
            } catch (error) {
                console.error('Error finishing test:', error);
                alert('Terjadi kesalahan saat menyelesaikan latihan: ' + error.message);

                // Reset flag dan tombol jika error
                isFinishing = false;
                if (finishButton) {
                    finishButton.disabled = false;
                    finishButton.textContent = 'Selesai';
                }
            } finally {
                document.getElementById('loading-overlay').style.display = 'none';
            }
        }
    }

    // Event listeners untuk tombol navigasi
    document.querySelectorAll('.next-question').forEach(button => {
        button.addEventListener('click', () => nextQuestion());
    });

    document.querySelectorAll('.prev-question').forEach(button => {
        button.addEventListener('click', () => prevQuestion());
    });

    // Event listener untuk navigasi angka soal
    document.querySelectorAll('.question-number').forEach(number => {
        number.addEventListener('click', function() {
            const questionNumber = parseInt(this.dataset.question);
            showQuestion(questionNumber);
        });
    });

    // Event listener untuk pemilihan jawaban
    document.querySelectorAll('.answer-option').forEach(option => {
        option.addEventListener('change', async function() {
            const questionContainer = this.closest('.question-container');
            const soalId = questionContainer.dataset.soalId;
            const questionNumber = parseInt(this.dataset.question);
            const questionTimer = questionTimers[questionNumber];

            // Simpan jawaban yang dipilih
            questionTimer.selectedAnswer = this.value;
            questionTimer.isAnswered = true;
            questionTimer.isPaused = true; // Pause timer setelah dijawab

            document.getElementById('loading-overlay').style.display = 'flex';

            try {
                const result = await saveAnswer(soalId, this.value, questionTimer.elapsedTime);

                // Tandai soal sebagai sudah dijawab
                document.querySelector(`.question-number[data-question="${questionNumber}"]`)
                    .classList.add('question-answered');

                // Otomatis pindah ke soal berikutnya setelah 1 detik
                setTimeout(() => {
                    if (currentQuestion < totalQuestions) {
                        nextQuestion();
                    }
                }, 1000);

            } catch (error) {
                console.error('Error saving answer:', error);
                alert('Terjadi kesalahan saat menyimpan jawaban');

                // Reset jika error
                questionTimer.selectedAnswer = null;
                questionTimer.isAnswered = false;
                questionTimer.isPaused = false;
                this.checked = false;
            } finally {
                document.getElementById('loading-overlay').style.display = 'none';
            }
        });
    });

    // Event listener untuk mencegah navigasi jika latihan belum selesai
    window.addEventListener('beforeunload', function (e) {
        if (exerciseInProgress) {
            // Cancel the event
            e.preventDefault();
            // Chrome requires returnValue to be set
            e.returnValue = '';
            // Custom message for older browsers (modern browsers show a generic message)
            return 'Latihan Anda belum selesai. Apakah Anda yakin ingin meninggalkan halaman ini?';
        }
    });

    // Mulai dengan soal pertama
    showQuestion(1);
    startGlobalTimer();
});
</script>
@endpush