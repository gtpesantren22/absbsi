      <style>
          /* Gaya untuk indikator loading */
          #loading-indicator {
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              z-index: 9999;
          }

          .spinner {
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              width: 40px;
              height: 40px;
              border-radius: 50%;
              border: 4px solid #fff;
              border-top-color: #007bff;
              animation: spin 1s infinite linear;
          }

          @keyframes spin {
              0% {
                  transform: translate(-50%, -50%) rotate(0deg);
              }

              100% {
                  transform: translate(-50%, -50%) rotate(360deg);
              }
          }
      </style>

      <div id="loading-indicator">
          <div class="spinner"></div>
      </div>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Data Absensi Santri</small>
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
                      <h3 class="box-title text-primary">Edit Jadwal saya </h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">

                      <?= form_open('guru/update_multiple_data') ?>

                      <style>
                          /* Gaya umum */
                          .custom-radio {
                              display: inline-block;
                              margin-right: 1px;
                              cursor: pointer;
                          }

                          /* Menghilangkan tampilan default input radio */
                          .custom-radio input {
                              display: none;
                          }

                          /* Gaya label input radio */
                          .custom-radio-label {
                              display: inline-flex;
                              align-items: center;
                              justify-content: center;
                              width: 23px;
                              height: 23px;
                              border-radius: 50%;
                              border: 2px solid #ccc;
                              font-size: 12px;
                              background-color: #fff;
                              /* Warna latar belakang default */
                          }

                          /* Gaya label untuk pilihan warna */
                          .custom-radio input:checked+.custom-radio-label.danger {
                              background-color: #DD4B39;
                              color: white;
                              border: 2px solid #000;
                              /* Warna merah */
                          }

                          .custom-radio input:checked+.custom-radio-label.success {
                              background-color: #00A65A;
                              color: white;
                              border: 2px solid #000;
                              /* Warna hijau */
                          }

                          .custom-radio input:checked+.custom-radio-label.primary {
                              background-color: #3C8DBC;
                              color: white;
                              border: 2px solid #000;
                              /* Warna biru */
                          }

                          .custom-radio input:checked+.custom-radio-label.warning {
                              background-color: #F39C12;
                              color: white;
                              border: 2px solid #000;
                              /* Warna biru */
                          }
                      </style>
                      <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped table-sm">
                              <tr>
                                  <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Tanggal : <?= $jadwal->tanggal ?></b></td>
                              </tr>
                              <tr>
                                  <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Mapel : <?= $jadwal->nama_mapel ?></b></td>
                              </tr>
                              <tr>
                                  <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Kelas : <?= $jadwal->kelas ?></b></td>
                              </tr>
                              <tr>
                                  <td colspan="2" style="background-color: #3C8DBC; color: #fff;"><b>Jam ke : <?= $jadwal->dari . ' - ' . $jadwal->sampai ?></b></td>
                              </tr>
                          </table>
                      </div>
                      <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped table-sm">
                              <tbody>
                                  <input type="hidden" name="guru" value="<?= $jadwal->guru ?>">
                                  <input type="hidden" name="mapel" value="<?= $jadwal->mapel ?>">
                                  <input type="hidden" name="kelas" value="<?= $jadwal->kelas ?>">
                                  <input type="hidden" name="dari" value="<?= $jadwal->dari ?>">
                                  <input type="hidden" name="sampai" value="<?= $jadwal->sampai ?>">
                                  <input type="hidden" name="kode" value="<?= $jadwal->kode ?>">
                                  <?php
                                    $no = 1;
                                    foreach ($listdata->result() as $row) :
                                        if ($row->izin == 0 && $row->sakit == 0 && $row->alpha == 0) {
                                            $ck = 'checked';
                                        } else {
                                            $ck = '';
                                        }
                                    ?>
                                      <tr>
                                          <td><?= $row->nama ?></td>
                                          <td>
                                              <input type="hidden" name="data[<?= $no ?>][id]" value="<?= $row->id_harian ?>">
                                              <input type="hidden" name="data[<?= $no ?>][nis]" value="<?= $row->nis ?>">
                                              <!--  -->
                                              <label class="custom-radio">
                                                  <input type="radio" name="data[<?= $no ?>][ket]" value="hadir" <?= $ck ?>>
                                                  <span class="custom-radio-label success">H</span>
                                              </label>
                                              <label class="custom-radio">
                                                  <input type="radio" name="data[<?= $no ?>][ket]" value="sakit" <?= $row->izin != 0 ? 'checked' : '' ?>>
                                                  <span class="custom-radio-label warning">S</span>
                                              </label>
                                              <label class="custom-radio">
                                                  <input type="radio" name="data[<?= $no ?>][ket]" value="izin" <?= $row->sakit != 0 ? 'checked' : '' ?>>
                                                  <span class="custom-radio-label primary">I</span>
                                              </label>
                                              <label class="custom-radio">
                                                  <input type="radio" name="data[<?= $no ?>][ket]" value="alpha" <?= $row->alpha != 0 ? 'checked' : '' ?>>
                                                  <span class="custom-radio-label danger">A</span>
                                              </label>
                                          </td>
                                      </tr>
                                  <?php
                                        $no++;
                                    endforeach; ?>
                              </tbody>
                          </table>
                      </div>

                      <div class="form-group">
                          <button type="submit" class="btn btn-success">Simpan Absensi</button>
                      </div>
                      <?= form_close() ?>

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
              $(".select2").select2();
          });
      </script>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>