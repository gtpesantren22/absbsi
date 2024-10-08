<style>
    .table-bordered {
        border: 2px solid black;
        /* Thicker border for the entire table */
    }

    .table-bordered thead,
    .table-bordered tbody,
    .table-bordered tr,
    .table-bordered th,
    .table-bordered td {
        border: 2px solid black;
        /* Thicker border for table cells */
    }

    a {
        color: inherit;
        /* Atur warna teks link sama seperti elemen induknya */
        text-decoration: none;
        /* Menghilangkan garis bawah jika diinginkan */
    }

    a:visited {
        color: inherit;
        /* Warna tetap sama setelah link diklik */
    }

    a:hover {
        color: inherit;
        /* Warna tidak berubah saat di-hover */
    }

    a:active {
        color: inherit;
        /* Warna tetap sama saat link aktif */
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Master Data
            <small>Data Jadwal Pelajaran</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-folder"></i> Home</a></li>
            <li class="active">Master Data</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Mata Pelajaran</h3>
                <a href="<?= base_url('master/sendMapel') ?>" class="btn btn-sm btn-primary pull-right tbl-confirm" value="Jadwal hari ini akan terkirikan kepada guru mapel terkait">Kirim Jadwal (Japri)</a>
                <a href="<?= base_url('master/sendMapelGroup') ?>" class="btn btn-sm btn-warning pull-right tbl-confirm" value="Jadwal hari ini akan terkirikan kepada guru mapel terkait">Kirim Jadwal (Group)</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <form action="" method="post" id="form-add">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Pilih Hari</label>
                                <select name="hari" id="" class="form-control select2" style="width: 100%;" required>
                                    <option value=""> -pilih hari- </option>
                                    <?php
                                    $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

                                    foreach ($days as $index => $day) {
                                        echo "<option value=\"$day\"";

                                        // Periksa apakah nama hari saat ini sesuai dengan $day dalam bahasa Inggris
                                        if (date('l') === $day) {
                                            echo "";
                                        }

                                        echo ">" . translateDay($day, 'id') . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih Kelas</label>
                                <select name="kelas" class="form-control select2" style="width: 100%;" required>
                                    <option value=""> -pilih kelas- </option>
                                    <?php foreach ($kelas->result() as $gr) : ?>
                                        <option value="<?= $gr->nm_kelas ?>"><?= $gr->nm_kelas ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Jam ke</label>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="number" name="dari" class="form-control" placeholder="Dari Jam" required>
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="number" name="sampai" class="form-control" placeholder="Sampai Jam" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Guru</label>
                                <select name="guru" id="selected-guru" class="form-control select2" style="width: 100%;" required>
                                    <option value=""> -pilih guru- </option>
                                    <?php foreach ($guru->result() as $gr) : ?>
                                        <option value="<?= $gr->kode_guru ?>"><?= $gr->kode_guru . ' - ' . $gr->nama_guru ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Mapel</label>
                                <select name="mapel" id="selected-mapel" class="form-control select2" style="width: 100%;" required>
                                    <option value=""> -pilih mapel- </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div id="jadwalview"></div>

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
                <h4 class="modal-title">Update Absen Guru</h4>
            </div>
            <?= form_open('master/updateMapel') ?>
            <input type="hidden" name="idjadwal" id="idjadwal-data">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Hari</label>
                    <!-- <input type="text" class="form-control" name="hari" id="hari-data" readonly> -->
                    <select name="hari" id="hari-data" class="form-control select2" style="width: 100%;" required>
                        <option value=""> -pilih hari- </option>
                        <?php
                        $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

                        foreach ($days as $index => $day) {
                            echo "<option value=\"$day\"";

                            // Periksa apakah nama hari saat ini sesuai dengan $day dalam bahasa Inggris
                            if (date('l') === $day) {
                                echo "";
                            }

                            echo ">" . translateDay($day, 'id') . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Kelas</label>
                    <input type="text" class="form-control" name="kelas" id="kelas-data" readonly>
                </div>

                <div class="form-group">
                    <label for="">Jam ke</label>
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="number" name="dari" id="dari-data" class="form-control" placeholder="Dari Jam" required>
                        </div>
                        <div class="col-xs-6">
                            <input type="number" name="sampai" id="sampai-data" class="form-control" placeholder="Sampai Jam" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Nama Guru</label>
                    <select name="guru" id="guru-data" class="form-control select2" style="width: 100%;" required>
                        <option value=""> -pilih guru- </option>
                        <?php foreach ($guru->result() as $gr) : ?>
                            <option value="<?= $gr->kode_guru ?>"><?= $gr->kode_guru . ' - ' . $gr->nama_guru ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Nama Mapel</label>
                    <select name="mapel" id="selected-mapel2" class="form-control select2" style="width: 100%;" required>
                        <option value=""> -pilih mapel- </option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                </div>
            </div>
            <?= form_close() ?>
            <div class="col-md-6">
                <div class="form-group">
                    <form action="<?= base_url('master/hapusJadwal') ?>" method="post">
                        <input type="hidden" name="idjadwal" id="idjadwal-data2">
                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i> Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        showJadwal()
        $(".select2").select2();
        $("#example1").DataTable();
        $("#example2").DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
        });

        function showJadwal() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('master/getMapel') ?>",
                // dataType: "html",
                success: function(data) {
                    $('#jadwalview').html(data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        $('#selected-guru').on('change', function() {
            var guru = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('master/getgurumapel') ?>",
                dataType: 'json',
                data: {
                    guru: guru
                },
                success: function(data) {
                    $('#selected-mapel').empty();
                    $('#selected-mapel').append('<option value="">-pilih mapel-</option>');
                    $.each(data, function(key, value) {
                        $('#selected-mapel').append('<option value="' + value.mapel + '">' + value.kode + '. ' + value.nama_mapel + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error); // Debug jika
                }
            });
        })

        $('#form-add').on('submit', function(e) {
            e.preventDefault();
            var formData = $('#form-add').serialize();

            $.ajax({
                type: 'POST',
                url: '<?= base_url('master/saveMapel'); ?>',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // alert(response);
                    if (response.status === 'success') {
                        showJadwal()
                        // alert('simpan OK')
                    } else {
                        alert('Error simpan');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Gagal menyimpan data. Kesalahan: ' + status + ' - ' + error);
                    // console.error('AJAX error:', status, error);
                }
            });
        })
    });
</script>