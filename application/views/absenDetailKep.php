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
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">

                      <div class="row">
                          <div class="col-md-6">
                              <!-- Donut chart -->
                              <div class="box box-primary">
                                  <div class="box-header with-border">
                                      <i class="fa fa-bar-chart-o"></i>
                                      <h3 class="box-title">Rekap Absensi Total</h3>
                                      <div class="box-tools pull-right">
                                          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                      </div>
                                  </div>
                                  <div class="box-body">
                                      <div id="chart45" style="height: 200px;"></div>
                                  </div><!-- /.box-body-->
                              </div><!-- /.box -->
                          </div>
                          <div class="col-md-12">
                              <!-- Donut chart -->
                              <div class="box box-primary">

                                  <div class="box-body">
                                      <div id="chartKelas" style="height: 200px;"></div>
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

          $(function() {
              var options = {
                  series: [{
                      name: 'Tidak Absen',
                      data: [<?php foreach ($kelas->result() as $kls) {
                                    $kelasOk = $kls->nm_kelas;
                                    $kl = explode('-', $kls->nm_kelas);

                                    $jmlSiswa = $this->db->query("SELECT * FROM tb_santri WHERE aktif = 'Y' AND k_formal = '$kl[0]' AND jurusan = '$kl[1]' AND r_formal = '$kl[2]' AND t_formal = '$kl[3]' ")->num_rows();
                                    $totalAbsen = ($hari * 8) * $jmlSiswa;

                                    $sakit = $this->db->query("SELECT SUM(sakit) as sakit FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $izin = $this->db->query("SELECT SUM(izin) as izin FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $alpha = $this->db->query("SELECT SUM(alpha) as alpha FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $hadir = $this->db->query("SELECT SUM((sampai-dari)+1) as hadir FROM harian WHERE alpha = 0 AND izin = 0 AND sakit = 0 AND kelas = '$kelasOk' AND tanggal BETWEEN '$dariOk' AND '$sampaiOk' ")->row();
                                    $tidak = $totalAbsen - ($sakit->sakit + $izin->izin + $alpha->alpha + $hadir->hadir);

                                    echo round(($tidak / $totalAbsen) * 100, 1) . ',';
                                } ?>]
                  }, {
                      name: 'Hadir',
                      data: [<?php foreach ($kelas->result() as $kls) {
                                    $kelasOk = $kls->nm_kelas;
                                    $kl = explode('-', $kls->nm_kelas);

                                    $jmlSiswa = $this->db->query("SELECT * FROM tb_santri WHERE aktif = 'Y' AND k_formal = '$kl[0]' AND jurusan = '$kl[1]' AND r_formal = '$kl[2]' AND t_formal = '$kl[3]' ")->num_rows();
                                    $totalAbsen = ($hari * 8) * $jmlSiswa;

                                    $sakit = $this->db->query("SELECT SUM(sakit) as sakit FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $izin = $this->db->query("SELECT SUM(izin) as izin FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $alpha = $this->db->query("SELECT SUM(alpha) as alpha FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();
                                    $hadir = $this->db->query("SELECT SUM((sampai-dari)+1) as hadir FROM harian WHERE alpha = 0 AND izin = 0 AND sakit = 0 AND kelas = '$kelasOk' AND tanggal BETWEEN '$dariOk' AND '$sampaiOk' ")->row();

                                    echo round(($hadir->hadir / $totalAbsen) * 100, 1) . ',';
                                } ?>]
                  }, {
                      name: 'Sakit',
                      data: [<?php foreach ($kelas->result() as $kls) {
                                    $kelasOk = $kls->nm_kelas;
                                    $kl = explode('-', $kls->nm_kelas);

                                    $jmlSiswa = $this->db->query("SELECT * FROM tb_santri WHERE aktif = 'Y' AND k_formal = '$kl[0]' AND jurusan = '$kl[1]' AND r_formal = '$kl[2]' AND t_formal = '$kl[3]' ")->num_rows();
                                    $totalAbsen = ($hari * 8) * $jmlSiswa;

                                    $sakit = $this->db->query("SELECT SUM(sakit) as sakit FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();

                                    echo round(($sakit->sakit / $totalAbsen) * 100, 1) . ',';
                                } ?>]
                  }, {
                      name: 'Alpha',
                      data: [<?php foreach ($kelas->result() as $kls) {
                                    $kelasOk = $kls->nm_kelas;
                                    $kl = explode('-', $kls->nm_kelas);

                                    $jmlSiswa = $this->db->query("SELECT * FROM tb_santri WHERE aktif = 'Y' AND k_formal = '$kl[0]' AND jurusan = '$kl[1]' AND r_formal = '$kl[2]' AND t_formal = '$kl[3]' ")->num_rows();
                                    $totalAbsen = ($hari * 8) * $jmlSiswa;

                                    $alpha = $this->db->query("SELECT SUM(alpha) as alpha FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();

                                    echo round(($alpha->alpha / $totalAbsen) * 100, 1) . ',';
                                } ?>]
                  }, {
                      name: 'Izin',
                      data: [<?php foreach ($kelas->result() as $kls) {
                                    $kelasOk = $kls->nm_kelas;
                                    $kl = explode('-', $kls->nm_kelas);

                                    $jmlSiswa = $this->db->query("SELECT * FROM tb_santri WHERE aktif = 'Y' AND k_formal = '$kl[0]' AND jurusan = '$kl[1]' AND r_formal = '$kl[2]' AND t_formal = '$kl[3]' ")->num_rows();
                                    $totalAbsen = ($hari * 8) * $jmlSiswa;

                                    $izin = $this->db->query("SELECT SUM(izin) as izin FROM detail_absen WHERE id_absen = '$id' AND kelas = '$kelasOk' ")->row();

                                    echo round(($izin->izin / $totalAbsen) * 100, 1) . ',';
                                } ?>]
                  }],
                  chart: {
                      type: 'bar',
                      height: 350,
                      stacked: true,
                      stackType: '100%'
                  },
                  plotOptions: {
                      bar: {
                          horizontal: true,
                      },
                  },
                  stroke: {
                      width: 1,
                      colors: ['#fff']
                  },
                  title: {
                      text: 'Rekap Absensi Perkelas'
                  },
                  xaxis: {
                      categories: [<?php foreach ($kelas->result() as $kls) {
                                        $kl = explode('-', $kls->nm_kelas);
                                        echo "'" . $kl[0] . '-' . $kl[1] . '-' . $kl[2] . "'" . ',';
                                    } ?>],
                  },
                  tooltip: {
                      y: {
                          formatter: function(val) {
                              return val + "%"
                          }
                      }
                  },
                  fill: {
                      opacity: 1

                  },
                  legend: {
                      position: 'top',
                      horizontalAlign: 'left',
                      offsetX: 40
                  }
              };

              var chart = new ApexCharts(document.querySelector("#chartKelas"), options);
              chart.render();

          });
      </script>