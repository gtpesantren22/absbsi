    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/all.css">

    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <tbody>
                <?php
                $no = 1;
                foreach ($listdata->result() as $row) :
                ?>
                    <tr>
                        <td><?= $row->nama ?></td>
                        <td>
                            <label>
                                <input type="hidden" name="data[<?= $no ?>][nis]" value="<?= $row->nis ?>">
                                <input type="radio" name="data[<?= $no ?>][ket]" class="flat-red" value="hadir" checked> Hadir <br>
                                <input type="radio" name="data[<?= $no ?>][ket]" class="flat-red" value="sakit"> Sakit <br>
                                <input type="radio" name="data[<?= $no ?>][ket]" class="flat-red" value="izin"> Izin <br>
                                <input type="radio" name="data[<?= $no ?>][ket]" class="flat-red" value="alpha"> Alpha
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