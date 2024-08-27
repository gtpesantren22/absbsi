      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Master Data
                  <small>Data Guru</small>
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
                      <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>NO</th>
                                      <th>NAMA</th>
                                      <th>Colour</th>
                                      <th>#</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no = 1;
                                    foreach ($guru as $row) :
                                    ?>
                                      <tr>
                                          <td><?= $no++ ?></td>
                                          <td><?= $row->nama_guru ?></td>
                                          <td>
                                              <div style="width: 70px; height: 25px; background-color: <?= $row->warna; ?>; border: 1px solid #000;">
                                          </td>
                                          <td><button class="btn btn-xs btn-warning btn-edit" id="" data-guru-kode="<?= $row->kode_guru ?>" data-guru-nama="<?= $row->nama_guru ?>" data-guru-hp="<?= $row->no_hp ?>" data-guru-warna="<?= $row->warna ?>">Edit</button></td>
                                      </tr>
                                  <?php endforeach ?>
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
                      <h4 class="modal-title">Update Data</h4>
                  </div>
                  <?= form_open('master/updateGuru') ?>
                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="">Kode Guru</label>
                          <input type="text" class="form-control" id="kode-guru" name="kode_guru" required>
                      </div>
                      <div class="form-group">
                          <label for="">Nama Guru</label>
                          <input type="text" class="form-control" id="nama-guru" name="nama_guru" required>
                      </div>
                      <div class="form-group">
                          <label for="">No. HP</label>
                          <input type="text" class="form-control" id="hp-guru" name="no_hp" required>
                      </div>
                      <div class="form-group">
                          <label for="">Warna Code</label>
                          <input type="color" class="form-control" id="warna-guru" name="warna" required>
                      </div>
                      <div class="form-group">
                          <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                      </div>
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

          $('.btn-edit').on('click', function() {
              var guru_kode = $(this).data('guru-kode');
              var guru_nama = $(this).data('guru-nama');
              var guru_hp = $(this).data('guru-hp');
              var guru_warna = $(this).data('guru-warna');

              $('#kode-guru').val(guru_kode)
              $('#nama-guru').val(guru_nama)
              $('#hp-guru').val(guru_hp)
              $('#warna-guru').val(guru_warna)

              $('#edit-modal').modal('show')
          })
      </script>