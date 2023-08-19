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
                      <h3 class="box-title text-primary">Data Absensi</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-8">
                              <div class="table-responsive">
                                  <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>MINGGU</th>
                                              <th>BULAN</th>
                                              <th>TAHUN</th>
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
                                                  <td><?= $row->minggu ?></td>
                                                  <td><?= $bln[$row->bulan] ?></td>
                                                  <td><?= $row->tahun ?></td>
                                                  <td>
                                                      <a href="<?= base_url('absensi/detail/') . $row->id_absen ?>" class="btn btn-xs btn-warning">Detail</a>
                                                      <a href="<?= base_url('absensi/delAbsen/') . $row->id_absen ?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin akan dihapus ?')">Hapus</a>
                                                  </td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <div class="col-md-4">
                              <?= form_open('absensi/buat') ?>
                              <div class="form-group">
                                  <label for="">Minggu</label>
                                  <input type="number" name="minggu" class="form-control" required>
                              </div>
                              <div class="form-group">
                                  <label>Rentang Tanggal</label>
                                  <div class="input-group">
                                      <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control pull-right" id="reservation" name="rentang">
                                  </div><!-- /.input group -->
                              </div><!-- /.form group -->
                              <div class="form-group">
                                  <label for="">Bulan</label>
                                  <select name="bulan" class="form-control" required>
                                      <?php for ($i = 1; $i <= 12; $i++) : ?>
                                          <option value="<?= $i ?>"><?= $bln[$i] ?></option>
                                      <?php endfor; ?>
                                  </select>
                              </div>

                              <div class="form-group">
                                  <label for="">Tahun</label>
                                  <input type="text" name="tahun" class="form-control" required readonly value="2023/2024">
                              </div>
                              <div class="form-group">
                                  <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                              </div>
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
              $('#reservation').daterangepicker();
          });
      </script>