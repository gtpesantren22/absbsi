      <style>
          #reader {
              width: 100%;
              max-width: 400px;
              /* Sesuaikan ukuran maksimal untuk tampilan lebih baik */
              margin: 0 auto;
              border: 2px solid #ddd;
              /* Tambahkan border untuk memperjelas */
              border-radius: 8px;
              /* Radius border agar lebih estetis */
          }

          .container {
              margin-top: 30px;
          }
      </style>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Absensi
                  <small>Data Absensi Siswa</small>
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
                      <h3 class="box-title text-primary">Input Absesn Pembiasaan Siswa || <?= translateDay(date('l'), 'id') . ', ' . date('d-M-Y') ?></h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-12">
                              <div class="text-center">
                                  <label for="cameraSelect">Pilih Kamera:</label>
                                  <select id="cameraSelect" class="form-control"></select>
                                  <div id="reader" style="width: 300px; height: 300px;"></div>
                                  <p class="text-danger"><span id="result"></span></p>
                                  <audio id="success-sound" src="<?= base_url('assets/audio/berhasil.mp3') ?>"></audio>
                                  <audio id="error-sound" src="<?= base_url('assets/audio/tidak_ada.mp3') ?>">"></audio>
                                  <audio id="warning-sound" src="<?= base_url('assets/audio/sudah.mp3') ?>">"></audio>
                              </div>
                              <div class="table-responsive">
                                  <table class="table table-sm" id="table">
                                      <tbody>
                                      </tbody>
                                  </table>
                              </div>
                              <div class="">
                                  <div id="prosens"></div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <!-- /.box -->
          </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
          $(document).ready(function() {
              loadTable()
              loadProsentase()
          });

          function loadTable() {
              $.ajax({
                  type: "POST",
                  url: "<?= base_url('pembiasaan/loadAbsen') ?>",
                  data: {
                      "tanggal": "<?= date('Y-m-d') ?>"
                  },
                  dataType: "json",
                  success: function(data) {
                      var html = '';
                      $.each(data, function(key, item) {
                          html += '<tr>';
                          html += '<td>' + item.nama + '</td>';
                          html += '<td>' + item.k_formal + '-' + item.jurusan + ' ' + item.r_formal + '</td>';
                          html += '</tr>';
                      });
                      $('#table').html(html);
                  }
              })
          }

          function loadProsentase() {
              $.ajax({
                  type: "POST",
                  url: "<?= base_url('pembiasaan/loadJumlah') ?>",
                  data: {
                      "tanggal": "<?= date('Y-m-d') ?>"
                  },
                  dataType: "json",
                  success: function(data) {
                      var html = `
                      <div class='progress-group'>
                                      <span class='progress-text'>Hadir</span>
                                      <span class='progress-number'><b>${data.hadirPrs}%</b> (${data.hadir} siswa)</span>
                                      <div class='progress sm'>
                                          <div class='progress-bar progress-bar-success' style='width: ${data.hadirPrs}%'></div>
                                      </div>
                                  </div>
                                  <div class='progress-group'>
                                      <span class='progress-text'>Terlambat</span>
                                     <span class='progress-number'><b>${data.telatPrs}%</b> (${data.telat} siswa)</span>
                                      <div class='progress sm'>
                                          <div class='progress-bar progress-bar-warning' style='width: ${data.telatPrs}%'></div>
                                      </div>
                                  </div>
                                  <div class='progress-group'>
                                      <span class='progress-text'>Belum Hadir</span>
                                      <span class='progress-number'><b>${data.belumPrs}%</b> (${data.belum} siswa)</span>
                                      <div class='progress sm'>
                                          <div class='progress-bar progress-bar-danger' style='width: ${data.belumPrs}%'></div>
                                      </div>
                                  </div>
                      `;
                      $('#prosens').html(html);
                  }
              })
          }
      </script>
      <script>
          const reader = new Html5Qrcode("reader");
          const cameraSelect = document.getElementById("cameraSelect");

          function onScanSuccess(decodedText, decodedResult) {
              // Hasil kode QR
              // Hentikan kamera setelah berhasil
              //   reader.stop().then(() => {
              //       console.log("Scanning stopped.");
              //   }).catch(err => console.error("Error stopping the scanner:", err));
              //   document.getElementById("result").textContent = '';
              $.ajax({
                  type: "POST",
                  url: "<?= base_url('pembiasaan/addAbsens') ?>",
                  data: {
                      "tanggal": "<?= date('Y-m-d') ?>",
                      "nis": decodedText
                  },
                  dataType: "json",
                  success: function(data) {
                      if (data.status == 'ok') {
                          soundToPlay = document.getElementById("success-sound");
                          loadTable()
                      } else if (data.status == 'sudah') {
                          soundToPlay = document.getElementById("warning-sound");
                          document.getElementById("result").textContent = '';
                          document.getElementById("result").textContent = 'Siswa sudah absen';
                      } else if (data.status == 'not_found') {
                          soundToPlay = document.getElementById("error-sound");
                          document.getElementById("result").textContent = '';
                          document.getElementById("result").textContent = 'Siswa tidak ditemukan';
                      } else {
                          document.getElementById("result").textContent = '';
                          document.getElementById("result").textContent = 'Simpan error';
                      }
                      soundToPlay.play().catch(err => console.error("Error playing sound:", err));
                  }
              })
          }

          function onScanError(errorMessage) {
              // Kesalahan saat scanning
              console.warn("Scan error:", errorMessage);
          }

          // Mulai kamera
          Html5Qrcode.getCameras().then(devices => {
              if (devices && devices.length) {
                  // Tambahkan opsi kamera ke dropdown
                  devices.forEach((device, index) => {
                      const option = document.createElement("option");
                      option.value = device.id;
                      option.text = device.label || `Camera ${index + 1}`;
                      cameraSelect.appendChild(option);
                  });

                  // Mulai kamera pertama secara default
                  startCamera(devices[0].id);
              } else {
                  console.error("No cameras found.");
              }
          }).catch(err => console.error("Error getting cameras:", err));

          // Fungsi untuk memulai kamera berdasarkan ID
          function startCamera(cameraId) {
              reader.start(
                  cameraId, {
                      fps: 1,
                      qrbox: 250
                  },
                  onScanSuccess,
                  onScanError
              );
          }
          // Event listener untuk mengganti kamera
          cameraSelect.addEventListener("change", (event) => {
              const selectedCameraId = event.target.value;
              reader.stop().then(() => {
                  startCamera(selectedCameraId);
              }).catch(err => console.error("Error stopping camera:", err));
          });
      </script>