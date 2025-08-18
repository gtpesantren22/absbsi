    <!-- iCheck for checkboxes and radio inputs -->

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
            background-color: #DD4B39;
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

        .custom-radio input:checked+.custom-radio-label.primary {
            background-color: #3C8DBC;
            color: white;
            border: 2px solid #000;
            /* Warna biru */
        }

        .custom-radio input:checked+.custom-radio-label.warning {
            background-color: #F39C12;
            color: white;
            border: 2px solid #000;
            /* Warna biru */
        }
    </style>
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped table-hover table-sm">
            <tbody>
                <input type="hidden" name="guru" value="<?= $jadwal->guru ?>">
                <input type="hidden" name="mapel" value="<?= $jadwal->mapel ?>">
                <input type="hidden" name="kelas" value="<?= $jadwal->kelas ?>">
                <input type="hidden" name="dari" value="<?= $jadwal->jam_dari ?>">
                <input type="hidden" name="sampai" value="<?= $jadwal->jam_sampai ?>">
                <tr>
                    <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Mapel : <?= $mapel->nama_mapel ?></b></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Jam ke : <?= $jadwal->jam_dari . ' - ' . $jadwal->jam_sampai ?></b></td>
                </tr>
                <?php
                $no = 1;
                foreach ($listdata->result() as $row) :
                ?>
                    <tr>
                        <td><?= $row->nama ?></td>
                        <td>
                            <input type="hidden" name="data[<?= $no ?>][nis]" value="<?= $row->nis ?>">
                            <!--  -->
                            <label class="custom-radio">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="hadir" checked="checked">
                                <span class="custom-radio-label success">H</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="sakit">
                                <span class="custom-radio-label warning">S</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="izin">
                                <span class="custom-radio-label primary">I</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="alpha">
                                <span class="custom-radio-label danger">A</span>
                            </label>
                        </td>
                    </tr>
                <?php
                    $no++;
                endforeach; ?>
            </tbody>
        </table>
    </div>