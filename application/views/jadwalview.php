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
                                $sql = $this->db->query("SELECT * FROM jadwal WHERE hari = '$hari' AND kelas = '$kelas' ORDER BY jam_dari ASC")->result();
                                foreach ($sql as $jdl) :
                                    $jmlJam = ($jdl->jam_sampai - $jdl->jam_dari) + 1;
                                    $dtjadwal = $this->db->query("SELECT * FROM guru_mapel WHERE guru = '$jdl->guru' AND mapel = '$jdl->mapel' ")->row();
                                    $guruData = $this->db->query("SELECT * FROM guru WHERE kode_guru = '$jdl->guru' ")->row();
                                    for ($rw = 1; $rw <= $jmlJam; $rw++) {
                                ?>
                                        <td class="text-center" style="color: black; background-color: <?= $guruData->warna ?>;">
                                            <a class="btn-edit" href="#" data-idjadwal="<?= $jdl->id_jadwal ?>" data-hari="<?= $jdl->hari ?>" data-dari="<?= $jdl->jam_dari ?>" data-sampai="<?= $jdl->jam_sampai ?>" data-guru="<?= $jdl->guru ?>" data-mapel="<?= $jdl->mapel ?>" data-kelas="<?= $jdl->kelas ?>"><?= $dtjadwal ? (int)$dtjadwal->guru . $dtjadwal->kode : '' ?></a>
                                        </td>
                                <?php }
                                endforeach; ?>

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