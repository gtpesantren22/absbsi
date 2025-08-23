      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Setting
                  <small>Sett Apel Guru</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-folder"></i> Home</a></li>
                  <li class="active">Absensi Data</li>
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
                                      <th colspan="6">Hari</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no = 1;
                                    foreach ($data as $row) :
                                        $hari_guru = explode(',', $row['daftar_hari']);
                                    ?>
                                      <tr>
                                          <td><?= $no++ ?></td>
                                          <td><?= $row['nama_guru'] ?></td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Saturday" <?= in_array('Saturday', $hari_guru) ? 'checked' : '' ?> name="hari"> Sabtu
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Sunday" <?= in_array('Sunday', $hari_guru) ? 'checked' : '' ?> name="hari"> Ahad
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Monday" <?= in_array('Monday', $hari_guru) ? 'checked' : '' ?> name="hari"> Senin
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Tuesday" <?= in_array('Tuesday', $hari_guru) ? 'checked' : '' ?> name="hari"> Selasa
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Wednesday" <?= in_array('Wednesday', $hari_guru) ? 'checked' : '' ?> name="hari"> Rabu
                                                  </label>
                                              </div>
                                          </td>
                                          <td>
                                              <div class="checkbox">
                                                  <label>
                                                      <input type="checkbox" class="haris" data-kode="<?= $row['kode_guru'] ?>" value="Thursday" <?= in_array('Thursday', $hari_guru) ? 'checked' : '' ?> name="hari"> Kamis
                                                  </label>
                                              </div>
                                          </td>
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


          $(document).on('change', '.haris', function() {
              let kode_guru = $(this).data('kode');
              let hari = $(this).val();
              let status = $(this).is(':checked') ? 1 : 0; // 1 = aktif, 0 = hapus

              $.ajax({
                  url: "<?= base_url('pembiasaan/saveApel') ?>",
                  type: "POST",
                  data: {
                      kode_guru: kode_guru,
                      hari: hari,
                      status: status
                  },
                  success: function(res) {
                      console.log("Sukses:", res);
                  },
                  error: function(xhr) {
                      console.error("Error:", xhr.responseText);
                  }
              });
              //   console.log(kode_guru + ',');
              //   console.log(hari + ',');
              //   console.log(status + ',');

          });
      </script>