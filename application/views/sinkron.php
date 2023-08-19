      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Santri
                  <small>Sinkronisasi Data Santri</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-refresh"></i> Home</a></li>
                  <li class="active">Santri</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">

              <div class="box">
                  <div class="box-header">

                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <center>
                          <h4 class="text-primary">Jumlah Data Siswa dari Database : <?= $dataTtl->num_rows() ?></h4>
                          <h4 class="text-danger">Jumlah Data Siswa dari Server Pusat : <?= $jmlPusat ?></h4>
                          <hr>
                          <a href="<?= base_url('welcome/sincr') ?>" class="btn btn-success tbl-confirm" value="Data akan disinkronkan dengan data dari server pusat">Sinkron Data</a>
                      </center>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->

          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>