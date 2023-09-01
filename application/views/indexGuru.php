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
                              <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" alt="User profile picture">
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
                                ?>
                                  <strong><i class="fa fa-institution  margin-r-5"></i> <?= $jadwal->kelas ?></strong><br>
                                  <!-- <strong><i class="fa fa-book margin-r-5"></i> Education</strong><br> -->
                                  <p class="text-muted">
                                      <i class="fa fa-book margin-r-5"></i> <?= $mapel->nama_mapel ?> <br>
                                      <i class="fa fa-clock-o margin-r-5"></i> Jam ke <?= $jadwal->jam_dari . '-' . $jadwal->jam_sampai ?>
                                  </p>
                                  <hr>
                              <?php endforeach ?>
                              <a href="<?= base_url('guru/absenSiswa') ?>" class="btn btn-sm btn-block btn-success">Cek Jadwal Saya</a>
                          </div><!-- /.box-body -->
                      </div><!-- /.box -->
                  </div><!-- /.col -->

              </div><!-- /.row -->


          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->