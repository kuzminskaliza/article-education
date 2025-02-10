<?php

use backend\model\Admin;

/* @var string $title */
/* @var string $header */
/* @var string $content */
/* @var string $vendor_url */


?>

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
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= $vendor_url; ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= $vendor_url; ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                <a href="/index/index" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/article/index" class="brand-link">
            <img src="<?= $vendor_url; ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Article Education</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image"></div>
                <div class="info">
                    <?php $admin = Admin::getAuthAdmin(); ?>
                    <?php if ($admin) : ?>
                        <span class="d-block"><?= $admin->getName() ?></span>
                        <span class="d-block"><?= $admin->getEmail() ?></span>
                    <?php endif; ?>
                    <a href="/admin/logout" class="d-block">Logout</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/article/index" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Article</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/status/index" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Article Status</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/category/index" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Article Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/api/index" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Api Service</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content"><?= $content; ?> </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= $vendor_url; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= $vendor_url; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= $vendor_url; ?>plugins/select2/js/select2.full.min.js"></script>
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

<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    })
</script>
<style>
    .dark-mode input:-webkit-autofill,
    .dark-mode input:-webkit-autofill:focus,
    .dark-mode input:-webkit-autofill:hover,
    .dark-mode select:-webkit-autofill,
    .dark-mode select:-webkit-autofill:focus,
    .dark-mode select:-webkit-autofill:hover,
    .dark-mode textarea:-webkit-autofill,
    .dark-mode textarea:-webkit-autofill:focus,
    .dark-mode textarea:-webkit-autofill:hover {
        -webkit-text-fill-color: #000;
    }
    .select2-container--default .select2-search__field {
        color: #000 !important;
    }
</style>
</body>
</html>
