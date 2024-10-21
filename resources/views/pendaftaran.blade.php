@extends('layout.app')
@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container">
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Pendaftaran Siswa Baru</li>
                    </ol>
                </nav>
                <h1>Pendaftaran Siswa Baru</h1>
            </div>
        </div><!-- End Page Title -->

        <!-- Features Section -->
        <section id="features" class="features section">

            <div class="container">

                <div class="d-flex justify-content-center">

                    <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">

                        <li class="nav-item">
                            <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                                <h4>Step 1 : Data Siswa</h4>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                                <h4>Step 2 : Data Orang Tua</h4>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                                <h4>Step 3 : Data Wali</h4>
                            </a>
                        </li>

                    </ul>

                </div>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <!-- Step 1: Data Siswa -->
                    <div class="tab-pane fade active show" id="features-tab-1">
                        @include('step.step1')
                        <div class="d-flex justify-content-center mt-4">
                            <button type="button" class="btn btn-primary btn-next">Berikutnya</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="features-tab-2">
                        @include('step.step2')
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary btn-prev">Sebelumnya</button>
                            <button type="button" class="btn btn-primary btn-next">Berikutnya</button>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="features-tab-3">
                        <form action="{{ route('register.final') }}" method="POST">
                            @csrf
                            @include('step.step3')
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary btn-prev">Sebelumnya</button>
                                <button type="submit" class="btn btn-primary">Lanjutkan</button>
                            </div>
                        </form>
                    </div>



                    <!-- Modal for final confirmation -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Perhatian!</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p style="text-decoration: underline;"><b>Harap persiapkan data berikut :</b>
                                    </p>
                                    <ol>
                                        <li>Fotocopy Akte Kelahiran</li>
                                        <li>Fotocopy Kartu Keluarga</li>
                                        <li>Fotocopy KTP Orang Tua/Wali Murid</li>
                                        <li>Pas Photo Latar Merah</li>
                                        <li>Fotocopy Ijazah TK (jika ada)</li>
                                    </ol>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <!-- Submit final form -->
                                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
            </div>

        </section><!-- /Features Section -->

    </main>

    <!-- JavaScript for step navigation -->
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.tab-pane');
        const stepIndicator = document.querySelectorAll('.nav-tabs .nav-link');
        const btnNext = document.querySelectorAll('.btn-next');
        const btnPrev = document.querySelectorAll('.btn-prev');

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index === step);
                el.classList.toggle('show', index === step);
                stepIndicator[index].classList.toggle('active', index === step);
                stepIndicator[index].classList.toggle('show', index === step);
            });
        }

        function validateStep(step) {
            const inputs = steps[step].querySelectorAll('input[required]');
            let formIsValid = true;
            for (let input of inputs) {
                if (!input.reportValidity()) {
                    formIsValid = false;
                    break;
                }
            }
            return formIsValid;
        }

        btnNext.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default behavior
                if (validateStep(currentStep)) { // Validate the current step
                    currentStep++; // Move to next step
                    showStep(currentStep); // Show the next step
                }
            });
        });

        btnPrev.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default behavior
                currentStep--; // Move to previous step
                showStep(currentStep); // Show the previous step
            });
        });

        // Initialize by showing the first step
        showStep(currentStep);
    </script>

    <script>
        function toggleInputPendidikan() {
            const pendidikanAyah = document.querySelector('input[name="pendidikanAyah"]:checked');
            const pendidikanIbu = document.querySelector('input[name="pendidikanIbu"]:checked');

            const inputLainPendidikanAyah = document.getElementById('inputLainPendidikanAyah');
            const inputLainPendidikanIbu = document.getElementById('inputLainPendidikanIbu');

            // Menampilkan atau menyembunyikan input berdasarkan status radio button
            inputLainPendidikanAyah.style.display = pendidikanAyah && pendidikanAyah.value === 'Lain-lain' ? 'block' :
                'none';
            inputLainPendidikanIbu.style.display = pendidikanIbu && pendidikanIbu.value === 'Lain-lain' ? 'block' : 'none';
        }

        function toggleInputRekreasi() {
            const lainCheckbox = document.getElementById('rekreasi5');
            const inputLainRekreasi = document.getElementById('inputLainRekreasi');

            inputLainRekreasi.style.display = lainCheckbox.checked ? 'block' : 'none';
        }

        function updatePlaceholderAyah() {
            const select = document.getElementById('jobSelectAyah');
            const input = document.getElementById('detailInputAyah');

            // Ambil nilai yang dipilih
            const selectedValue = select.value;

            // Ubah placeholder dan tampilkan input berdasarkan pilihan
            if (selectedValue >= 1 && selectedValue <= 7) {
                input.placeholder = "Masukan detail golongan";
                input.style.display = "block"; // Tampilkan input
            } else if (selectedValue === "8") {
                input.placeholder = "Masukan pekerjaan ayah";
                input.style.display = "block"; // Tampilkan input
            } else {
                input.placeholder = ""; // Kosongkan placeholder
                input.style.display = "none"; // Sembunyikan input
            }
        }

        function updatePlaceholderIbu() {
            const select = document.getElementById('jobSelectIbu');
            const input = document.getElementById('detailInputIbu');

            // Ambil nilai yang dipilih
            const selectedValue = select.value;

            // Ubah placeholder dan tampilkan input berdasarkan pilihan
            if (selectedValue >= 1 && selectedValue <= 7) {
                input.placeholder = "Masukan detail golongan";
                input.style.display = "block"; // Tampilkan input
            } else if (selectedValue === "8") {
                input.placeholder = "Masukan pekerjaan Ibu";
                input.style.display = "block"; // Tampilkan input
            } else {
                input.placeholder = ""; // Kosongkan placeholder
                input.style.display = "none"; // Sembunyikan input
            }
        }
    </script>


    <!-- ini javascript jozu -->
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const stepIndicator = document.querySelectorAll('.step-indicator div');
        const btnNext = document.querySelectorAll('.btn-next');
        const btnPrev = document.querySelectorAll('.btn-prev');

        function showStep(step) {
            steps.forEach((el, index) => {
                el.classList.toggle('active', index === step);
                stepIndicator[index].classList.toggle('active', index === step);
            });
        }

        function validateStep(step) {
            // Ambil hanya input yang memiliki atribut 'required'
            const inputs = steps[step].querySelectorAll('input[required]');
            let formIsValid = true;

            // Cek semua input 'required' dan berhenti jika ada yang tidak valid
            for (let input of inputs) {
                if (!input.reportValidity()) {
                    formIsValid = false;
                    break; // Hentikan validasi setelah menemukan input yang tidak valid
                }
            }

            return formIsValid;
        }


        btnNext.forEach(button => {
            button.addEventListener('click', () => {
                if (validateStep(currentStep)) { // Validasi menggunakan required
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        btnPrev.forEach(button => {
            button.addEventListener('click', () => {
                currentStep--;
                showStep(currentStep);
            });
        });

        showStep(currentStep); // Show the first step on page load
    </script>
    <script>
        // Ambil elemen checkbox dan input teks
        const lainLainCheckbox = document.getElementById('lainLain');
        const inputLainLain = document.getElementById('inputLainLain');

        // Tambahkan event listener pada checkbox 'Lain-lain'
        lainLainCheckbox.addEventListener('change', function() {
            if (this.checked) {
                inputLainLain.style.display = 'block'; // Tampilkan input teks jika dipilih
            } else {
                inputLainLain.style.display = 'none'; // Sembunyikan input teks jika tidak dipilih
            }
        });
    </script>
    <!-- Script untuk menampilkan input text jika suku lain-lain dipilih -->
    <script>
        const lainLainSukuRadio = document.getElementById('lainLainSuku');
        const inputLainLainSuku = document.getElementById('inputLainLainSuku');

        const sukuRadios = document.querySelectorAll('input[name="suku"]');

        sukuRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (lainLainSukuRadio.checked) {
                    inputLainLainSuku.style.display =
                    'block'; // Tampilkan input teks jika 'Lain-lain' dipilih
                } else {
                    inputLainLainSuku.style.display =
                    'none'; // Sembunyikan input teks jika 'Lain-lain' tidak dipilih
                }
            });
        });
    </script>
    <!-- Script untuk menampilkan input text jika 'Lain-lain' dipilih -->
    <script>
        const lainLainKewarganegaraanRadio = document.getElementById('lainLainKewarganegaraan');
        const indonesiaRadio = document.getElementById('indonesia');
        const inputLainLainKewarganegaraan = document.getElementById('inputLainLainKewarganegaraan');

        // Event listener untuk radio button kewarganegaraan
        lainLainKewarganegaraanRadio.addEventListener('change', function() {
            if (this.checked) {
                inputLainLainKewarganegaraan.style.display =
                'block'; // Tampilkan input teks jika 'Lain-lain' dipilih
            }
        });

        indonesiaRadio.addEventListener('change', function() {
            if (this.checked) {
                inputLainLainKewarganegaraan.style.display =
                'none'; // Sembunyikan input teks jika 'Indonesia' dipilih
            }
        });
    </script>
    <!-- Script untuk menampilkan input text jika 'Lain-lain' dipilih -->
    <script>
        const lainLainAgamaRadio = document.getElementById('lainLainAgama');
        const inputLainLainAgama = document.getElementById('inputLainLainAgama');

        const agamaRadios = document.querySelectorAll('input[name="agama"]');

        agamaRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (lainLainAgamaRadio.checked) {
                    inputLainLainAgama.style.display =
                    'block'; // Tampilkan input teks jika 'Lain-lain' dipilih
                } else {
                    inputLainLainAgama.style.display =
                    'none'; // Sembunyikan input teks jika 'Lain-lain' tidak dipilih
                }
            });
        });
    </script>
@endsection
