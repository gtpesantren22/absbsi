     <?php $this->load->view('head'); ?>
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
                     <h3 class="box-title text-primary">Absensi Jam Mengajar Guru <br> <?= translateDay($hari, 'id') . ', ' . $tanggal ?></h3>
                     <button class="btn btn-sm btn-warning pull-right" onclick="window.location='<?= base_url('mengajar') ?>'">Kembali</button>
                     <button class="btn btn-sm btn-success pull-right" id="btn-refresh"><i class="fa fa-refresh"></i></button>
                 </div>
                 <!-- /.box-header -->
                 <div class="box-body">
                     <div class="row">
                         <div class="col-12 col-md-12 col-sm-12">

                             <div class="table-responsive">
                                 <table id="" class="table table-bordered table-sm table-striped">
                                     <thead>
                                         <tr>
                                             <th colspan="2">Nama</th>
                                             <th>#</th>
                                             <th>1</th>
                                             <th>2</th>
                                             <th>3</th>
                                             <th>4</th>
                                             <th>5</th>
                                             <th>6</th>
                                             <th>7</th>
                                             <th>8</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $no = 1;
                                            $hariini = $tanggal;
                                            foreach ($data as $row) :
                                                $guru = $row['guru'];
                                                $cek1 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 1 ")->row();
                                                $cek2 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 2 ")->row();
                                                $cek3 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 3 ")->row();
                                                $cek4 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 4 ")->row();
                                                $cek5 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 5 ")->row();
                                                $cek6 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 6 ")->row();
                                                $cek6 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 6 ")->row();
                                                $cek7 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 7 ")->row();
                                                $cek8 = $this->db->query("SELECT * FROM mengajar WHERE guru = '$guru' AND tanggal = '$hariini' AND jam = 8 ")->row();
                                            ?>
                                             <tr>
                                                 <td><a class="text-danger del-guru" data-kode_guru="<?= $row['guru'] ?>" data-nama_guru="<?= $row['nama_guru'] ?>"><i class="fa fa-trash"></i></a></td>
                                                 <td><a id="show-rinci" data-guru="<?= $row['guru'] ?>" href="#"><?= $row['nama_guru'] ?></a></td>
                                                 <td>
                                                     <input type="checkbox" name="hadir" class="hobiCheckbox" <?= $row['hadir'] == 1 ? 'checked' : '' ?> value="<?= $guru ?>">
                                                 </td>
                                                 <th <?= in_array(1, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek1 ? $cek1->ket : '' ?></th>
                                                 <th <?= in_array(2, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek2 ? $cek2->ket : '' ?></th>
                                                 <th <?= in_array(3, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek3 ? $cek3->ket : '' ?></th>
                                                 <th <?= in_array(4, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek4 ? $cek4->ket : '' ?></th>
                                                 <th <?= in_array(5, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek5 ? $cek5->ket : '' ?></th>
                                                 <th <?= in_array(6, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek6 ? $cek6->ket : '' ?></th>
                                                 <th <?= in_array(7, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek7 ? $cek7->ket : '' ?></th>
                                                 <th <?= in_array(8, $row['jam'])  ? "style='background-color: orange;'" : '' ?>><?= $cek8 ? $cek8->ket : '' ?></th>
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
     <?php $this->load->view('foot'); ?>
     <!-- <script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
     <script>
         $(document).on('click', '#show-rinci', function(event) {

             $('#edit-modal').modal('show')
             var guru = $(this).data('guru');

             //   Kirim permintaan AJAX
             $.ajax({
                 url: '<?= base_url('mengajar/cekGuru') ?>',
                 method: 'POST',
                 data: {
                     guru: guru,
                     tanggal: '<?= $tanggal ?>',
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

         $('.del-guru').on('click', function(e) {
             e.preventDefault();
             var kode_guru = $(this).data('kode_guru');
             var nama_guru = $(this).data('nama_guru');

             Swal.fire({
                 title: 'Yakin ?',
                 html: '<b>' + nama_guru + '</b> akan dihapus untuk hari ini',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Hapus Data!',

             }).then((result) => {
                 if (result.value) {
                     $.ajax({
                         url: '<?= base_url('mengajar/delKehadiranGuru') ?>',
                         method: 'POST',
                         data: {
                             kode_guru: kode_guru,
                             tanggal: '<?= $tanggal ?>',
                         },
                         dataType: 'json',
                         success: function(response) {
                             window.location.reload();
                         },
                         error: function(xhr, status, error) {
                             console.error('Terjadi kesalahan:', error);
                         }
                     });
                 }
             });
         });

         $('#btn-refresh').on('click', function(e) {
             e.preventDefault();

             Swal.fire({
                 title: 'Yakin ?',
                 text: 'Semua data guru akan diperbarui',
                 icon: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Load Data!',

             }).then((result) => {
                 if (result.value) {
                     Swal.fire("Proses data.....");
                     $.ajax({
                         url: '<?= base_url('mengajar/refresh') ?>',
                         method: 'POST',
                         data: {
                             tanggal: '<?= $tanggal ?>',
                         },
                         dataType: 'json',
                         success: function(response) {
                             window.location.reload();
                         },
                         error: function(xhr, status, error) {
                             console.error('Terjadi kesalahan:', error);
                         }
                     });
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
                     status: checked ? '1' : '0',
                     tanggal: '<?= $tanggal ?>',
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