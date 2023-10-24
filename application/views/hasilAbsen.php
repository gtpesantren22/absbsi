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
                      <h3 class="box-title text-primary">Hasil Absensi Hari ini</h3>
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
                                                  <td><?= $row->nama_mapel ?></td>
                                                  <td><?= $row->nama_guru ?></td>
                                                  <td><?= $row->dari . ' - ' . $row->sampai ?></td>
                                                  <td>
                                                      <?php if ($userData->level == 'guru' || $userData->level == 'admin') : ?>
                                                          <a href="<?= base_url('guru/hapusHarian/') . $row->kode ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a>
                                                          <a href="<?= base_url('guru/editHarian/') . $row->kode ?>" class="btn btn-xs btn-warning">Edit</a>
                                                      <?php
                                                        endif;
                                                        if ($userData->level == 'kepala' || $userData->level == 'admin') : ?>
                                                          <a href="<?= base_url('kepala/detailHarian/') . $row->kode ?>" class="btn btn-xs btn-primary">Lihat Detail</a>
                                                      <?php endif; ?>
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