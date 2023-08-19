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
                  <div class="box-header">
                      <h3 class="box-title text-primary">Data Absensi Harian</h3>
                      <button class="btn btn-sm btn-primary pull-right" onclick="window.location='<?= base_url('absensi/inputHarian') ?>'">Buat Absen</button>
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
                                              <th>KELAS</th>
                                              <th>MAPEL</th>
                                              <th>GURU</th>
                                              <th>JAM KE</th>
                                              <th>#</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($data->result() as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $no++ ?></td>
                                                  <td><?= $row->tanggal ?></td>
                                                  <td><?= $row->kelas ?></td>
                                                  <td><?= $row->mapel ?></td>
                                                  <td><?= $row->guru ?></td>
                                                  <td><?= $row->dari . ' - ' . $row->sampai ?></td>
                                                  <td><a href="<?= base_url('absensi/hapusHarian/') . $row->kode ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a></td>
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