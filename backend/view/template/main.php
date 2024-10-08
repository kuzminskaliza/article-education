<?php

/* @var string $title */
/* @var string $header */
/* @var string $content */
/* @var string $vendor_url */


?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $vendor_url; ?>plugins/fontawesome-free/css/all.min.css">
    <title><?= $title ?></title>
</head>
<body>
<header>
    <h1><?= $header ?></h1>
</header>
<section>
    <?= $content ?>
</section>
<footer>
    <p>Copyright &copy; <?= date('Y') ?></p>
</footer>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard 2</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= $vendor_url; ?>plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= $vendor_url; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $vendor_url; ?>dist/css/adminlte.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="<?= $vendor_url; ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
             width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="<?= $vendor_url; ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="pages/examples/projects.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Projects</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/project-add.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Project Add</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/project-edit.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Project Edit</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pages/examples/project-detail.html" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Project Detail</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?= $vendor_url; ?>plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?= $vendor_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="<?= $vendor_url; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= $vendor_url; ?>dist/js/adminlte.js"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="<?= $vendor_url; ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="<?= $vendor_url; ?>plugins/raphael/raphael.min.js"></script>
        <script src="<?= $vendor_url; ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
        <script src="<?= $vendor_url; ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
        <!-- ChartJS -->
        <script src="<?= $vendor_url; ?>plugins/chart.js/Chart.min.js"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="<?= $vendor_url; ?>dist/js/demo.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?= $vendor_url; ?>dist/js/pages/dashboard2.js"></script>
</body>
</html>


