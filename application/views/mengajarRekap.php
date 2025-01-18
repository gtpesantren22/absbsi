      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Rekap Absensi Mengajar Guru</small>
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
                      <h3 class="box-title text-primary">Rekap Mengajar Guru <br> <?= translateDay($hari, 'id') . ', ' . $tanggal ?></h3>
                      <button class="btn btn-sm btn-warning pull-right" onclick="window.location='<?= base_url('mengajar') ?>'">Kembali</button>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-xs-6">
                              <div class="small-box bg-aqua">
                                  <div class="inner">
                                      <h3><?= round($totalkehadiran / $totalguru * 100, 1) ?>%</h3>
                                  </div>
                                  <div class="icon">
                                      <i class="ion ion-bag"></i>
                                  </div>
                                  <a href="#" class="small-box-footer">Kehadiran <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="small-box bg-green">
                                  <div class="inner">
                                      <h3><?= round($totaljammasuk / $totaljamwajib * 100, 1) ?>%</h3>
                                  </div>
                                  <div class="icon">
                                      <i class="ion ion-stats-bars"></i>
                                  </div>
                                  <a href="#" class="small-box-footer">jam Mengajar <i class="fa fa-arrow-circle-right"></i></a>
                              </div>
                          </div>
                          <div class="col-12 col-sm-12 col-md-12">
                              <div class="table-responsive">
                                  <table id="" class="table table-bordered table-sm table-striped">
                                      <thead>
                                          <tr>
                                              <th rowspan="2">Nama</th>
                                              <th rowspan="2">Hadir</th>
                                              <th colspan="4">Mengajar</th>
                                          </tr>
                                          <tr>
                                              <th>W</th>
                                              <th>H</th>
                                              <th></th>
                                              <th>Ket</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($data as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $row['nama_guru'] ?></td>
                                                  <td><?= $row['hadir'] == 1 ? 100 : 0 ?>%</td>
                                                  <td><?= $row['jam'] ?></td>
                                                  <td><?= $row['masuk'] ?></td>
                                                  <td><?= round($row['persen'], 1) ?>%</td>
                                                  <td></td>
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

      <div class="modal fade" id="edit-modal">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Update Jam Mengajar Guru</h4>
                  </div>
                  <div class="modal-body">
                      <div id="hasil"></div>
                  </div>
              </div>
          </div>
      </div>

      <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <script>
          $(document).on('click', '#show-rinci', function(event) {

              $('#edit-modal').modal('show')
              var guru = $(this).data('guru');

              //   Kirim permintaan AJAX
              $.ajax({
                  url: '<?= base_url('mengajar/cekGuru') ?>',
                  method: 'POST',
                  data: {
                      guru: guru
                  },
                  dataType: 'html',
                  success: function(response) {
                      $('#hasil').empty()
                      $('#hasil').append(response)
                  },
                  error: function(xhr, status, error) {
                      console.error('Terjadi kesalahan:', error);
                  }
              });
          });
          $('.hobiCheckbox').on('click', function() {
              // Ambil nilai dan data lainnya dari checkbox
              const value = $(this).val();
              const checked = $(this).is(':checked'); // true jika dicentang

              // Proses AJAX
              $.ajax({
                  url: '<?= base_url('mengajar/kehadiran') ?>', // Ganti dengan endpoint server Anda
                  type: 'POST',
                  data: {
                      guru: value,
                      status: checked ? '1' : '0'
                  },
                  success: function(response) {
                      console.log('simpan OK');
                  },
                  error: function(xhr, status, error) {
                      console.error('Error:', error);
                  }
              });
          });
      </script>