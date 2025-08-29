      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Data Absensi Mengajar Guru</small>
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
                      <h3 class="box-title text-primary">Rekap Absensi Jam Mengajar Guru</h3>
                      <button class="btn btn-sm btn-primary pull-right" onclick="window.location='<?= base_url('mengajar/rekap') ?>'"><i class="fa fa-arrow-left"></i> Kembali</button>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12 col-sm-12">
                              <form action="<?= base_url('mengajar/saveJam') ?>" method="post">
                                  <div class="table-responsive">
                                      <table id="" class="table table-bordered table-striped table-hover">
                                          <thead>
                                              <tr>
                                                  <th>NO</th>
                                                  <th>Bulan</th>
                                                  <th>Nama Guru</th>
                                                  <th>Jumlah Wajib Hadir</th>
                                                  <th>Jam Wajib Mengajar</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php
                                                $nou = 1;
                                                $no = 1;
                                                foreach ($data as $row) :
                                                ?>
                                                  <input type="hidden" name="data[<?= $no ?>][id]" value="<?= $row->id ?>">
                                                  <tr>
                                                      <td><?= $nou++ ?></td>
                                                      <td><?= bulan($dtrekap->bulan) ?></td>
                                                      <td><?= $row->nama_guru ?></td>
                                                      <td><input type="number" class="form-control" name="data[<?= $no ?>][jam]" value="<?= $row->jam_wajib ?>"></td>
                                                      <td><input type="number" class="form-control" name="data[<?= $no ?>][hadir]" value="<?= $row->hadir_wajib ?>"></td>
                                                  </tr>
                                              <?php
                                                    $no++;
                                                endforeach ?>
                                          </tbody>
                                      </table>
                                  </div>
                                  <button class="btn btn-success">Simpan Data</button>
                              </form>
                              <hr>
                              <h3 class="text-center">Rekap Kehadiran dan Jam Mengajar Guru</h3>
                              <b class="mb-2">Rekap : <?= tanggal_indo($dtrekap->dari) . ' - ' . tanggal_indo($dtrekap->sampai) ?></b>
                              <div class="table-responsive">
                                  <table id="" class="table table-bordered table-striped table-hover">
                                      <thead>
                                          <tr class="text-center">
                                              <th rowspan="3">NO</th>
                                              <th rowspan="3">NAMA</th>
                                              <th colspan="8">PROSENTASE KEHADIRAN MENGAJAR</th>
                                              <th colspan="8">PROSENTASE KEHADIRAN SEKOLAH</th>
                                              <th rowspan="3">TOTAL</th>
                                          </tr>
                                          <tr class="text-center">
                                              <th rowspan="2">Jam Efektif</th>
                                              <th rowspan="2">Jml Hadir</th>
                                              <th colspan="5">Tidak Hadir</th>
                                              <th rowspan="2">Prosentase</th>
                                              <th rowspan="2">Hari Efektif</th>
                                              <th rowspan="2">Jml Hadir</th>
                                              <th colspan="5">Tidak Hadir</th>
                                              <th rowspan="2">Prosentase</th>
                                          </tr>
                                          <tr>
                                              <th>S</th>
                                              <th>I</th>
                                              <th>Cuti</th>
                                              <th>A</th>
                                              <th>TOTAL</th>
                                              <th>S</th>
                                              <th>I</th>
                                              <th>Cuti</th>
                                              <th>A</th>
                                              <th>TOTAL</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $nou = 1;
                                            foreach ($datas as $row) :
                                            ?>

                                              <tr>
                                                  <td><?= $nou++ ?></td>
                                                  <td><?= $row['nama'] ?></td>
                                                  <td><?= $row['jam_wajib'] ?></td>
                                                  <td><?= $row['jam_hadir'] ?></td>
                                                  <td><?= $row['jam_sakit'] ?></td>
                                                  <td><?= $row['jam_izin'] ?></td>
                                                  <td><?= $row['jam_cuti'] ?></td>
                                                  <td><?= $row['jam_alpha'] ?></td>
                                                  <td><?= $row['jam_th'] ?></td>
                                                  <td><?= $row['jam_prsn'] ?>%</td>
                                                  <!-- Hadir -->
                                                  <td><?= $row['hadir_wajib'] ?></td>
                                                  <td><?= $row['hadir_hadir'] ?></td>
                                                  <td></td>
                                                  <td><?= $row['hadir_izin'] ?></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><?= $row['hadir_prsn'] ?>%</td>
                                                  <td><?= ($row['jam_prsn'] + $row['hadir_prsn']) / 2 ?>%</td>
                                              </tr>
                                          <?php
                                            endforeach ?>
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

      <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Buat Rekap Absensi</h4>
                  </div>
                  <form action="<?= base_url('mengajar/addRekap') ?>" method="post">
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="">Bulan</label>
                              <select name="bulan" id="" class="form-control" required>
                                  <?php for ($b = 1; $b <= 12; $b++): ?>
                                      <option value="<?= $b ?>"><?= bulan($b) ?></option>
                                  <?php endfor ?>
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Dari Tanggal</label>
                              <input type="date" class="form-control" name="dari" required>
                          </div>
                          <div class="form-group">
                              <label for="">Sampai Tanggal</label>
                              <input type="date" class="form-control" name="sampai" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                  </form>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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
      </script>