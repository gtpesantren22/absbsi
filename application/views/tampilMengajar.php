<style>
    /* Gaya umum */
    .custom-radio {
        display: inline-block;
        margin-right: 1px;
        cursor: pointer;
    }

    /* Menghilangkan tampilan default input radio */
    .custom-radio input {
        display: none;
    }

    /* Gaya label input radio */
    .custom-radio-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 23px;
        height: 23px;
        border-radius: 50%;
        border: 2px solid #ccc;
        font-size: 12px;
        background-color: #fff;
        /* Warna latar belakang default */
    }

    /* Gaya label untuk pilihan warna */
    .custom-radio input:checked+.custom-radio-label.danger {
        background-color: rgb(247, 29, 0);
        color: white;
        border: 2px solid #000;
        /* Warna merah */
    }

    .custom-radio input:checked+.custom-radio-label.success {
        background-color: #00A65A;
        color: white;
        border: 2px solid #000;
        /* Warna hijau */
    }

    .custom-radio input:checked+.custom-radio-label.warning {
        background-color: #F39C12;
        color: white;
        border: 2px solid #000;
        /* Warna biru */
    }

    .custom-radio input:checked+.custom-radio-label.primary {
        background-color: #3C8DBC;
        color: white;
        border: 2px solid #000;
        /* Warna biru */
    }

    .custom-radio input:checked+.custom-radio-label.info {
        background-color: rgb(203, 0, 243);
        color: white;
        border: 2px solid #000;
        /* Warna biru */
    }

    .custom-radio input:checked+.custom-radio-label.dark {
        background-color: rgb(32, 21, 2);
        color: white;
        border: 2px solid #000;
        /* Warna biru */
    }
</style>

<h4><b><?= $guru->nama_guru ?></b></h4>

<div class="box box-primary p-3 mb-3">
    <table class="table table-sm table-borderless">
        <?php foreach ($jadwal as $jadwal):
            $mapel = $this->db->query("SELECT * FROM mapel WHERE kode_mapel = '$jadwal->mapel' ")->row();
        ?>
            <tr>
                <th>Jam <?= $jadwal->jam_dari . '-' . $jadwal->jam_sampai ?></th>
                <th><?= $jadwal->kelas ?></th>
                <th><?= $mapel->nama_mapel ?></th>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<h4>Input Absensi</h4>
<form id="form-absensi">
    <table class="table table-sm table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Jam</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $hariini = date('Y-m-d');
            for ($i = 1; $i <= 8; $i++):
                $cek = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru->kode_guru' AND tanggal = '$hariini' AND jam = $i ")->row();
                $ket = $cek ? $cek->ket : '';
            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td>
                        <?php if (in_array($i, $jam)): ?>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'H' ? 'checked' : '' ?> value="H">
                                <span class="custom-radio-label success">H</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'S' ? 'checked' : '' ?> value="S">
                                <span class="custom-radio-label warning">S</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'S' ? 'checked' : '' ?> value="S">
                                <span class="custom-radio-label primary">I</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'A' ? 'checked' : '' ?> value="A">
                                <span class="custom-radio-label danger">A</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'T' ? 'checked' : '' ?> value="T">
                                <span class="custom-radio-label info">T</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="djam_<?= $i ?>" data-jam="<?= $i ?>" data-guru="<?= $guru->kode_guru ?>" <?= $ket == 'C' ? 'checked' : '' ?> value="C">
                                <span class="custom-radio-label dark">C</span>
                            </label>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endfor ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-sm btn-success" id="saveButton"><i class="fa fa-save"></i> Simpan</button>
</form>
<!-- <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
<script>
    $('#form-absensi').on('submit', function(e) {
        e.preventDefault();
        const formData = [];

        // Loop melalui setiap input radio yang dipilih
        $('input[type="radio"]:checked').each(function() {
            // const name = $(this).attr('name');
            const value = $(this).val(); // e.g., "Main"
            const jam = $(this).data('jam'); // e.g., "1"
            const guru = $(this).data('guru'); // e.g., "Hobi bermain"

            // Tambahkan data ke array formData
            formData.push({
                // name: name,
                value: value,
                jam: jam,
                guru: guru
            });
        });

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: '<?= site_url("mengajar/simpanJam") ?>',
            type: 'POST',
            data: {
                datas: formData
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    window.location.reload()
                } else {
                    alert('Gagal menyimpan data!');
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    });
</script>