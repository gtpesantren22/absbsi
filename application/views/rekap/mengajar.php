<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-1 text-center">Rekap Kehadiran Guru</h1>
        <h1 class="text-xl font-bold text-gray-800 mb-6 text-center">SMK Darul Lughah Wal Karomah</h1>

        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-gray-600">Tanggal: <span class="font-semibold"><?= date('d F Y', strtotime($tanggal)) ?></span></p>
                <p class="text-gray-600">Hari: <span class="font-semibold"><?= $hari ?></span></p>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th rowspan="2" class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">No</th>
                        <th rowspan="2" class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th rowspan="2" class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-700">Kehadiran</th>
                        <th colspan="4" class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-700">Absensi Mengajar
                        </th>
                    </tr>
                    <tr>
                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-700">Jam Wajib</th>
                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-700">Mengajar</th>
                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-700">%</th>
                        <th class="py-2 px-4 border-b text-center text-sm font-semibold text-gray-700">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Data Guru 1 -->
                    <?php
                    $no = 1;
                    foreach ($data as $row) :
                    ?>
                        <tr class="bg-white">
                            <td class="py-3 px-4 border-b text-sm text-gray-700"><?= $no++ ?></td>
                            <td class="py-3 px-4 border-b text-sm font-medium text-gray-800"><?= $row['nama_guru'] ?></td>
                            <td class="py-3 px-4 border-b">
                                <?php if ($row['hadir'] == 1) { ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hadir</span>
                                <?php } else { ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">izin</span>
                                <?php } ?>
                            </td>
                            <td class="py-3 px-4 border-b text-sm text-center text-gray-700"><?= $row['jam'] ?></td>
                            <td class="py-3 px-4 border-b text-sm text-center text-gray-700"><?= $row['masuk'] ?></td>
                            <td class="py-3 px-4 border-b text-sm text-center font-medium"><?= round($row['persen'], 1) ?>%</td>
                            <td class="py-3 px-4 border-b text-sm text-center text-green-600"><?= $row['alasan'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="2" class="py-3 px-4 border-t text-sm font-semibold text-gray-700 text-right">Total:</td>
                        <td class="py-3 px-4 border-t text-sm font-semibold text-gray-700 text-center"><?= round($totalkehadiran / $totalguru * 100, 1) ?>%</td>
                        <td class="py-3 px-4 border-t text-sm font-semibold text-gray-700 text-center"><?= $totaljamwajib ?></td>
                        <td class="py-3 px-4 border-t text-sm font-semibold text-gray-700 text-center"><?= $totaljammasuk ?></td>
                        <td class="py-3 px-4 border-t text-sm font-semibold text-blue-600 text-center"><?= round($totaljammasuk / $totaljamwajib * 100, 1) ?>%</td>
                        <td class="py-3 px-4 border-t text-sm font-semibold text-gray-700 text-center">-</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 text-sm text-gray-500">
            <p>Catatan: Rekap ini dihasilkan secara otomatis pada 12/08/2025 10:15:23</p>
        </div>
    </div>
</body>

</html>