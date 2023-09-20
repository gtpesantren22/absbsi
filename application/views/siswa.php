      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Santri
                  <small>Data Santri Putra</small>
              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Dashboard</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">

              <div class="box">
                  <div class="box-header">
                      <h3 class="box-title text-primary">Data di Database : <?= $dataTtl->num_rows() ?></h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>NO</th>
                                      <th>NIS</th>
                                      <th>NAMA</th>
                                      <th>ALAMAT</th>
                                      <th>KELAS</th>
                                      <th>NO. HP</th>
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
                                          <td><?= $row->desa . ' - ' . $row->kec . ' - ' . $row->kab ?></td>
                                          <td><?= $row->k_formal . ' ' . $row->jurusan . ' ' . $row->r_formal ?></td>
                                          <td>
                                              <?= $row->hp ?>
                                              <?php
                                                $kirim = cek_nomor($row->hp);
                                                $hasil = json_decode($kirim, true);

                                                echo $hasil['code'];
                                                ?>
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
      </script>