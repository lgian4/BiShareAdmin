<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BiShare Admin - <?php echo $page_title;?> </title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <style>
    .bg-gradient-primary {
        background-color: #fb6c04;
        background-image: linear-gradient(180deg, #fb6c04 10%, #ca6c04 100%);
        background-size: cover;

    }

    .btn-primary {

        background-color: #fb6c04;
        border-color: #fb6c04;
    }

    a {
        color: #fb6c04;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #ca6c04;
        border-color: #ca6c04;
    }

    .btn-primary:focus,
    .btn-primary.focus {
        color: #fff;
        background-color: #ca6c04;
        border-color: #ca6c04;
        box-shadow: 0 0 0 0.2rem rgba(105, 136, 228, 0.5);
    }

    
    .btn-primary.disabled,
    .btn-primary:disabled {
        color: #fff;
        background-color: #fb6c04;
        border-color: #fb6c04
    }

    .btn-primary:not(:disabled):not(.disabled).active,
    .btn-primary:not(:disabled):not(.disabled):active,
    .show>.btn-primary.dropdown-toggle {
        color: #fff;
        background-color: #fb6c04;
        border-color: #fb6c04
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #fb6c04;
        border-color: #fb6c04
    }

    .page-item.disabled .page-link {
        color: #858796;
        pointer-events: none;
        cursor: auto;
        background-color: #fff;
        border-color: #dddfeb
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="<?php echo site_url('Auth/Index') ?>" style=" background-color: #fb6c04;">
                <div class="sidebar-brand-icon">
                    <img src="<?php echo base_url() ?>assets/img/logo-small.png" alt="Logo Small" width="100%">
                </div>
                <div class="sidebar-brand-text mx-3">BiShare <sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo site_url('Auth/Index') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php if($status== 'admin') {?>
            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('User/Index') ?>">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Toko/Index') ?>">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Toko</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url('Kategori/Index') ?>">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Kategori</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url("Produk/Produklist/") ?>">
                    <i class="fas fa-fw fa-tshirt"></i>
                    <span>Daftar Produk </span></a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url("Produk/Index/$tokoid") ?>">
                    <i class="fas fa-fw fa-tshirt"></i>
                    <span>Produk Ku</span></a>
            </li>
            <?php }?>
            <?php if($status== 'penjual') {?>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url("Produk/Index/$tokoid") ?>">
                    <i class="fas fa-fw fa-tshirt"></i>
                    <span>Produk Ku</span></a>
            </li>
            <?php }?>
            <!-- Divider -->



        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <!-- Nav Item - Messages -->


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $nama;?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo base_url() ?>assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo site_url('User/Profile') ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo site_url('Auth/SignOut') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->