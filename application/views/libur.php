      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Daftar Hari Libur</small>
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
                      <h3 class="box-title text-primary">Data Hari Libur</h3>
                      <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#modal-default">Tambah Data</button>
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
                                              <th>ACARA</th>
                                              <th>PELAKSANA</th>
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
                                                  <td><?= $row->ket ?></td>
                                                  <td><?= $row->pelaksana ?></td>
                                                  <td><a href="<?= base_url('absensi/delLibur/') . $row->id_libur ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a></td>
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

      <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Input Daftar Hari Libur</h4>
                  </div>
                  <?= form_open('absensi/liburSave') ?>
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="">Tanggal Libur</label>
                          <div class="input-group">
                              <input type="text" class="form-control datepicker" id="" name="dari" placeholder="Dari Tanggal" required>
                              <span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
                              <input type="text" class="form-control datepicker" id="" name="sampai" placeholder="Sampai Tanggal" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="">Acara</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-list"></i></span>
                              <textarea class="form-control" name="ket" placeholder="Rician Acara" required></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="">Pelaksana</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-book"></i></span>
                              <input type="text" class="form-control" name="pelaksana" placeholder="Pelaksana Acara" required>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                  <?= form_close() ?>
              </div>
          </div>
      </div>

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