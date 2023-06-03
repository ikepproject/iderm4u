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
    <link href="<?= base_url()?>public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="<?= base_url()?>public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link href="<?= base_url()?>public/assets/css/main.css" rel="stylesheet" type="text/css" />
    
    <!-- Custom Css-->
    <link href="<?= base_url()?>public/assets/css/custom.css" rel="stylesheet" type="text/css" />

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Mask Money JS - Format Input Rupiah JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Bootstrap-fileinput Krajee Kratik-->
    <!-- <link href="<?= base_url()?>public/assets/css/fileinput.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">
    <link href="<?= base_url()?>public/assets/css/explorer-fa6-theme.css" rel="stylesheet"> -->

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.3.6/buttons.bootstrap4.min.css" integrity="sha512-LVJxdX5sTNFz8G8zJhpf8Sz/6MPnF0KiOTZHKjun7BDq5LEYJv+k1D0uNIaz3Irdu0g7biVfL6a8qkbOBjaWbg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Responsive datatable examples -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs/2.4.1/responsive.bootstrap.min.css" integrity="sha512-lC7CsBqS9byAEsS32hb1hbptYmqxRoPc+kIKOydGHfpUXHywskhQHlIQj69/S5egtqEqsEsFwjc5x5HHx/T14Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Apex Chart -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>

</head>

<body data-sidebar="dark">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>

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
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="bx bx-bell bx-tada"></i>
                            <!-- <span class="badge bg-danger rounded-pill">1</span> -->
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0" key="t-notifications"> Notifikasi </h6>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <!-- <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-10">
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
                                    </div> -->
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">Lihat semuanya..</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= base_url()?>/public/assets/images/users/<?= $user['user_photo'] ?>"
                                alt="Header Avatar">
                            <span class="d-xl-inline-block ms-1"><?= $user['user_name'] ?></span>
                            <i class="mdi mdi-chevron-down d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="account"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                <span key="t-profile">Akun</span></a>
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
                        <!-- Menu Faskes Admin/Dr Klinik, Admin/Dr RS -->
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
                        
                        <!-- Rujuk Klinik -->
                        <?php if ($user['user_active'] == 't' && ($user['user_role'] == '2020' || $user['user_role'] == '2022')) { ?>
                        <li>
                            <a href="<?= site_url('refer') ?>" class="waves-effect">
                                <i class="bx bx-task"></i>
                                <span key="t-refer">Rujukan</span>
                            </a>
                        </li>
                        <?php } ?>

                        <!-- Rujuk RS -->
                        <?php if ($user['user_active'] == 't' && ($user['user_role'] == '5050' || $user['user_role'] == '5055')) { ?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-task"></i>
                                <span key="t-refer">Rujukan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('refer-visit') ?>" key="t-refer-visit">Kunjungan</a></li>
                                <li><a href="<?= site_url('refer-storefoward') ?>" key="t-refer-storefoward">Store & Foward</a></li>
                                <li><a href="<?= site_url('refer-teledermatology') ?>" key="t-refer-teledermatology">Teledermatologi</a></li>
                            </ul>
                        </li>
                        <?php } ?>

                        <li>
                            <a href="<?= site_url('invoice') ?>" class="waves-effect">
                                <i class="bx bx-receipt"></i>
                                <span key="t-invoice">Invoice</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('order') ?>" class="waves-effect">
                                <i class="bx bx-shopping-bag"></i>
                                <span key="t-order">Produk Preorder (PO)</span>
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
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-package"></i>
                                <span key="t-refer">Produk</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('product') ?>" key="t-product">Data</a></li>
                                <li><a href="<?= site_url('product-flow') ?>" key="t-product-flow">Flow</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-bar-chart-square"></i>
                                <span key="t-refer">Ekspor Laporan</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('report-treatment') ?>" key="t-report-treatment">Treatment</a></li>
                                <li><a href="<?= site_url('report-product') ?>" key="t-report-product">Produk</a></li>
                            </ul>
                        </li>

                        <!-- <li>
                            <a href="<?= site_url('promotion') ?>" class="waves-effect">
                                <i class="bx bx-pin"></i>
                                <span key="t-promotion">Pengumuman</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('employee') ?>" class="waves-effect">
                                <i class="bx bxs-user-badge"></i>
                                <span key="t-employee">Akun</span>
                            </a>
                        </li> -->
                        <?php } ?>
                        
                        <?php if ($user['user_active'] == 't' && $user['user_role'] == '1011') { ?>
                        <li class="menu-title" key="t-menu">Menu Pasien</li>

                        <li>
                            <a href="<?= site_url('appointment-list') ?>" class="waves-effect">
                                <i class="bx bx-calendar"></i>
                                <span key="t-appointment-formadd">Appointment</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= site_url('treatment') ?>" class="waves-effect">
                                <i class="bx bx-diamond"></i>
                                <span key="t-treatment-list">Treatment</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-shopping-bag"></i>
                                <span key="t-produk">Order Produk</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?= site_url('order-product') ?>" key="t-order-product">Daftar Produk</a></li>
                                <li><a href="<?= site_url('order-cart') ?>" key="t-order-cart">Keranjang</a></li>
                                <li><a href="<?= site_url('order') ?>" key="t-order">Transaksi</a></li>

                            </ul>
                        </li>

                        <li>
                            <a href="<?= site_url('medical-record') ?>" class="waves-effect">
                                <i class="bx bxs-user-detail"></i>
                                <span key="t-medical-record">Medical Record</span>
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
                <div class="text-center">
                    <script>document.write(new Date().getFullYear())</script> © iDerm4U.
                </div>
            </div>
        </footer>
    </div>
    <!-- END layout-wrapper -->
</body>

<!-- JAVASCRIPT -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js" integrity="sha512-pax4MlgXjHEPfCwcJLQhigY7+N8rt6bVvWLFyUMuxShv170X53TRzGPmPkZmGBhk+jikR8WBM4yl7A9WMHHqvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js" integrity="sha512-o36qZrjup13zLM13tqxvZTaXMXs+5i4TL5UWaDCsmbp5qUcijtdCFuW9a/3qnHGfWzFHBAln8ODjf7AnUNebVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.2.4/simplebar.min.js" integrity="sha512-K//QeDiscFFAs5yljnbZCuoAmzv5KdtVY0W70WLQZ+BFCxi4PotspvxZwpaGJOao2l4oIQhgsHX5tHxyRe+YYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.7.6/waves.min.js" integrity="sha512-MzXgHd+o6pUd/tm8ZgPkxya3QUCiHVMQolnY3IZqhsrOWQaBfax600esAw3XbBucYB15hZLOF0sKMHsTPdjLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- App js -->
<script src="<?= base_url()?>public/assets/js/app.min.js"></script>
<!-- Sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Required datatable js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js" integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Buttons examples -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.3.6/js/dataTables.buttons.min.js" integrity="sha512-hPELv/uqaT+ZbHiKMWXHNV15N6SPTB80TXb9/idOejUqAJZmeLjITlt3Fts8RtCshL/v2kfw7mIKpZnFilDEnA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.3.6/buttons.bootstrap4.min.js" integrity="sha512-IXfjiOXWYBQMr7Vkddfu4IB6WFMS2mc+Qb39MuON+hO+L/Jyy3cdpnh1u8UJb5UlP/HWiipq0uaKo2vWbtOXcQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" integrity="sha512-XMVd28F1oH/O71fzwBnV7HucLxVwtxf26XV8P4wPk26EDxuGZ91N8bsOttmnomcCD3CS5ZMRL50H0GgOHvegtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>public/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.4.1/dataTables.responsive.min.js" integrity="sha512-9BgeOjT7sU+CPMlXJrq1Shzkx2spfWhhxEnUJ7Ab9b5bSPGCzT8DaT1a/qUfrTBtgJetJwnI81ilCJkXFZRGPA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.4.1/responsive.bootstrap4.min.js" integrity="sha512-EukuhT7pSeYUiLk5NV3uhXWMjGq4la8as5kp+2eZkq7wChPoUew8coepf1urhL8bCjSp/efanT5na06sh3pWlg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!-- PDFMake for PDF export -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

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