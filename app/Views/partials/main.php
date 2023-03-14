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
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url()?>/public/assets/images/logo.png" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url()?>/public/assets/images/logo-iderm4u.png" alt="" height="35">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
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


                    <!-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <span class="badge bg-danger rounded-pill">1</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifikasi </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small" key="t-view-all"> Lihat Semua</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="bx bx-cart"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mt-0 mb-1" key="t-your-order">Pembelian Produk Diterima</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1" key="t-grammer">Pasien A Membeli Produk dari Anda, Lihat ></p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                        key="t-min-ago">3 min ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                        More..</span>
                                </a>
                            </div>
                        </div>
                    </div> -->

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url()?>/public/assets/images/users/<?= $user['user_photo'] ?>"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1" key="t-henry"><?= $user['user_name'] ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span key="t-profile">Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="" id=logout><i
                                    class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                    key="t-logout">Keluar</span></a>
                        </div>
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
                        <li class="menu-title" key="t-menu">Default</li>

                        <li>
                            <a href="<?= site_url('dashboard') ?>" class="waves-effect">
                                <i class="bx bx-home-circle"></i>
                                <span key="t-dashboards">Dashboard</span>
                            </a>
                        </li>
                        <?php if ($user['user_active'] == 't' && ($user['user_role'] == '2020' || $user['user_role'] == '2022' || $user['user_role'] == '5050' || $user['user_role'] == '5055')) { ?>
                        <li class="menu-title" key="t-menu">Menu Faskes</li>

                        <li>
                            <a href="<?= site_url('patient') ?>" class="waves-effect">
                                <i class="bx bx-user-circle"></i>
                                <span key="t-patient">Pasien</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-user-detail"></i>
                                <span key="t-kunjungan">Kunjungan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('medical') ?>" key="t-medical">Data</a></li>
                                <li><a href="<?= site_url('medicalformadd') ?>" key="t-medicalformadd">Tambah</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('medicalrefer') ?>" class="waves-effect">
                                <i class="bx bx-task"></i>
                                <span key="t-medicalrefer">Rujukan</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('invoice') ?>" class="waves-effect">
                                <i class="bx bx-receipt"></i>
                                <span key="t-invoice">Invoice</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('order') ?>" class="waves-effect">
                                <i class="bx bx-shopping-bag"></i>
                                <span key="t-order">Produk Order (PO)</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('appointment') ?>" class="waves-effect">
                                <i class="bx bx-calendar"></i>
                                <span key="t-appointment">Appointment</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('treatment') ?>" class="waves-effect">
                                <i class="bx bx-diamond"></i>
                                <span key="t-treatment">Treatment</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('product') ?>" class="waves-effect">
                                <i class="bx bx-package"></i>
                                <span key="t-product">Produk</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('promotion') ?>" class="waves-effect">
                                <i class="bx bx-pin"></i>
                                <span key="t-promotion">Promosi</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('employee') ?>" class="waves-effect">
                                <i class="bx bxs-user-badge"></i>
                                <span key="t-employee">Pegawai</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if ($user['user_active'] == 't' && $user['user_role'] == '1011') { ?>
                        <li class="menu-title" key="t-menu">Menu Pasien</li>

                        <li>
                            <a href="appointmentformadd" class="waves-effect">
                                <i class="bx bx-calendar"></i>
                                <span key="t-kunjungan">Buat Appointment</span>
                            </a>
                        </li>

                        <li>
                            <a href="orderformadd" class="waves-effect">
                                <i class="bx bx-shopping-bag"></i>
                                <span key="t-kunjungan">Beli Produk</span>
                            </a>
                        </li>
                        

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bxs-user-detail"></i>
                                <span key="t-kunjungan">Riwayat Kunjungan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="index.html" key="t-default">Semua</a></li>
                                <li><a href="dashboard-saas.html" key="t-saas">Pemeriksaan</a></li>
                                <li><a href="dashboard-crypto.html" key="t-crypto">Pembelian</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-task"></i>
                                <span key="t-rujukan">Rujukan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="index.html" key="t-default">Kunjungan</a></li>
                                <li><a href="dashboard-saas.html" key="t-saas">Data</a></li>
                                <li><a href="dashboard-crypto.html" key="t-crypto">Teledermatologi</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="invoice" class="waves-effect">
                                <i class="bx bx-receipt"></i>
                                <span key="t-kunjungan">Invoice</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if ($user['user_active'] == 't' && $user['user_role'] == '7077') { ?>
                        <li class="menu-title" key="t-menu">Menu Super</li>

                        <li>
                            <a href="faskes" class="waves-effect">
                                <i class="bx bx bx-clinic"></i>
                                <span key="t-faskes">Faskes</span>
                            </a>
                        </li>

                        <li>
                            <a href="account" class="waves-effect">
                                <i class="bx bxs-user-badge"></i>
                                <span key="t-account">User Akun</span>
                            </a>
                        </li>

                        <li>
                            <a href="fotomanage" class="waves-effect">
                                <i class="bx bxs-file-image"></i>
                                <span key="t-fotomanage">File Foto</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-slider"></i>
                                <span key="t-pengaturan">Pengaturan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="index.html" key="t-default">Landing Page</a></li>
                                <li><a href="dashboard-saas.html" key="t-saas">Term & Service</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="visitor" class="waves-effect">
                                <i class="bx bx-user-pin"></i>
                                <span key="t-visitor">Visitor</span>
                            </a>
                        </li>

                        <li>
                            <a href="log" class="waves-effect">
                                <i class="bx bx-history"></i>
                                <span key="t-log">Log</span>
                            </a>
                        </li>
                        <?php } ?>
        
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