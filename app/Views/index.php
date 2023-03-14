<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>iDerm4U - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Teledermatologi iDerm4U" name="description" />
    <meta content="iDerm4U" name="iDerm4U" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>/public/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="index.html" class="d-block auth-logo">
                            <img src="<?= base_url()?>/public/assets/images/logo-iderm4u.png" alt="" height="90" class="auth-logo-dark mx-auto">
                            <img src="<?= base_url()?>/public/assets/images/logo-iderm4u.png" alt="" height="90" class="auth-logo-light mx-auto">
                        </a>
                        <div class="row justify-content-center mt-5">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="<?= base_url()?>/public/assets/images/coming-soon.svg" alt="" class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-5">iDerm4u in Development</h4>
                        <p class="text-muted">Kami segera menjumpai anda <i class="bx bx-wink-smile
"></i></p>

                        <div class="row justify-content-center mt-5">
                            <div class="col-md-8">
                                <div data-countdown="2023/04/1" class="counter-number"></div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url()?>/public/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url()?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url()?>/public/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url()?>/public/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url()?>/public/assets/libs/node-waves/waves.min.js"></script>

    <!-- Plugins js-->
    <script src="<?= base_url()?>/public/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

    <!-- Countdown js -->
    <script src="<?= base_url()?>/public/assets/js/pages/coming-soon.init.js"></script>

    <script src="<?= base_url()?>/public/assets/js/app.js"></script>

</body>

</html>