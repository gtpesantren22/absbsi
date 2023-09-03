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
                      <h3 class="box-title text-primary">Jadwal saya hari ini : <?= translateDay(date('l'), 'id') . ', ' . date('d/m/Y H:i') ?></h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">

                      <?= form_open('guru/save_multiple_data') ?>
                      <div class="form-group">
                          <label for="">Nama Guru</label>
                          <input type="text" class="form-control" name="guru" value="<?= $user ?>" readonly>
                      </div>
                      <div class="form-group">
                          <label for="">Pilih Kelas</label>
                          <select name="kelas" id="selectDppk" class="form-control select2" style="width: 100%;" required>
                              <option value=""> -pilih kelas- </option>
                              <?php foreach ($kelas->result() as $gr) : ?>
                                  <option value="<?= $gr->kelas ?>"><?= $gr->kelas ?></option>
                              <?php endforeach ?>
                          </select>
                      </div>
                      <br>
                      <div id="tabelData">
                          <!-- Hasil dari permintaan Ajax akan dimuat di sini -->
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

      <script>
          function showLoadingIndicator() {
              document.getElementById('loading-indicator').style.display = 'block';
          }

          // Menyembunyikan indikator loading setelah proses Ajax selesai
          function hideLoadingIndicator() {
              document.getElementById('loading-indicator').style.display = 'none';
          }

          $(document).ready(function() {
              $('#selectDppk').change(function() {
                  showLoadingIndicator()
                  var dppk = $(this).val();

                  $.ajax({
                      url: '<?= base_url('guru/cariKelas'); ?>',
                      type: 'POST',
                      data: {
                          dppk: dppk
                      },
                      success: function(response) {
                          $('#tabelData').html(response);
                          hideLoadingIndicator()
                      }
                  });
              });

              $('#checkboxControl').change(function() {
                  if (this.checked) {
                      $('#checkboxTarget').prop('checked', true);
                  } else {
                      $('#checkboxTarget').prop('checked', false);
                  }
              });
          });
      </script>