<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Absensi
            <small>Data Absensi Santri</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-th"></i> Home</a></li>
            <li class="active">Absensi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <!-- <div class="box-header">
                <h3 class="box-title text-primary">Data Absensi</h3>
            </div> -->
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-center"><?= translateDay(date('l'), 'id') . ', ' . date('d-M-Y') ?></h4>
                        <?php if ($data->num_rows() > 0) {
                            foreach ($data->result() as $hasil) :
                        ?>
                                <div class="box box-success collapsed-box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><?= $hasil->kelas ?></h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="example1" class="table table-bordered table-striped">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        } else { ?>
                            Data tidak ada. Silahkan klik tombol berikut <br>
                            <a href="<?= base_url('absensi/generate') ?>" class="btn btn-sm btn-success btn-block tbl-confirm" value="Jadwal hari ini akan digenerate/dibuat dan tidak bisa di hapus lagi">Generate Jadwal</a>
                        <?php } ?>
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
        $('#reservation').daterangepicker();
    });
</script>