      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Profile
                  <small>Control panel</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-user"></i> Home</a></li>
                  <li class="active">Profile</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">
              <!-- Small boxes (Stat box) -->

              <div class="row">
                  <div class="col-md-6">

                      <!-- Profile Image -->
                      <div class="box box-primary">
                          <div class="box-body box-profile">
                              <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/') ?>dist/img/user2-160x160.jpg" alt="User profile picture">
                              <h3 class="profile-username text-center">Foto profile saya</h3>
                              <center>
                                  <button class="btn btn-primary btn-sm text-center" data-toggle="modal" data-target="#basicModal">Ganti Foto Profile</button>
                              </center>

                          </div><!-- /.box-body -->
                      </div><!-- /.box -->

                  </div><!-- /.col -->

              </div><!-- /.row -->


          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Upload Foto Profile</h4>
                  </div>
                  <?= form_open_multipart('guru/uploadFoto') ?>
                  <div class="modal-body">
                      <div class="form-gorup">
                          <label for="">Pilih Foto</label>
                          <input type="file" name="foto" class="form-control" required>
                          <small class="text-danger">- Foto yang diupload berupa JPG/PNG</small><br>
                          <small class="text-danger">- Usahakan menggunakan foto berbentuk PERSEGI agar hasil nya lebih pas</small>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Upload Foto</button>
                  </div>
                  <?= form_close() ?>
              </div>
          </div>
      </div>