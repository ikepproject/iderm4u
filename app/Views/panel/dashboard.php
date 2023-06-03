<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Selamat Datang</h5>
                                        <p>iDerm4U - Dashboard</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>public/assets/images/profile-img-ori.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <?php if ($user['user_role'] == 2020 || $user['user_role'] == 2022 || $user['user_role'] == 5050 || $user['user_role'] == 5055) { ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Pasien</p>
                                                <h4 class="mb-0"><?= $total_patient ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Kunjungan <?= date('F Y') ?></p>
                                                <h4 class="mb-0"><?= $count_current_month ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bxs-user-detail font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Kunjungan Tahun <?= date('Y') ?></p>
                                                <h4 class="mb-0"><?= $count_current_year ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bxs-user-detail font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    <?php } ?>
                    <?php if ($user['user_role'] == 1011) { ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Medical Record</p>
                                                <h4 class="mb-0"><?= $patient_medical ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Appointment</p>
                                                <h4 class="mb-0"><?= $patient_appointment ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-calendar font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Order Produk</p>
                                                <h4 class="mb-0"><?= $patient_order ?></h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-shopping-bag font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    <?php } ?>
                    <!-- <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex flex-wrap">
                                <h4 class="card-title mb-4">Email Sent</h4>
                                <div class="ms-auto">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Week</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Month</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Year</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div id="stacked-column-chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div> -->
                </div>
                <?php if ($user['user_role'] == 2020 || $user['user_role'] == 2022 || $user['user_role'] == 5050 || $user['user_role'] == 5055) { ?>
                    <div class="row">
                            <div id="chart"></div>
                    </div>
                <?php } ?>
                <?php if ($user['user_role'] == 1011) { ?>
                    <div class="row">
                        <?php 
                        foreach ($treatment_discount as $discount) : ?>
                            <div class="col-sm-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="product-img position-relative">
                                            <div class="avatar-sm product-ribbon">
                                                <span class="avatar-title rounded-circle  bg-primary">
                                                    - <?php if ($discount['treatment_discount'] == 't') { ?> <?= round((($discount['treatment_price']-$discount['treatment_discount_price'])/$discount['treatment_price'])*100,0) ?> % <?php } ?>
                                                </span>
                                            </div>
                                            <img src="public/assets/images/anouncement/default.png" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                        <div class="mt-4 text-center">
                                            <p class="text-muted">Diskon Treatment </p>
                                            <h6 class="mb-3 text-truncate"><a href="javascript: void(0);" class="text-dark"><?= $discount['treatment_name'] ?> </a></h6>
                                            <h6 class="my-0"><span class="text-muted me-2">
                                                <?php if ($discount['treatment_discount'] == 't') { ?> <del>Rp <?= rupiah($discount['treatment_price']) ?></del> </span> <br> Rp <?= rupiah($discount['treatment_discount_price']) ?><?php } ?>
                                            </h6>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php } ?>
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <script>
        // Initialize the chart
        var options = {
            series: [
                {
                    name: 'Kunjungan',
                    data: JSON.parse('<?= $chartData ?>'),
                },
            ],
            chart: {
                type: 'area',
                height: 350,
            },
            xaxis: {
                type: 'Bulan',
            },
            yaxis: {
                title: {
                    text: 'Jumlah Kunjungan',
                },
            },
        };

        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();
    </script>
<?= $this->endSection('isi') ?>