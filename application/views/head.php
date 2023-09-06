<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Absensi Informasi SMK DWK</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>bootstrap/css/bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/select2.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/datatables/dataTables.bootstrap.css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/all.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/iCheck/flat/blue.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>sw/sweetalert2.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #ffffff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?= base_url() ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>SMK</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>ABSENSI</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= base_url('assets/foto/' . $userData->foto) ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?= $userData->nama ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= base_url('assets/foto/' . $userData->foto) ?>" class="img-circle" alt="User Image">
                                    <p>
                                        <?= $userData->nama ?>
                                        <small><?= $userData->level ?></small>
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= base_url('guru/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= base_url('login/logout') ?>" class="btn btn-default btn-flat tbl-confirm" value="Anda akan keluar dari sistem">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?= base_url('assets/foto/' . $userData->foto) ?>" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $userData->nama ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <?php if ($userData->level == 'admin') : ?>
                        <li class="header">MAIN NAVIGATION</li>
                        <li>
                            <a href="<?= base_url() ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Master Data</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= base_url('master/guru') ?>"><i class="fa fa-circle-o"></i> Guru</a></li>
                                <li><a href="<?= base_url('master/mapel') ?>"><i class="fa fa-circle-o"></i> Mapel</a></li>
                                <li><a href="<?= base_url('master/jadwal') ?>"><i class="fa fa-circle-o"></i> Jadwal</a></li>
                                <li><a href="<?= base_url('master/piket') ?>"><i class="fa fa-circle-o"></i> Jadwal Piket</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>Data Santri</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= base_url('welcome/santri/putra') ?>"><i class="fa fa-circle-o"></i> Santri Putra</a></li>
                                <li><a href="<?= base_url('welcome/santri/putri') ?>"><i class="fa fa-circle-o"></i> Santri Putri</a></li>
                                <li><a href="<?= base_url('welcome/sinkron') ?>"><i class="fa fa-circle-o"></i> Sinkronisasi Data</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-th"></i>
                                <span>Absensi</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?= base_url('absensi') ?>"><i class="fa fa-circle-o"></i> Rekap Absensi</a></li>
                                <li><a href="<?= base_url('absensi/input') ?>"><i class="fa fa-circle-o"></i> Input Absen Siswa</a></li>
                                <li><a href="<?= base_url('absensi/inputGuru') ?>"><i class="fa fa-circle-o"></i> Input Absen Guru</a></li>
                            </ul>
                        </li>
                    <?php endif ?>
                    <li class="header">ABSENSI</li>
                    <?php if ($userData->level == 'guru') : ?>
                        <li>
                            <a href="<?= base_url('guru') ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                    <?php endif ?>
                    <li>
                        <a href="<?= base_url('guru/absenSiswa') ?>">
                            <i class="fa fa-newspaper-o"></i> <span>Absensi Siswa</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('guru/hasilAbsen') ?>">
                            <i class="fa fa-newspaper-o"></i> <span>List Absensi</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('guru/kontrolAbsen') ?>">
                            <i class="fa fa-newspaper-o"></i> <span>Kontrol Absensi</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('ok') ?>"></div>
        <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error') ?>"></div>

        <div id="loading-overlay">
            <div class="loading-spinner"></div>
        </div>