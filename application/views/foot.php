<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2023/2024 <a href="http://smk-dwk.sch.id">SMK DWK</a>.</strong> All rights reserved.
</footer>


</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?= base_url('assets/') ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?= base_url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>

<script src="<?= base_url('assets/') ?>plugins/select2/select2.full.min.js"></script>

<!-- Sparkline -->
<script src="<?= base_url('assets/') ?>plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/') ?>plugins/knob/jquery.knob.js"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url('assets/') ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url('assets/') ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url('assets/') ?>plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/') ?>plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/') ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('assets/') ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>

<!-- FLOT CHARTS -->
<script src="<?= base_url('assets/') ?>plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?= base_url('assets/') ?>plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?= base_url('assets/') ?>plugins/flot/jquery.flot.pie.min.js"></script>

<script src="<?= base_url('assets/'); ?>sw/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/'); ?>sw/my-notif.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var loadingOverlay = document.getElementById("loading-overlay");

        // Fungsi untuk menampilkan loading
        function showLoading() {
            loadingOverlay.style.display = "flex";
        }

        // Fungsi untuk menyembunyikan loading
        function hideLoading() {
            loadingOverlay.style.display = "none";
        }

        // Menambahkan event listener untuk mengatur tampilan loading saat halaman sedang dimuat
        window.addEventListener("beforeunload", function() {
            showLoading();
        });

        // Menambahkan event listener untuk menyembunyikan loading setelah halaman selesai dimuat
        window.addEventListener("load", function() {
            hideLoading();
        });
    });
</script>

</body>

</html>