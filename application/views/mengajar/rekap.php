      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Data Absensi Mengajar Guru</small>
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
                      <h3 class="box-title text-primary">Rekap Absensi Jam Mengajar Guru</h3>
                      <button class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus-circle"></i> Buat Rekap</button>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12 col-sm-12">
                              <div class="table-responsive">
                                  <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>Bulan</th>
                                              <th>Rentang Tanggal</th>
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
                                                  <td><?= bulan($row->bulan) ?></td>
                                                  <td><?= tanggal_indo($row->dari) . ' --- ' . tanggal_indo($row->sampai) ?></td>
                                                  <td>
                                                      <a href="<?= base_url('mengajar/cekRekap/') . $row->id ?>" class="btn btn-xs btn-warning">Edit Detail</a>
                                                      <a href="<?= base_url('mengajar/hapus/') . $row->id ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a>
                                                  </td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
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
                      <h4 class="modal-title">Buat Rekap Absensi</h4>
                  </div>
                  <form action="<?= base_url('mengajar/addRekap') ?>" method="post">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="">Bulan</label>
                              <select name="bulan" id="" class="form-control" required>
                                  <?php for ($b = 1; $b <= 12; $b++): ?>
                                      <option value="<?= $b ?>"><?= bulan($b) ?></option>
                                  <?php endfor ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Dari Tanggal</label>
                              <input type="date" class="form-control" name="dari" required>
                          </div>
                          <div class="form-group">
                              <label for="">Sampai Tanggal</label>
                              <input type="date" class="form-control" name="sampai" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                  </form>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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