<!-- Content Wrapper. Contains page content -->
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Absensi
            <small>Data Absensi Guru</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-th"></i> Home</a></li>
            <li class="active">Absensi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title text-primary">Input Absensi Pembiasaan Guru || <?= translateDay(date('l'), 'id') . ', ' . date('d-M-Y') ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= form_open('pembiasaan/saveApelGuru') ?>
                        <div class="table-responsive">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA</th>
                                        <th>Ket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $nou = 1;
                                    foreach ($data as $row) :
                                    ?>
                                        <input type="hidden" name="data[<?= $no ?>][kode_guru]" value="<?= $row->kode_guru ?>">
                                        <tr>
                                            <td><?= $nou++ ?></td>
                                            <td><?= $row->nama_guru ?></td>
                                            <td>
                                                <label class="custom-radio">
                                                    <input type="radio" name="data[<?= $no ?>][ket]" value="hadir" checked="checked">
                                                    <span class="custom-radio-label success">H</span>
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
                                    endforeach ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Absensi</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable();
        $("#example2").DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
        });
    });
</script>
<script>


</script>