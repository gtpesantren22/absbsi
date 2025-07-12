<div class="row">
    <?php
    $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
    for ($i = 0; $i < count($days); $i++) {
        $hariIni = $days[$i];
    ?>
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th colspan="9" class="text-center"><?= translateDay($days[$i], 'id') ?></th>
                        </tr>
                        <tr>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">1</th>
                            <th class="text-center">2</th>
                            <th class="text-center">3</th>
                            <th class="text-center">4</th>
                            <th class="text-center">5</th>
                            <th class="text-center">6</th>
                            <th class="text-center">7</th>
                            <th class="text-center">8</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dataHari = $this->db->query("SELECT * FROM jadwal WHERE  hari = '$hariIni' GROUP BY kelas ORDER BY kelas ASC");
                        foreach ($dataHari->result() as $kls):
                            $kelas = $kls->kelas;
                            $hari = $kls->hari;
                        ?>
                            <tr>
                                <td><?= $kelas ?></td>
                                <?php
                                $totalJam = 8; // Misal jam pelajaran 1 s.d. 8
                                $jadwalMap = [];

                                // Ambil semua jadwal untuk hari dan kelas yang dimaksud
                                $sql = $this->db->query("SELECT * FROM jadwal WHERE hari = '$hari' AND kelas = '$kelas' ORDER BY jam_dari ASC")->result();

                                // Masukkan semua data ke array per jam
                                foreach ($sql as $j) {
                                    for ($i = $j->jam_dari; $i <= $j->jam_sampai; $i++) {
                                        $jadwalMap[$i][] = $j; // ← bisa lebih dari satu jadwal per jam
                                    }
                                }

                                // Cetak baris untuk jam 1-8
                                for ($jam = 1; $jam <= $totalJam; $jam++) {
                                    echo '<td style="color: black;">';

                                    if (isset($jadwalMap[$jam])) {
                                        foreach ($jadwalMap[$jam] as $j) {
                                            $dtjadwal = $this->db->query("SELECT * FROM guru_mapel WHERE guru = '$j->guru' AND mapel = '$j->mapel'")->row();
                                            $guruData = $this->db->query("SELECT * FROM guru WHERE kode_guru = '$j->guru'")->row();
                                            $warna = $guruData->warna ?? '#eee';

                                            echo '<div class="text-center" style="background:' . $warna . '; margin-bottom: 2px; padding: 1px; border-radius: 4px;">';
                                            echo '<a class="btn-edit" href="#" 
                                                    data-idjadwal="' . $j->id_jadwal . '" 
                                                    data-hari="' . $j->hari . '" 
                                                    data-dari="' . $j->jam_dari . '" 
                                                    data-sampai="' . $j->jam_sampai . '" 
                                                    data-guru="' . $j->guru . '" 
                                                    data-mapel="' . $j->mapel . '" 
                                                    data-kelas="' . $j->kelas . '">';
                                            echo $dtjadwal ? (int)$dtjadwal->guru . $dtjadwal->kode : $j->guru;
                                            echo '</a>';
                                            echo '</div>';
                                        }
                                    }

                                    echo '</td>';
                                }
                                ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $('.btn-edit').on('click', function() {
        var idjadwal = $(this).data('idjadwal');
        var hari = $(this).data('hari');
        var dari = $(this).data('dari');
        var sampai = $(this).data('sampai');
        var guru = $(this).data('guru');
        var mapel = $(this).data('mapel');
        var kelas = $(this).data('kelas');

        $('#idjadwal-data').val(idjadwal);
        $('#idjadwal-data2').val(idjadwal);
        $('#hari-data').val(hari).change();
        $('#dari-data').val(dari);
        $('#sampai-data').val(sampai);
        $('#kelas-data').val(kelas);
        $('#guru-data').val(guru).change();
        $('#mapel-data').val(mapel).change();

        $('#edit-modal').modal('show');
    })

    $('#guru-data').on('change', function() {
        var guru = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('master/getgurumapel') ?>",
            dataType: 'json',
            data: {
                guru: guru
            },
            success: function(data) {
                $('#selected-mapel2').empty();
                $('#selected-mapel2').append('<option value="">-pilih mapel-</option>');
                $.each(data, function(key, value) {
                    $('#selected-mapel2').append('<option value="' + value.mapel + '">' + value.kode + '. ' + value.nama_mapel + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error); // Debug jika
            }
        });
    })
</script>