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
                      <h3 class="box-title text-primary">Detail Absensi</h3> | <h3 class="box-title text-danger"><?= 'Minggu ke : ' . $detail->row('minggu') . ' Bulan : ' . $bln[$detail->row('bulan')] . ' Tahun : ' . $detail->row('tahun') ?></h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-9">
                              <div class="table-responsive">
                                  <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NAMA</th>
                                              <th>KELAS</th>
                                              <th>SAKIT</th>
                                              <th>IZIN</th>
                                              <th>ALPHA</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($data->result() as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $no++ ?></td>
                                                  <td><?= $row->nama ?></td>
                                                  <td><?= $row->k_formal . ' ' . $row->jurusan ?></td>
                                                  <td><?= $row->sakit ?></td>
                                                  <td><?= $row->izin ?></td>
                                                  <td><?= $row->alpha ?></td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <div class="col-md-3">
                              <h4>Kirim Informasi</h4>
                              <?php foreach ($kelas->result() as $kelas) : ?>
                                  <p><button class="btn btn-sm btn-secondary"><i class="fa fa-envelope"></i> <?= $kelas->nm_kelas ?></button></p>
                              <?php endforeach ?>
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