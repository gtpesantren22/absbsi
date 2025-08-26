<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Absensi Kehadiran Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
        }

        .motivation-card {
            transition: all 0.3s ease;
        }

        .motivation-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.2);
        }

        .photo-frame {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .text-fit {
            display: inline-block;
            max-width: 100%;
            font-size: 2rem;
            /* ukuran awal */
            transform-origin: left center;
        }

        /* trik supaya teks mengecil otomatis */
        .text-fit {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .aspect-3-4 {
            position: relative;
            width: 100%;
            padding-top: calc(4 / 3 * 100%);
            /* tinggi = lebar * 4/3 */
        }

        .aspect-3-4>img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <div class="container mx-auto px-4 py-3 flex-grow">
        <!-- Header -->
        <header class="text-center mb-5">
            <h1 class="text-3xl md:text-4xl font-bold text-indigo-800 mb-1">LAPORAN KEHADIRAN SISWA</h1>
            <p class="text-lg text-gray-600 font-medium">Tahun Ajaran 2025/2026 - Semester Ganjil</p>
            <div class="w-24 h-1.5 bg-indigo-500 mx-auto mt-3 rounded-full"></div>
        </header>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-6 h-[calc(100%-115px)]">
            <!-- Left Section - Student Photos -->
            <div class="lg:w-3/5 bg-white rounded-xl shadow-md overflow-hidden p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-3 border-b border-gray-200">
                    SISWA TERAWAL & TERAKHIR
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-grow">
                    <!-- First Student -->
                    <div class="bg-white border border-indigo-200 rounded-xl shadow-lg overflow-hidden flex flex-col">
                        <!-- Label full width -->
                        <div class="bg-green-600 text-white text-center py-2 text-lg font-bold uppercase tracking-wide">
                            Kedatangan Paling Awal
                        </div>

                        <!-- Foto full parent -->
                        <div class="aspect-[3/4] w-full" id="foto-awal">
                            <!-- <img src="<?= base_url('assets/foto_siswa/') ?>foto.jpg" alt="Siswa Terawal" class="w-full h-full object-cover rounded-lg shadow-md border-4 border-white"> -->
                        </div>
                        <!-- Nama & Kelas -->
                        <div class="p-4 text-center">
                            <div class="w-full max-w-md">
                                <h3 id="nama-awal"
                                    class="text-gray-900 font-extrabold text-center leading-tight whitespace-nowrap overflow-hidden text-ellipsis text-fit">
                                    Nama siswa
                                </h3>
                            </div>
                            <p class="text-lg md:text-xl text-green-700 font-semibold" id="kelas-awal"></p>
                        </div>
                    </div>

                    <!-- Last Student -->
                    <div class="bg-white border border-amber-200 rounded-xl shadow-lg overflow-hidden flex flex-col">
                        <!-- Label full width -->
                        <div class="bg-red-500 text-white text-center py-2 text-lg font-bold uppercase tracking-wide">
                            Kedatangan Paling Akahir
                        </div>

                        <!-- Foto full parent -->
                        <div class="aspect-[3/4] w-full" id="foto-akhir">
                            <!-- <img src="<?= base_url('assets/foto_siswa/') ?>foto2.jpg" alt="Siswa Terawal" class="w-full h-full object-cover rounded-lg shadow-md border-4 border-white"> -->
                        </div>

                        <!-- Nama & Kelas -->
                        <div class="p-4 text-center">
                            <div class="w-full max-w-md">
                                <h3 id="nama-akhir"
                                    class="text-gray-900 font-extrabold text-center leading-tight whitespace-nowrap overflow-hidden text-ellipsis text-fit">
                                    Nama siswa
                                </h3>
                            </div>
                            <p class="text-lg md:text-xl text-red-600 font-semibold" id="kelas-akhir"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Attendance Summary -->
            <div class="lg:w-2/5 flex flex-col">
                <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 flex-grow mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-3 border-b border-gray-200">REKAP KEHADIRAN</h2>

                    <div class="overflow-x-auto h-[calc(100%-100px)]">
                        <div id="rekapChart" class="mx-auto"></div>
                    </div>
                </div>

                <!-- Motivation Quote -->
                <div class="motivation-card bg-white rounded-xl shadow-md overflow-hidden p-6 flex-grow">
                    <div class="flex items-start h-full">
                        <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-full mt-1">
                            <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="ml-5">
                            <p class="text-lg md:text-xl text-gray-700 italic leading-relaxed">
                                "Kehadiran adalah cermin kedisiplinan. Setiap hari yang diisi dengan kehadiran tepat waktu adalah langkah kecil menuju kesuksesan besar. Mari kita jadikan kedisiplinan sebagai budaya yang membawa kemajuan bersama."
                            </p>
                            <p class="text-right mt-4 text-sm text-gray-500 font-medium">
                                — <span class="text-indigo-600">Bu Dian S.Pd</span>, Guru Matematika & Wali Kelas XII IPA 1
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 border-t border-gray-200">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-600 text-sm font-medium">© 2024 SMA NEGERI 1 MAJU JAYA • Sistem Informasi Kehadiran Siswa</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        var options = {
            chart: {
                type: 'donut',
                height: 350
            },
            series: [120, 15, 30], // contoh data [Hadir, Terlambat, Belum Hadir]
            labels: ['Hadir', 'Terlambat', 'Belum Hadir'],
            colors: ['#34d399', '#fbbf24', '#f87171'], // Hijau, Kuning, Merah
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '20px',
                    fontWeight: 'bold'
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '45%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '20px',
                                fontWeight: 600
                            }
                        }
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#rekapChart"), options);
        chart.render();
    </script>
    <script>
        $(document).ready(function() {
            loadAbsen()
        })
        setInterval(loadAbsen, 1000);

        function loadAbsen() {
            $.ajax({
                url: "<?= base_url('pembiasaan/loadRekapSiswa') ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $('#foto-awal').html("<img src='<?= base_url('assets/foto_siswa/') ?>" + response.awal.foto + "' alt='" + response.awal.nama + "' class='w-full h-full object-cover rounded-lg shadow-md border-4 border-white'>");
                        $('#foto-akhir').html("<img src='<?= base_url('assets/foto_siswa/') ?>" + response.akhir.foto + "' alt='" + response.akhir.nama + "' class='w-full h-full object-cover rounded-lg shadow-md border-4 border-white'>");
                        $('#nama-awal').text(response.awal.nama)
                        $('#nama-akhir').text(response.akhir.nama)
                        $('#kelas-awal').text('Kelas ' + response.awal.k_formal + ' ' + response.awal.jurusan + ' ' + response.awal.r_formal)
                        $('#kelas-akhir').text('Kelas ' + response.akhir.k_formal + ' ' + response.akhir.jurusan + ' ' + response.akhir.r_formal)
                    } else {
                        alert("Gagal memuat data siswa");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Terjadi error: " + error);
                }
            });

        }
    </script>
</body>

</html>