<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mandiri Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .attendance-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .pulse-animation {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-blue-800">SISTEM ABSENSI PENGAMBILAN LAPTOP</h1>
            <p class="text-gray-600 mt-2">SMK Darul Lughah Wal Karomah - Tahun Ajaran 2025/2026</p>
            <div class="mt-4 flex justify-center items-center space-x-4">
                <div class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-sm">
                    <i class="fas fa-calendar-day mr-1"></i>
                    <span id="current-date">Senin, 20 Juli 2023</span>
                </div>
                <div class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-sm">
                    <i class="fas fa-clock mr-1"></i>
                    <span id="current-time">07:30:45</span>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Bagian Kiri - Form Absensi (Lebih Kecil) -->
            <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-1">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Form Absensi</h2>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Pilih Metode Absensi
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button id="camera-btn" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg flex flex-col items-center justify-center transition-all">
                            <i class="fas fa-camera text-2xl mb-2"></i>
                            <span>Gunakan Kamera</span>
                        </button>
                        <button id="scanner-btn" class="bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg flex flex-col items-center justify-center transition-all">
                            <i class="fas fa-id-card text-2xl mb-2"></i>
                            <span>QR Code Scanner</span>
                        </button>
                    </div>
                </div>

                <!-- Form untuk Kamera -->
                <div id="camera-section" class="hidden mb-6">
                    <!-- <label class="block text-gray-700 text-sm font-bold mb-2">
                        Foto Wajah
                    </label> -->

                    <!-- Pilihan Kamera -->
                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-1">Pilih Kamera</label>
                        <select id="camera-select" class="w-full border border-gray-300 rounded-lg py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Memuat daftar kamera...</option>
                        </select>
                    </div>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <!-- Preview Kamera -->
                        <!-- <select id="camera-select" class="mb-4 p-2 border rounded"></select> -->

                        <div class="relative w-full h-70">
                            <!-- <video id="camera-preview" autoplay playsinline class="w-full h-full object-cover hidden"></video> -->

                            <div id="camera-placeholder" class="absolute inset-0 flex items-center justify-center bg-gray-200">
                                <i class="fas fa-camera text-4xl text-gray-400"></i>
                            </div>

                            <div id="qr-reader" class="w-full"></div>
                        </div>

                        <p class="text-danger"><span id="result"></span></p>
                        <audio id="success-sound" src="<?= base_url('assets/audio/berhasil.mp3') ?>"></audio>
                        <audio id="error-sound" src="<?= base_url('assets/audio/tidak_ada.mp3') ?>">"></audio>
                        <audio id="warning-sound" src="<?= base_url('assets/audio/sudah.mp3') ?>">"></audio>

                        <div class="flex justify-center space-x-3">
                            <button id="capture-btn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline hidden">
                                <i class="fas fa-camera mr-2"></i>Ambil Foto
                            </button>
                            <button id="retake-btn" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline hidden">
                                <i class="fas fa-redo mr-2"></i>Ulangi
                            </button>
                            <button id="save-photo-btn" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline hidden">
                                <i class="fas fa-check mr-2"></i>Simpan Foto
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Form untuk Scanner -->
                <div id="scanner-section" class="hidden mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Tempelkan Kartu RFID
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <div class="w-full h-40 bg-gray-100 mb-3 flex items-center justify-center">
                            <i class="fas fa-id-card text-6xl text-gray-400 pulse-animation"></i>
                        </div>
                        <p class="text-sm text-gray-500">Tempelkan kartu siswa ke scanner</p>
                    </div>
                </div>

                <!-- Status Kehadiran -->
                <!-- <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Konfirmasi Status Kehadiran
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                            Hadir
                        </button>
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                            Izin
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                            Sakit
                        </button>
                        <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                            Alpa
                        </button>
                    </div>
                </div>
                
                <button class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-full focus:outline-none focus:shadow-outline">
                    <i class="fas fa-check-circle mr-2"></i>Simpan Absensi
                </button> -->
            </div>

            <!-- Bagian Kanan - Tampilan Siswa yang Absen -->
            <div class="bg-white rounded-xl shadow-md p-6 lg:col-span-2">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <?php if ($jenis->isi == 'ambil') { ?>
                        <h2 class="text-xl font-semibold text-green-600">Absensi Pengambilan</h2>
                    <?php } else { ?>
                        <h2 class="text-xl font-semibold text-red-600">Absensi Pengembalian</h2>
                    <?php } ?>
                    <div class="text-sm bg-blue-100 text-blue-800 py-1 px-2 rounded-full">
                        <a href="<?= base_url('laptop/gantiSesi') ?>" onclick="return confirm('Yakin akan pindah sesi ?')">Ganti Sesi</a>
                    </div>
                </div>

                <!-- Area Foto dan Identitas Siswa Terakhir Absen -->
                <div id="last-attendance" class="mb-6 p-4 bg-blue-50 rounded-lg attendance-card">
                    <div class="flex flex-col md:flex-row gap-4">
                        <!-- Identitas di sebelah kiri -->
                        <div class="flex-1">
                            <h3 id="student-name" class="text-xl font-bold text-gray-800 mb-2">nama siswa</h3>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                <div>
                                    <p class="text-xs text-gray-500">Kelas</p>
                                    <p id="student-class" class="font-medium">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">NIS</p>
                                    <p id="student-nis" class="font-medium">0</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <p id="student-status" class="font-medium"><span class="bg-yellow-100 text-yellow-800 py-0.5 px-2 rounded-full text-xs">Keterangan</span></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Waktu</p>
                                    <p id="student-time" class="font-medium">00:00:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Foto di sebelah kanan (kotak) -->
                        <div class="flex-shrink-0 w-32 h-32 md:w-40 md:h-40">
                            <!-- <img id="student-photo" src="https://via.placeholder.com/400x400" alt="Foto Siswa" class="w-full h-full object-cover rounded-lg border border-gray-300"> -->
                            <img id="student-photo" src="<?= base_url('assets/images/laptop.png') ?>" alt="Foto Siswa" class="w-full h-full object-cover rounded-lg border border-gray-300">
                        </div>
                    </div>
                </div>

                <!-- Daftar Absensi Hari Ini -->
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Daftar Absensi Hari Ini</h3>
                <div class="overflow-y-auto max-h-64 pr-2">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengambilan</th>
                                <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tabledata">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            loadTable()
            // loadProsentase()
        });
    </script>
    <script>
        const qrRegionId = "qr-reader";
        const reader = new Html5Qrcode(qrRegionId);
        const cameraSelect = document.getElementById("camera-select");
        const placeholder = document.getElementById('camera-placeholder');

        function onScanSuccess(decodedText, decodedResult) {
            // Hasil kode QR
            // Hentikan kamera setelah berhasil
            //   reader.stop().then(() => {
            //       console.log("Scanning stopped.");
            //   }).catch(err => console.error("Error stopping the scanner:", err));
            //   document.getElementById("result").textContent = '';
            $.ajax({
                type: "POST",
                url: "<?= base_url('laptop/addAbsens') ?>",
                data: {
                    "tanggal": "<?= date('Y-m-d') ?>",
                    "nis": decodedText
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 'ok') {
                        soundToPlay = document.getElementById("success-sound");
                        loadTable()
                        // loadProsentase()
                        document.getElementById('student-name').textContent = data.nama;
                        document.getElementById('student-class').textContent = data.kelas;
                        document.getElementById('student-nis').textContent = data.nis;
                        if (data.jenis == 'ambil') {
                            document.getElementById('student-status').innerHTML = '<span class="bg-green-100 text-green-800 py-0.5 px-2 rounded-full text-xs">Diambil</span>';
                        } else {
                            document.getElementById('student-status').innerHTML = '<span class="bg-red-100 text-red-800 py-0.5 px-2 rounded-full text-xs">Dikembalikan</span>';
                        }
                        document.getElementById('student-time').textContent = data.waktu;

                    } else if (data.status == 'sudah') {
                        soundToPlay = document.getElementById("warning-sound");
                        document.getElementById("result").textContent = '';
                        document.getElementById("result").textContent = data.message;
                    } else if (data.status == 'not_found') {
                        soundToPlay = document.getElementById("error-sound");
                        document.getElementById("result").textContent = '';
                        document.getElementById("result").textContent = data.message;
                    } else {
                        document.getElementById("result").textContent = '';
                        document.getElementById("result").textContent = data.message;
                    }
                    soundToPlay.play().catch(err => console.error("Error playing sound:", err));
                    // console.log(data);

                }
            })
        }

        function onScanError(errorMessage) {
            // Kesalahan saat scanning
            console.warn("Scan error:", errorMessage);
        }

        // Fungsi untuk memulai kamera berdasarkan ID
        function startCamera(cameraId) {
            placeholder.classList.add('hidden');
            reader.start(
                cameraId, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                onScanSuccess,
                onScanError
            ).catch(err => {
                console.error("❌ Gagal memulai kamera:", err);
            });
        }

        // Ambil daftar kamera
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                devices.forEach((device, index) => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label || `Kamera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                // Otomatis mulai dengan kamera pertama
                startCamera(devices[0].id);
            } else {
                console.error("❌ Tidak ada kamera ditemukan.");
            }
        }).catch(err => {
            console.error("❌ Error mendapatkan kamera:", err);
        });

        // Ganti kamera saat dropdown berubah
        cameraSelect.addEventListener("change", (event) => {
            const selectedCameraId = event.target.value;
            reader.stop().then(() => {
                startCamera(selectedCameraId);
            }).catch(err => {
                console.error("❌ Gagal berhenti dari kamera sebelumnya:", err);
            });
        });
    </script>

    <script>
        function loadTable() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('laptop/loadAbsen') ?>",
                data: {
                    "tanggal": "<?= date('Y-m-d') ?>"
                },
                dataType: "json",
                success: function(data) {
                    var html = '';
                    $.each(data, function(index, item) {
                        html += '<tr>';
                        html += "<td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>" + (index + 1) + "</td>";
                        html += "<td class='px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900'>" + item.nama + "</td>";
                        html += "<td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>" + item.k_formal + "</td>";
                        html += "<td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>" + item.ambil + "</td>";
                        html += "<td class='px-3 py-2 whitespace-nowrap text-sm text-gray-500'>" + item.kembali + "</td>";
                        html += '</tr>';
                    });
                    $('#tabledata').html(html);
                    // console.log(data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update waktu secara real-time
            function updateDateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
                document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
            }
            setInterval(updateDateTime, 1000);
            updateDateTime();

            // Toggle antara kamera dan scanner
            const cameraBtn = document.getElementById('camera-btn');
            const scannerBtn = document.getElementById('scanner-btn');
            const cameraSection = document.getElementById('camera-section');
            const scannerSection = document.getElementById('scanner-section');

            cameraBtn.addEventListener('click', function() {
                cameraSection.classList.remove('hidden');
                scannerSection.classList.add('hidden');
                cameraBtn.classList.add('bg-blue-600');
                scannerBtn.classList.remove('bg-green-600');
                scannerBtn.classList.add('bg-green-500');
            });

            scannerBtn.addEventListener('click', function() {
                scannerSection.classList.remove('hidden');
                cameraSection.classList.add('hidden');
                scannerBtn.classList.add('bg-green-600');
                cameraBtn.classList.remove('bg-blue-600');
                cameraBtn.classList.add('bg-blue-500');

                // Simulasi scan kartu setelah 2 detik
                setTimeout(function() {
                    showStudentInfo();
                }, 2000);
            });



            // Simulasi absen dengan kamera (untuk demo)
            document.querySelector('#camera-section button').addEventListener('click', function() {
                showStudentInfo();
            });
        });
    </script>
</body>

</html>