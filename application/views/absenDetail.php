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
                      <h3 class="box-title text-primary">Detail Absensi</h3> | <h3 class="box-title text-danger"><?= 'Minggu ke : ' . $detail->row('minggu') . ' Bulan : ' . $bln[$detail->row('bulan')] . ' Tahun : ' . $detail->row('tahun') ?></h3>
                      <button onclick="window.location='<?= base_url('absensi/exportMinggu/' . $detail->row('id_absen')) ?>' " class="btn btn-sm btn-danger pull-right"><i class="fa fa-download"></i> Export to Excel</button>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-9">
                              <div class="table-responsive">
                                  <table id="example1" class="table table-bordered table-striped">
                                      <thead>
                                          <tr>
                                              <th>NO</th>
                                              <th>NIS</th>
                                              <th>NAMA</th>
                                              <th>KELAS</th>
                                              <th>S</th>
                                              <th>I</th>
                                              <th>A</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                            $no = 1;
                                            foreach ($data->result() as $row) :
                                            ?>
                                              <tr>
                                                  <td><?= $no++ ?></td>
                                                  <td><?= $row->nis ?></td>
                                                  <td><?= $row->nama ?></td>
                                                  <td><?= $row->k_formal . ' ' . $row->jurusan ?></td>
                                                  <td><?= $row->sakit ?></td>
                                                  <td><?= $row->izin ?></td>
                                                  <td><?= $row->alpha ?></td>
                                              </tr>
                                          <?php endforeach ?>
                                      </tbody>
                                  </table>
                              </div>
                          </div>

                          <div class="col-md-3 mt-3">
                              <h4>Kirim Informasi</h4>
                              <?php foreach ($kelas->result() as $kelas) : ?>
                                  <p><a href="<?= base_url('absensi/sendAbsen/' . $kelas->nm_kelas . '/' . $row->id_absen) ?>" class="btn btn-sm btn-success tbl-confirm" value="Absen akan dikimkan ke wali santri"><i class="fa fa-envelope"></i> <?= $kelas->nm_kelas ?></a></p>
                              <?php endforeach ?>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <!-- Donut chart -->
                              <div class="box box-primary">
                                  <div class="box-header with-border">
                                      <i class="fa fa-bar-chart-o"></i>
                                      <h3 class="box-title">Rekap Absensi Minggu ke <?= $detail->row('minggu') . ', ' . $bln[$detail->row('bulan')] . ' ' . $detail->row('tahun') ?></h3>
                                      <div class="box-tools pull-right">
                                          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                      </div>
                                  </div>
                                  <div class="box-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div id="chart45" style="height: 200px;"></div>
                                          </div>
                                          <div class="col-md-6">
                                              <div id="chart2" style="height: 200px;"></div>
                                          </div>
                                      </div>
                                  </div><!-- /.box-body-->
                              </div><!-- /.box -->
                          </div>
                      </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->

          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- jQuery 2.1.4 -->
      <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
      <script>
          $(function() {
              var hadir = Number(<?= $hadir ?>);
              var sakit = Number(<?= $sakit ?>);
              var izin = Number(<?= $izin ?>);
              var alpha = Number(<?= $alpha ?>);
              var tidak = Number(<?= $tidak ?>);

              var options = {
                  series: [tidak, hadir, sakit, alpha, izin],
                  chart: {
                      width: 380,
                      type: 'pie',
                  },
                  labels: ['Tidak Absen', 'Hadir', 'Sakit', 'Alpha', 'Izin'],
                  responsive: [{
                      breakpoint: 480,
                      options: {
                          chart: {
                              width: 300
                          },
                          legend: {
                              position: 'bottom'
                          }
                      }
                  }]
              };

              var chart = new ApexCharts(document.querySelector("#chart45"), options);
              chart.render();
          });
      </script>