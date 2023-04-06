<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>iDerm4U - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Teledermatology System (iDerm4U)" name="iDerm4U Project" />
    <meta content="Terledermatology Indonesia" name="iDerm4U" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>/public/assets/images/favicon.ico">


    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>/public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>/public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>/public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link href="<?= base_url()?>/public/assets/css/main.css" rel="stylesheet" type="text/css" />
    
    <!-- Custom Css-->
    <link href="<?= base_url()?>/public/assets/css/custom.css" rel="stylesheet" type="text/css" />

    <!-- JQuery -->
    <script src="<?= base_url()?>/public/assets/libs/jquery/jquery.min.js"></script>

    <!-- Select2 -->
    <link href="<?= base_url() ?>/public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>/public/assets/libs/select2/js/select2.min.js"></script>

    <!-- Mask Money JS - Format Input Rupiah JS-->
    <script src="<?= base_url() ?>/public/assets/js/jquery/jquery.maskMoney.min.js"></script>
    
    <!-- Bootstrap-fileinput Krajee Kratik-->
    <link href="<?= base_url()?>/public/assets/css/fileinput.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <link href="<?= base_url()?>/public/assets/css/explorer-fa6-theme.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="<?= base_url()?>/public/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url()?>/public/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?= base_url()?>/public/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="<?= base_url() ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url()?>/public/assets/images/logo.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url()?>/public/assets/images/logo-iderm4u.png" alt="" height="35">
                            </span>
                        </a>

                        <a href="<?= base_url() ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url()?>/public/assets/images/logo.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url()?>/public/assets/images/logo-iderm4u.png" alt="" height="35">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>

                <div class="d-flex">


                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url()?>/public/assets/images/users/default.png"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry">User Test</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>
        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title" key="t-menu">Test</li>
        
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <div class="main-content" id="result">
            <?= $this->renderSection('isi') ?>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © iDerm4U.
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- END layout-wrapper -->
</body>

<!-- JAVASCRIPT -->
<script src="<?= base_url()?>/public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url()?>/public/assets/libs/node-waves/waves.min.js"></script>
<!-- App js -->
<script src="<?= base_url()?>/public/assets/js/app.min.js"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Required datatable js -->
<script src="<?= base_url() ?>/public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>/public/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Select2 js -->
<script src="<?= base_url() ?>/public/assets/libs/select2/js/select2.min.js"></script>

<script>
    //Logout
    $("#logout").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Apakah anda yakin ingin keluar?",
        icon: "warning",
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Iya",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: "<?= site_url('logout') ?>",
            type: "post",
            dataType: "json",
            success: function (response) {
            Swal.fire({
                title: "Berhasil!",
                text: "Anda berhasil keluar!",
                icon: "success",
                showConfirmButton: false,
                timer: 1250,
            }).then(function () {
                window.location = response.data.link;
            });
            },
        });
        }
    });
    });
</script>

</html>