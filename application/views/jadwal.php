      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Master Data
                  <small>Data Jadwal Pelajaran</small>
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
                      <h3 class="box-title">Daftar Mata Pelajaran</h3>
                      <a href="<?= base_url('master/sendMapel') ?>" class="btn btn-sm btn-primary pull-right tbl-confirm" value="Jadwal hari ini akan terkirikan kepada guru mapel terkait">Kirim Jadwal (Japri)</a>
                      <a href="<?= base_url('master/sendMapelGroup') ?>" class="btn btn-sm btn-warning pull-right tbl-confirm" value="Jadwal hari ini akan terkirikan kepada guru mapel terkait">Kirim Jadwal (Group)</a>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <?= form_open('master/saveMapel') ?>
                          <div class="col-md-6">
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
                              </div>
                              <div class="form-group">
                                  <label for="">Pilih Kelas</label>
                                  <select name="kelas" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih kelas- </option>
                                      <?php foreach ($kelas->result() as $gr) : ?>
                                          <option value="<?= $gr->nm_kelas ?>"><?= $gr->nm_kelas ?></option>
                                      <?php endforeach ?>
                                  </select>
                              </div>

                              <div class="form-group">
                                  <label for="">Jam ke</label>
                                  <div class="row">
                                      <div class="col-xs-6">
                                          <input type="number" name="dari" class="form-control" placeholder="Dari Jam" required>
                                      </div>
                                      <div class="col-xs-6">
                                          <input type="number" name="sampai" class="form-control" placeholder="Sampai Jam" required>
                                      </div>
                                  </div>
                              </div>

                          </div>
                          <div class="col-md-6">
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
                                  <label for="">Nama Mapel</label>
                                  <select name="mapel" id="" class="form-control select2" style="width: 100%;" required>
                                      <option value=""> -pilih mapel- </option>
                                      <?php foreach ($mapel->result() as $gr) : ?>
                                          <option value="<?= $gr->kode_mapel ?>"><?= $gr->nama_mapel ?></option>
                                      <?php endforeach ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                              </div>
                          </div>
                          <?= form_close() ?>
                      </div>
                      <hr>
                      <div class="table-responsive">
                          <table id="" class="table table-bordered  table-hover">
                              <thead>
                                  <tr>
                                      <th>NO</th>
                                      <!-- <th>HARI</th> -->
                                      <th>KELAS</th>
                                      <th>JAM</th>
                                      <th>MAPEL</th>
                                      <th>GURU</th>
                                      <th>#</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">SABTU</th>
                                  </tr>
                                  <?php
                                    $noSaturday = 1;
                                    $jumSaturday = 1;
                                    foreach ($Saturday->result() as $rowSaturday) {

                                        if ($jumSaturday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowSaturday->jumlah . '">' . $noSaturday . '</td>';
                                            echo '<td rowspan="' . $rowSaturday->jumlah . '">' . $rowSaturday->kelas . '</td>';
                                            $jumSaturday = $rowSaturday->jumlah;
                                            $noSaturday++;
                                        } else {
                                            $jumSaturday = $jumSaturday - 1;
                                        }
                                        echo '<td>' . $rowSaturday->jam_dari . ' - ' . $rowSaturday->jam_sampai . '</td>';
                                        echo '<td>' . $rowSaturday->nama_mapel . '</td>';
                                        echo '<td>' . $rowSaturday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowSaturday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowSaturday->id_jadwal . ' data-hari=' . $rowSaturday->hari . ' data-dari=' . $rowSaturday->jam_dari . ' data-sampai=' . $rowSaturday->jam_sampai . ' data-guru=' . $rowSaturday->guru . ' data-mapel=' . $rowSaturday->mapel . ' data-kelas=' . $rowSaturday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                  <tr>
                                      <th colspan="6" class="text-center"></th>
                                  </tr>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">AHAD</th>
                                  </tr>
                                  <?php
                                    $noSunday = 1;
                                    $jumSunday = 1;
                                    foreach ($Sunday->result() as $rowSunday) {

                                        if ($jumSunday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowSunday->jumlah . '">' . $noSunday . '</td>';
                                            echo '<td rowspan="' . $rowSunday->jumlah . '">' . $rowSunday->kelas . '</td>';
                                            $jumSunday = $rowSunday->jumlah;
                                            $noSunday++;
                                        } else {
                                            $jumSunday = $jumSunday - 1;
                                        }
                                        echo '<td>' . $rowSunday->jam_dari . ' - ' . $rowSunday->jam_sampai . '</td>';
                                        echo '<td>' . $rowSunday->nama_mapel . '</td>';
                                        echo '<td>' . $rowSunday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowSunday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowSunday->id_jadwal . ' data-hari=' . $rowSunday->hari . ' data-dari=' . $rowSunday->jam_dari . ' data-sampai=' . $rowSunday->jam_sampai . ' data-guru=' . $rowSunday->guru . ' data-mapel=' . $rowSunday->mapel . ' data-kelas=' . $rowSunday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                  <tr>
                                      <th colspan="6" class="text-center"></th>
                                  </tr>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">SENIN</th>
                                  </tr>
                                  <?php
                                    $noMonday = 1;
                                    $jumMonday = 1;
                                    foreach ($Monday->result() as $rowMonday) {

                                        if ($jumMonday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowMonday->jumlah . '">' . $noMonday . '</td>';
                                            echo '<td rowspan="' . $rowMonday->jumlah . '">' . $rowMonday->kelas . '</td>';
                                            $jumMonday = $rowMonday->jumlah;
                                            $noMonday++;
                                        } else {
                                            $jumMonday = $jumMonday - 1;
                                        }
                                        echo '<td>' . $rowMonday->jam_dari . ' - ' . $rowMonday->jam_sampai . '</td>';
                                        echo '<td>' . $rowMonday->nama_mapel . '</td>';
                                        echo '<td>' . $rowMonday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowMonday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowMonday->id_jadwal . ' data-hari=' . $rowMonday->hari . ' data-dari=' . $rowMonday->jam_dari . ' data-sampai=' . $rowMonday->jam_sampai . ' data-guru=' . $rowMonday->guru . ' data-mapel=' . $rowMonday->mapel . ' data-kelas=' . $rowMonday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>

                                  <tr>
                                      <th colspan="6" class="text-center"></th>
                                  </tr>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">SELASA</th>
                                  </tr>
                                  <?php
                                    $noTuesday = 1;
                                    $jumTuesday = 1;
                                    foreach ($Tuesday->result() as $rowTuesday) {

                                        if ($jumTuesday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowTuesday->jumlah . '">' . $noTuesday . '</td>';
                                            echo '<td rowspan="' . $rowTuesday->jumlah . '">' . $rowTuesday->kelas . '</td>';
                                            $jumTuesday = $rowTuesday->jumlah;
                                            $noTuesday++;
                                        } else {
                                            $jumTuesday = $jumTuesday - 1;
                                        }
                                        echo '<td>' . $rowTuesday->jam_dari . ' - ' . $rowTuesday->jam_sampai . '</td>';
                                        echo '<td>' . $rowTuesday->nama_mapel . '</td>';
                                        echo '<td>' . $rowTuesday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowTuesday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowTuesday->id_jadwal . ' data-hari=' . $rowTuesday->hari . ' data-dari=' . $rowTuesday->jam_dari . ' data-sampai=' . $rowTuesday->jam_sampai . ' data-guru=' . $rowTuesday->guru . ' data-mapel=' . $rowTuesday->mapel . ' data-kelas=' . $rowTuesday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>

                                  <tr>
                                      <th colspan="6" class="text-center"></th>
                                  </tr>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">RABU</th>
                                  </tr>
                                  <?php
                                    $noWednesday = 1;
                                    $jumWednesday = 1;
                                    foreach ($Wednesday->result() as $rowWednesday) {

                                        if ($jumWednesday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowWednesday->jumlah . '">' . $noWednesday . '</td>';
                                            echo '<td rowspan="' . $rowWednesday->jumlah . '">' . $rowWednesday->kelas . '</td>';
                                            $jumWednesday = $rowWednesday->jumlah;
                                            $noWednesday++;
                                        } else {
                                            $jumWednesday = $jumWednesday - 1;
                                        }
                                        echo '<td>' . $rowWednesday->jam_dari . ' - ' . $rowWednesday->jam_sampai . '</td>';
                                        echo '<td>' . $rowWednesday->nama_mapel . '</td>';
                                        echo '<td>' . $rowWednesday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowWednesday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowWednesday->id_jadwal . ' data-hari=' . $rowWednesday->hari . ' data-dari=' . $rowWednesday->jam_dari . ' data-sampai=' . $rowWednesday->jam_sampai . ' data-guru=' . $rowWednesday->guru . ' data-mapel=' . $rowWednesday->mapel . ' data-kelas=' . $rowWednesday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>

                                  <tr>
                                      <th colspan="6" class="text-center"></th>
                                  </tr>
                                  <tr>
                                      <th colspan="6" class="text-center" style="background-color: #ECF0F5;">KAMIS</th>
                                  </tr>
                                  <?php
                                    $noThursday = 1;
                                    $jumThursday = 1;
                                    foreach ($Thursday->result() as $rowThursday) {

                                        if ($jumThursday <= 1) {
                                            echo '<tr>';
                                            echo '<td align="center" rowspan="' .  $rowThursday->jumlah . '">' . $noThursday . '</td>';
                                            echo '<td rowspan="' . $rowThursday->jumlah . '">' . $rowThursday->kelas . '</td>';
                                            $jumThursday = $rowThursday->jumlah;
                                            $noThursday++;
                                        } else {
                                            $jumThursday = $jumThursday - 1;
                                        }
                                        echo '<td>' . $rowThursday->jam_dari . ' - ' . $rowThursday->jam_sampai . '</td>';
                                        echo '<td>' . $rowThursday->nama_mapel . '</td>';
                                        echo '<td>' . $rowThursday->nama_guru . '</td>';
                                        echo '<td><a href=' . base_url('master/hapusJadwal/') . $rowThursday->id_jadwal . ' class="btn btn-xs btn-danger tbl-hapus">Hapus</a> <button class="btn btn-warning btn-xs btn-edit" data-idjadwal=' . $rowThursday->id_jadwal . ' data-hari=' . $rowThursday->hari . ' data-dari=' . $rowThursday->jam_dari . ' data-sampai=' . $rowThursday->jam_sampai . ' data-guru=' . $rowThursday->guru . ' data-mapel=' . $rowThursday->mapel . ' data-kelas=' . $rowThursday->kelas . '>edit</button></td>';
                                        echo '</tr>';
                                    }
                                    ?>

                              </tbody>
                          </table>


                      </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->

          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <div class="modal fade" id="edit-modal">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Update Absen Guru</h4>
                  </div>
                  <?= form_open('master/updateMapel') ?>
                  <input type="hidden" name="idjadwal" id="idjadwal-data">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="">Hari</label>
                          <!-- <input type="text" class="form-control" name="hari" id="hari-data" readonly> -->
                          <select name="hari" id="hari-data" class="form-control select2" style="width: 100%;" required>
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
                      </div>
                      <div class="form-group">
                          <label for="">Kelas</label>
                          <input type="text" class="form-control" name="kelas" id="kelas-data" readonly>
                      </div>

                      <div class="form-group">
                          <label for="">Jam ke</label>
                          <div class="row">
                              <div class="col-xs-6">
                                  <input type="number" name="dari" id="dari-data" class="form-control" placeholder="Dari Jam" required>
                              </div>
                              <div class="col-xs-6">
                                  <input type="number" name="sampai" id="sampai-data" class="form-control" placeholder="Sampai Jam" required>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="">Nama Guru</label>
                          <select name="guru" id="guru-data" class="form-control select2" style="width: 100%;" required>
                              <option value=""> -pilih guru- </option>
                              <?php foreach ($guru->result() as $gr) : ?>
                                  <option value="<?= $gr->kode_guru ?>"><?= $gr->nama_guru ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="">Nama Mapel</label>
                          <select name="mapel" id="mapel-data" class="form-control select2" style="width: 100%;" required>
                              <option value=""> -pilih mapel- </option>
                              <?php foreach ($mapel->result() as $gr) : ?>
                                  <option value="<?= $gr->kode_mapel ?>"><?= $gr->nama_mapel ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                      </div>
                  </div>
                  <?= form_close() ?>
              </div>
          </div>
      </div>

      <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

      <script>
          $(document).ready(function() {
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

              $('.btn-edit').on('click', function() {
                  var idjadwal = $(this).data('idjadwal');
                  var hari = $(this).data('hari');
                  var dari = $(this).data('dari');
                  var sampai = $(this).data('sampai');
                  var guru = $(this).data('guru');
                  var mapel = $(this).data('mapel');
                  var kelas = $(this).data('kelas');

                  $('#idjadwal-data').val(idjadwal);
                  $('#hari-data').val(hari).change();
                  $('#dari-data').val(dari);
                  $('#sampai-data').val(sampai);
                  $('#kelas-data').val(kelas);
                  $('#guru-data').val(guru).change();
                  $('#mapel-data').val(mapel).change();

                  $('#edit-modal').modal('show');
              })
          });
      </script>