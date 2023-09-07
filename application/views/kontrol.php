      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Kontrol Absensi
                  <small>Absensi</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-newspaper-o"></i> Home</a></li>
                  <li class="active">Absensi</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">
              <!-- Small boxes (Stat box) -->

              <div class="row">
                  <div class="col-md-12">

                      <!-- Profile Image -->
                      <div class="box box-primary">
                          <div class="box-header">
                              <h3 class="box-title">Absensi Hari ini - <?= translateDay(date('l'), 'id') . ', ' . date('d-m-Y') ?></h3>
                          </div>
                          <div class="box-body">
                              <?php if ($piket->row() || $userData->level === 'admin') { ?>
                                  <div class="table-responsive">
                                      <table class="table table-condensed table-bordered">
                                          <?php foreach ($jadwal->result() as $jadwal) :
                                                $days = date('l');
                                                $dateDays = date('Y-m-d');
                                                $jadwalKelas = $this->db->query("SELECT * FROM jadwal JOIN guru ON jadwal.guru=guru.kode_guru JOIN mapel ON jadwal.mapel=mapel.kode_mapel WHERE hari = '$days' AND kelas = '$jadwal->kelas' ORDER BY jam_dari ASC ");
                                            ?>
                                              <thead>
                                                  <tr>
                                                      <th colspan="2"><?= $jadwal->kelas ?></th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <?php foreach ($jadwalKelas->result() as $hasil) :
                                                        $queryCek = $this->db->query("SELECT * FROM harian WHERE tanggal = '$dateDays' AND kelas = '$hasil->kelas' AND guru = '$hasil->guru' AND guru = '$hasil->guru' AND dari = '$hasil->jam_dari' ");
                                                    ?>
                                                      <tr>
                                                          <td><?= $hasil->jam_dari . '-' . $hasil->jam_sampai ?></td>
                                                          <td>
                                                              <b><?= $hasil->nama_guru ?></b>
                                                              <?php if ($queryCek->row()) { ?>
                                                                  <span class="label label-success pull-right"><i class="fa fa-check"></i> sudah</span>
                                                              <?php } else { ?>
                                                                  <span class="label label-danger pull-right"><i class="fa fa-times"></i> belum</span>
                                                              <?php } ?>
                                                              <br><?= $hasil->nama_mapel ?>
                                                          </td>
                                                      </tr>
                                                  <?php endforeach ?>
                                              </tbody>
                                          <?php endforeach ?>
                                      </table>
                                  </div>
                              <?php } else {
                                    echo "Maaf. Anda bukan guru piket hari ini";
                                } ?>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->

                  </div><!-- /.col -->

              </div><!-- /.row -->


          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->