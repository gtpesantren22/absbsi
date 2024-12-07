      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Data Absensi Siswa</small>
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
                      <h3 class="box-title text-primary">Absensi Pembiasaan Siswa</h3>
                      <!-- <button class="btn btn-sm btn-primary pull-right" onclick="window.location='<?= base_url('pembiasaan/input') ?>'">Buat Absen</button> -->
                      <div class="btn-group pull-right">
                          <button type="button" class="btn btn-primary">Proses Absensi</button>
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                              <li><a href="<?= base_url('pembiasaan/input') ?>">Absen by HP Camera</a></li>
                              <li><a href="<?= base_url('pembiasaan/input2') ?>">Absen by QR Scanner</a></li>
                          </ul>
                      </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="table-responsive">
                                  <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>TANGGAL</th>
                                              <th>JUMLAH</th>
                                              <th>#</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($data as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $no++ ?></td>
                                                  <td><?= $row->tanggal ?></td>
                                                  <td><?= $row->jumlah ?></td>
                                                  <td>
                                                      <a href="<?= base_url('pembiasaan/hapus/') . $row->id ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a>
                                                  </td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
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