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
    </style>
</head>

<body class="bg-gradient-primary" style="
 
">

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
                                        <h1 class="h2 text-gray-900 mb-4">Sign In!</h1>
                                    </div>

                                    <form action="<?php echo site_url('Auth/ProcessSignIn') ?>" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username"
                                                name="username" placeholder="Enter Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="password"
                                                placeholder="Password">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>

                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="<?php echo site_url('Auth/Register') ?>">Create an
                                            Account!</a>
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