<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BiShare Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() ?>assets/css/sb-admin-2.css" rel="stylesheet">
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

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>


                                    <form action="<?php echo site_url('Auth/ProcessRegister') ?>" method="post">
                                        <div class="form-group row">
                                            <input type="text" name="nama" class="form-control form-control-user"
                                                placeholder="Nama" required>

                                        </div>
                                        <div class="form-group row">
                                            <input type="text" name="email" class="form-control form-control-user"
                                                placeholder="Email" required>

                                        </div>
                                        <div class="form-group row">
                                            <select name='jeniskelamin' class=" form-control form-select"
                                                aria-label="Jenis Kelamin" required>
                                                <option selected value="">Jenis Kelamin</option>
                                                <option value="m">Laki-laki</option>
                                                <option value="f">Wanita</option>

                                            </select>

                                        </div>
                                        <div class="form-group row">
                                            <input type="text" name="nohp" class="form-control form-control-user"
                                                placeholder="No HP" required>

                                        </div>
                                        <div class="form-group row">
                                            <input type="date" name="tanggallahir"
                                                class="form-control form-control-user" placeholder="Tanggal Lahir">

                                        </div>
                                        <div class="form-group row">
                                            <input type="username" name="username"
                                                class="form-control form-control-user" placeholder="Username" required>

                                        </div>
                                        <div class="form-group row">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" placeholder="Password" required>

                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center text-danger">
                                        <?php echo $error ?>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo site_url('Auth/SignIn') ?>">Sign In!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url() ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url() ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url() ?>assets/js/sb-admin-2.min.js"></script>

</body>

</html>