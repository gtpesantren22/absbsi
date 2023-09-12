      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Dashboard
                  <small>Control panel</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Dashboard</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">
              <!-- Small boxes (Stat box) -->

              <div class="row">
                  <div class="col-md-12">

                      <!-- Profile Image -->
                      <div class="box box-primary">
                          <div class="box-body box-profile">
                              <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/foto/' . $userData->foto) ?>" alt="User profile picture">
                              <h3 class="profile-username text-center">Selamat datang <br> <?= $userData->nama ?></h3>
                              <p class="text-muted text-center">Anda login sebagai <?= $userData->level ?></p>

                          </div><!-- /.box-body -->
                      </div><!-- /.box -->

                      <!-- About Me Box -->
                      <div class="box box-primary">
                          <div class="box-header with-border">
                              <h3 class="box-title">Jadwal Saya Hari ini</h3>
                          </div><!-- /.box-header -->
                          <div class="box-body">
                              <?php foreach ($jadwal->result() as $jadwal) :
                                    $mapel = $this->db->query("SELECT * FROM mapel WHERE kode_mapel = '$jadwal->mapel' ")->row();
                                    $day = date('Y-m-d');
                                    $cek = $this->db->query("SELECT * FROM harian WHERE tanggal = '$day' AND guru = '$jadwal->guru' AND mapel = '$jadwal->mapel' AND dari = '$jadwal->jam_dari' AND sampai = '$jadwal->jam_sampai' AND kelas = '$jadwal->kelas' ")->row();
                                ?>
                                  <strong><i class="fa fa-institution  margin-r-5"></i> <?= $jadwal->kelas ?></strong><br>
                                  <!-- <strong><i class="fa fa-book margin-r-5"></i> Education</strong><br> -->
                                  <p class="text-muted">
                                      <i class="fa fa-book margin-r-5"></i> <?= $mapel->nama_mapel ?> <br>
                                      <i class="fa fa-clock-o margin-r-5"></i> Jam ke <?= $jadwal->jam_dari . '-' . $jadwal->jam_sampai ?><br>
                                      <?php if ($cek) { ?>
                                          <span class="label label-success"><i class="fa fa-check-circle-o"></i> Sudah Absen</span>
                                      <?php } else { ?>
                                          <span class="label label-danger"><i class="fa fa-times"></i> Belum isi absen</span>
                                      <?php } ?>
                                  </p>
                                  <hr>
                              <?php endforeach ?>
                              <a href="<?= base_url('guru/absenSiswa') ?>" class="btn btn-sm btn-block btn-primary">Cek Jadwal Saya</a>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                  </div><!-- /.col -->

              </div><!-- /.row -->


          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->