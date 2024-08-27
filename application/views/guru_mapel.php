      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Master Data
                  <small>Data Guru Mapel</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-folder"></i> Home</a></li>
                  <li class="active">Master Data</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">

              <div class="box">
                  <div class="box-header">
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
                                              <th>NAMA GURU</th>
                                              <th>MAPEL</th>
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
                                                  <td><?= $row->nama_guru ?></td>
                                                  <td><?= $row->kode . '. ' . $row->nama_mapel ?></td>
                                                  <td><button class="btn btn-danger btn-xs" onclick="window.location='<?= base_url('master/delgurumapel/' . $row->id_guma) ?>' ">Del</button></td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>

                              </div>
                          </div>
                          <div class="col-md-4">
                              <?= form_open('master/addGuruMapel') ?>
                              <div class="form-group">
                                  <label for="">Nama Guru</label>
                                  <select name="guru" id="" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih guru- </option>
                                      <?php foreach ($guru->result() as $gr) : ?>
                                          <option value="<?= $gr->kode_guru ?>"><?= $gr->nama_guru ?></option>
                                      <?php endforeach ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="">Pilih Mapel</label>
                                  <select name="mapel" id="" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih mapel- </option>
                                      <?php foreach ($mapel->result() as $gr) : ?>
                                          <option value="<?= $gr->kode_mapel ?>"><?= $gr->nama_mapel ?></option>
                                      <?php endforeach ?>
                                  </select>
                              </div><!-- /.form group -->

                              <div class="form-group">
                                  <label for="">Kode Urut</label>
                                  <input type="text" class="form-control" name="kode" required>
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
              $(".select2").select2();
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