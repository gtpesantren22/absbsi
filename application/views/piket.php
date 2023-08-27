      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Master Data
                  <small>Data Guru Piket</small>
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
                                              <th>Hari</th>
                                              <th>NAMA GURU</th>
                                              <th>TEMPAT</th>
                                              <th>#</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($mapel as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $no++ ?></td>
                                                  <td><?= translateDay($row->hari, 'id') ?></td>
                                                  <td><?= $row->nama_guru ?></td>
                                                  <td>SMK <?= $row->tempat ?></td>
                                                  <td><a href="<?= base_url('master/delPiket/' . $row->id_piket) ?>" class="btn btn-xs btn-danger tombol-hapus">Hapus</a></td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>

                              </div>
                          </div>
                          <div class="col-md-4">
                              <?= form_open('master/addPiket') ?>
                              <div class="form-group">
                                  <label for="">Pilih Hari</label>
                                  <select name="hari" id="" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih hari- </option>
                                      <?php
                                        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

                                        foreach ($days as $index => $day) {
                                            echo "<option value=\"$day\"";

                                            // Periksa apakah nama hari saat ini sesuai dengan $day dalam bahasa Inggris
                                            if (date('l') === $day) {
                                                echo "";
                                            }

                                            echo ">" . translateDay($day, 'id') . "</option>";
                                        }
                                        ?>
                                  </select>
                              </div><!-- /.form group -->
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
                                  <label for="">Tempat Piket</label>
                                  <select name="tempat" id="" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih tempat- </option>
                                      <option value="putra"> SMK PUTRA </option>
                                      <option value="putri"> SMK PUTRI </option>
                                  </select>
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