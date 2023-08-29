    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/all.css">

    <style>
        /* Gaya umum */
        .custom-radio {
            display: inline-block;
            margin-right: 2px;
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
        <table id="example1" class="table table-bordered table-striped table-sm">
            <tbody>
                <?php
                $no = 1;
                foreach ($listdata->result() as $row) :
                ?>
                    <tr>
                        <td>
                            <?= $row->nama ?><br>
                        </td>
                        <td>
                            <input type="hidden" name="data[<?= $no ?>][nis]" value="<?= $row->nis ?>">
                            <!--  -->
                            <label class="custom-radio ">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="hadir" checked>
                                <span class="custom-radio-label success">H</span>
                            </label>
                            <label class="custom-radio ">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="izin">
                                <span class="custom-radio-label warning">S</span>
                            </label>
                            <label class="custom-radio ">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="sakit">
                                <span class="custom-radio-label primary">I</span>
                            </label>
                            <label class="custom-radio ">
                                <input type="radio" name="data[<?= $no ?>][ket]" value="alpha">
                                <span class="custom-radio-label danger">A</span>
                            </label>
                        </td>
                    </tr>
                <?php
                    $no++;
                endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <!-- iCheck 1.0.1 -->
    <script src="<?= base_url('assets/') ?>plugins/iCheck/icheck.min.js"></script>
    <script>
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    </script>