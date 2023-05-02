<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>iDerm4U - <?= $title ?></title>

    <!-- Bootstrap core CSS -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>/public/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- JQuery -->
    <script src="<?= base_url()?>/public/assets/libs/jquery/jquery.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js?render=<?= $site_key ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?= $site_key ?>', {action: 'submit'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>

</head>

<body>
    <div class="account-pages my-5 pt-sm-5">

        <div role="main" class="container">
            <?= $this->renderSection('isi') ?>
        </div>

    </div>
    
<!-- JAVASCRIPT -->
<script src="<?= base_url()?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/node-waves/waves.min.js"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- App js -->
<script src="<?= base_url()?>/public/assets/js/app.js"></script>

</body>
</html>
