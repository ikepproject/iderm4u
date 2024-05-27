<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>iDerm4U - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Teledermatologi iDerm4U" name="Indonesia Teledermatology System" />
    <meta content="iDerm4U" name="iDerm4U" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>public/assets/images/favicon.ico">

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?= base_url()?>public/assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="<?= base_url()?>public/assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>public/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>public/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style>
        .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        padding-top: 25px;
        height: 0;
        overflow: hidden;
        }

        .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        }
    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#topnav-menu" data-bs-offset="60">

        <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
            <div class="container">
                <a class="navbar-logo" href="index.html">
                    <img src="<?= base_url()?>public/assets/images/logo-iderm4u.png" alt="" height="35" class="logo logo-dark">
                    <img src="<?= base_url()?>public/assets/images/logo-iderm4u-white.png" alt="" height="35" class="logo logo-light">
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" >
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#demo">Demo</a>
                        </li>

                    </ul>

                    <div class="my-2 ms-lg-2">
                        <a href="<?= base_url() ?>login" class="btn btn-outline-success w-xs">Sign in</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- hero section start -->
        <section class="section hero-section bg-ico-hero" id="home">
            <div class="bg-overlay bg-primary"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="text-white-50">
                            <h1 class="text-white fw-semibold mb-3 hero-title">iDerm4U - Intelligent Teledermatology System</h1>
                            <p class="font-size-14">Discover a smarter way to care for your skin. Good</p>
                            
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="https://play.google.com/store/apps/details?id=app.ikeproject.iderm4u&hl=en" target="_blank" class="btn btn-primary"> <i class="mdi mdi-google-play"></i> Available on Playstore</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- hero section end -->

        <!-- about section start -->
        <section class="section pt-4 bg-white" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">About us</div>
                            <h4>What is iDerm4U?</h4>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    
  
                        <div class="text-muted text-center">
                            <h4>The Best Teledermatology System in Indonesia</h4>
                            <p>iDerm4U is a smart skin disease diagnosing system with automatic disease Identification features developed by 4 universities, that is Institut Teknologi Sepuluh Nopember Surabaya (ITS), Universitas Airlangga Surabaya (UNAIR), Universitas Indonesia (UI), and Universitas Hasanuddin Makasar (UNHAS).</p>
                            <p class="mb-4">Interested in becoming our partner?</p>

                            <div>
                                <a href="mailto:iketuteddy.project@gmail.com" class="btn btn-outline-primary"> <i class="bx bx-mail-send"></i> iketuteddy.project@gmail.com</a>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col">
                                    <div class="mt-4">
                                        <h4>2 Healthcare Facility</h4>
                                        <p>Partners</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mt-4">
                                        <h4>-</h4>
                                        <p>Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                </div>
                <!-- end row -->

                <hr class="my-5">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="owl-carousel owl-theme clients-carousel" id="clients-carousel" dir="ltr">
                            <div class="item">
                                <div class="client-images">
                                    <img src="<?= base_url() ?>public/assets/images/partner/mc.png"  alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="<?= base_url() ?>public/assets/images/partner/rsua.png"  alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- about section end -->

        <!-- Features start -->
        <section class="section" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Features</div>
                            <h4>Key features of iDerm4U</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div>
                            <img src="<?= base_url() ?>public/assets/images/feature/sim.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    <div class="col-md-5 ms-auto">
                        <div class="mt-4 mt-md-auto">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number fw-semibold display-4 me-3">01</div>
                                <h4 class="mb-0">Information System</h4>
                            </div>
                            <p class="text-muted">Our information system offers a comprehensive and user-friendly interface that allows for the efficient management of patient records, appointment scheduling, secure data storage, etc.</p>
                            <div class="text-muted mt-4">
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Management data patient</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Management medical record</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Management data treatment or product</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Appointment system</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Referral to other health facility partner</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Dashboard with statistical data </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center mt-5 pt-md-5">
                    <div class="col-md-5">
                        <div class="mt-4 mt-md-0">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number fw-semibold display-4 me-3">02</div>
                                <h4 class="mb-0">Point of Sale</h4>
                            </div>
                            <p class="text-muted">The point of sale system simplifies billing and payment procedures by offering a secure, integrated platform to process transactions swiftly. With support for multiple payment methods, including cash, bank virtual account (VA), and e-wallets.</p>
                            <div class="text-muted mt-4">
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Payment gateway support: BNI VA, BRI VA, Mandiri VA, Permata VA, QRIS, and Gopay</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Product order</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Discount feature</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Invoice</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Generate monthly or annual reports</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Inventory</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Whatsapp order notification</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  col-sm-8 ms-md-auto">
                        <div class="mt-4 me-md-0">
                            <img src="<?= base_url() ?>public/assets/images/feature/pos.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div>
                            <img src="<?= base_url() ?>public/assets/images/feature/smart.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    <div class="col-md-5 ms-auto">
                        <div class="mt-4 mt-md-auto">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number fw-semibold display-4 me-3">03</div>
                                <h4 class="mb-0">Smart Intelligence System</h4>
                            </div>
                            <p class="text-muted">Our state-of-the-art AI system utilizes advanced machine learning algorithms to support dermatologists in diagnosing and managing skin conditions more effectively.</p>
                            <div class="text-muted mt-4">
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Artificial Intelligence (AI) features for early detection of your skin disease</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Easy experience of using AI</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- end container -->
        </section>
        <!-- Features end -->

        <!-- Team start -->
        <!-- Team end -->
        
        <!-- Faqs start -->
        <section class="section" id="demo">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">How to Use?</div>
                            <h4>Tutorial iDerm4U on Website and Android Apps Platform</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="vertical-nav">
                            <div class="row">
                                <div class="col-lg-2 col-sm-4">
                                    <div class="nav flex-column nav-pills" role="tablist">
                                        <a class="nav-link active" id="v-about-tab" data-bs-toggle="pill" href="#v-about" role="tab">
                                            <i class= "bx bx-info-circle nav-icon d-block mb-2"></i>
                                            <p class="fw-bold mb-0">About iDerm4U</p>
                                        </a>
                                        <a class="nav-link" id="v-web-hf-tab" data-bs-toggle="pill" href="#v-web-hf" role="tab">
                                            <i class= "bx bx-desktop nav-icon d-block mb-2"></i>
                                            <p class="fw-bold mb-0">Healthcare Facility Web Platform</p>
                                        </a>
                                        <a class="nav-link" id="v-web-patient-tab" data-bs-toggle="pill" href="#v-web-patient" role="tab"> 
                                            <i class= "bx bx-desktop nav-icon d-block mb-2"></i>
                                            <p class="fw-bold mb-0">Patient Web Platform</p>
                                        </a>
                                        <a class="nav-link" id="v-app-patient-tab" data-bs-toggle="pill" href="#v-app-patient" role="tab">
                                            <i class= "bx bx-mobile d-block nav-icon mb-2"></i>
                                            <p class="fw-bold mb-0">Patient Android Apps</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="v-about" role="tabpanel">
                                                    <h4 class="card-title mb-4">iDerm4U - Discover a smarter way to care for your skin.</h4>
                                                    
                                                    <div class="video-container">
                                                        <iframe src="https://www.youtube.com/embed/-0wanFQsaUY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade show" id="v-web-hf" role="tabpanel">
                                                    <h4 class="card-title mb-4">Healthcare Facility Web Platform</h4>
                                                    
                                                    <div class="video-container">
                                                        <iframe src="https://www.youtube.com/embed/-0wanFQsaUY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-web-patient" role="tabpanel">
                                                    <h4 class="card-title mb-4">Patient Web Platform</h4>
                                                        
                                                    <div class="video-container">
                                                        <iframe src="https://www.youtube.com/embed/-0wanFQsaUY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-app-patient" role="tabpanel">
                                                    <h4 class="card-title mb-4">Patient Android Apps</h4>
                                                        
                                                    <div class="video-container">
                                                        <iframe src="https://www.youtube.com/embed/-0wanFQsaUY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end vertical nav -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- Faqs end -->
        

        <!-- Footer start -->
        <footer class="landing-footer">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Links</h5>
                            <ul class="list-unstyled footer-list-menu">
                                <li><a href="<?= base_url() ?>privacy">Privacy Policy</a></li>
                                <li><a href="<?= base_url() ?>terms-and-conditions">Terms and Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6">
                        <div class="mb-4 mb-lg-0">
                            <h5 class="mb-3 footer-list-title">Contact</h5>
                            <div class="blog-post">
                                <a href="mailto: iketuteddy.project@gmail.com" class="post">
                                    <p class="mb-0"><i class="bx bx-mail-send me-1"></i> Email</p>
                                    <div class="badge badge-soft-success font-size-11 mb-3"> iketuteddy.project@gmail.com</div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <hr class="footer-border my-5">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <img src="<?= base_url() ?>public/assets/images/logo-iderm4u.png" alt="" height="20">
                        </div>
    
                        <p class="mb-2"><script>document.write(new Date().getFullYear())</script> © iDerm4U. Design & Develop by iDerm4U Research & Development Team</p>
                    </div>

                </div>
            </div>
            <!-- end container -->
        </footer>
        <!-- Footer end -->

        <!-- JAVASCRIPT -->
        <script src="<?= base_url() ?>public/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>public/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?= base_url() ?>public/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= base_url() ?>public/assets/libs/node-waves/waves.min.js"></script>

        <script src="<?= base_url() ?>public/assets/libs/jquery.easing/jquery.easing.min.js"></script>

        <!-- Plugins js-->
        <script src="<?= base_url() ?>public/assets/libs/jquery-countdown/jquery.countdown.min.js"></script>

        <!-- owl.carousel js -->
        <script src="<?= base_url() ?>public/assets/libs/owl.carousel/owl.carousel.min.js"></script>

        <!-- ICO landing init -->
        <script src="<?= base_url() ?>public/assets/js/pages/ico-landing.init.js"></script>

        <script src="<?= base_url() ?>public/assets/js/app.js"></script>

    </body>

</html>