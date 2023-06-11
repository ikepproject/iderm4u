<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#medical-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-notes-medical"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-notes-medical mr-2"></i> Detail</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#gallery-1" role="tab">
                            <span class="d-block d-md-none"><i class="far fa-images"></i></span>
                            <span class="d-none d-md-block"><i class="far fa-images mr-2"></i> Foto</span>   
                        </a>
                    </li>
                    <?php if ($user_role != 1011) { ?> 
                        <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#gejala-1" role="tab">
                            <span class="d-block d-md-none"><i class="bx bx-map-pin"></i></span>
                            <span class="d-none d-md-block"><i class="bx bx-map-pin mr-2"></i> Area Gejala</span>   
                        </a>
                        </li>
                        <?php if ($medical['medical_status'] == 'Selesai' && $faskes_user['faskes_type'] == 'Klinik') { ?> 
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#refer-1" role="tab">
                                <span class="d-block d-md-none"><i class="fas fa-ambulance"></i></span>
                                <span class="d-none d-md-block"><i class="fas fa-ambulance mr-2"></i> Rujuk</span>   
                            </a>
                        </li>
                        <?php } ?> 
                    <?php } ?>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="medical-1" role="tabpanel">
                            <div class="row">
                                <div class="card border border-primary shadow-lg text-center">
                                    <div class="card-body">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <img class="rounded-circle avatar-lg" src="<?= base_url() ?>/public/assets/images/users/<?= $user['user_photo'] ?>" alt="">
                                        </div>
                                        <h5 class="font-size-15 mb-1"><a class="text-dark"><?= $patient['patient_code'] ?> - <?= $patient['patient_name'] ?></a></h5>
                                        <p class="text-muted mb-1"><?= $user['user_email'] ?> / <?= $user['user_phone'] ?> </p>
                                        <p class="text-muted mb-1"><?= umur($patient['patient_birth']) ?> Tahun</p>
                                        <p class="text-muted"><?= $patient['patient_gender'] ?></p>
                                        <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#patientData" aria-expanded="true" aria-controls="patientData">
                                            <i class="fas fa-expand-alt mr-2"></i> Detail Data Pasien
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="patientData">
                                <div class="row">
                                    <div class="card border border-primary shadow-lg text-left">
                                        <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>ID Pasien</b></td>
                                                            <td><?= $patient['patient_code'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>NIK</b></td>
                                                            <td><?= $user['user_nik'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Tanggal Lahir</b></td>
                                                            <td><?= date_indo($patient['patient_birth']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kategori</b></td>
                                                            <td><?= $patient['patient_type'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b><?php if ($user_role != 1011) { ?>UID -<?php } ?>  Email</b></td>
                                                            <td><?php if ($user_role != 1011) { ?><?= $user['user_id'] ?> - <?php } ?>  <?= $user['user_email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>HP</b></td>
                                                            <td><?= $user['user_phone'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Alamat</b></td>
                                                            <td><?= $patient['patient_address'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Keterangan Lain</b></td>
                                                            <td><?= $patient['patient_other'] ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border border-success shadow-lg">
                                        <div class="card-body">
                                            <div class="invoice-title">
                                                <h5 class="float-end font-size-16"><?= $medical['medical_code'] ?></h5>
                                                <div class="mb-4">
                                                    <img src="<?= base_url() ?>/public/assets/images/logo-iderm4u.png" alt="logo" height="20"/>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <address>
                                                        <strong>Kepada:</strong><br>
                                                        <?= $patient['patient_name'] ?><br>
                                                        <?= $user['user_phone'] ?><br>
                                                        <?= $patient['patient_address'] ?>
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <address>
                                                        <strong>Hari, Tanggal:</strong><br>
                                                        <?= longdate_indo(substr($medical['medical_create'],0,10)) ?> <?= substr($medical['medical_create'],11,5)?> <br>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 mt-3">
                                                    <address>
                                                        <strong>Pembayaran:</strong><br>
                                                        Invoice: <?= $invoice['invoice_code'] ?> <br>
                                                        Via: <?= $invoice['invoice_method'] ?><br>
                                                        Status: 
                                                        <?php if ($invoice['invoice_status'] == 'SUCCEEDED') { ?> 
                                                            <span class="badge bg-success">Lunas</span>
                                                        <?php } ?>
                                                        <?php if ($invoice['invoice_status'] != 'SUCCEEDED') { ?> 
                                                            <span class="badge bg-secondary">Pending</span>
                                                        <?php } ?>
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 mt-3 text-sm-end">
                                                    <address class="mt-2 mt-sm-0">
                                                        <strong>Petugas:</strong><br>
                                                        <?= $medical['medical_employee'] ?><br>
                                                    </address>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="py-2 mt-3">
                                                <h3 class="font-size-15 fw-bold">Detail</h3>
                                            </div>
                                            <div>
                                                <p><b>Jenis Kunjungan:</b> 
                                                    <?php if ($medical['medical_type'] == 'Treatment') { ?> 
                                                        <span class="badge bg-primary">Treatment</span>
                                                    <?php } ?>
                                                    <?php if ($medical['medical_type'] == 'Product') { ?> 
                                                        <span class="badge bg-success">Beli Produk</span>
                                                    <?php } ?> 
                                                    <?php if ($medical['medical_type'] == 'Treatment-Product') { ?> 
                                                        <div><span class="badge bg-primary">Treatment</span> <span class="badge bg-success">Beli Produk</span></div>
                                                    <?php } ?> 
                                                    <?php if ($medical['medical_type'] == 'Lainnya') { ?> 
                                                        <span class="badge bg-warning">Lainnya</span>
                                                    <?php } ?> 
                                                </p>
                                                <p><b>Catatan:</b> <?= $medical['medical_description'] ?></p>
                                            </div>
                                            <div class="py-2 mt-3">
                                                <h4 class="font-size-15 fw-bold">Order</h4>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-wrap">
                                                    <thead>
                                                        <tr>
                                                            <th width="1%">No.</th>
                                                            <th width="75%">Item (Jml)</th>
                                                            <th width="24%" class="text-end">Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php  $nomor = 0;?>
                                                        <?php if (count($medtreat) != 0) {?>
                                                            <?php
                                                            foreach ($medtreat as $treatment) :
                                                            $nomor++; ?>
                                                            <tr>
                                                                <td><?= $nomor ?></td>
                                                                <td>TR - 
                                                                    <?= $treatment['medtreat_discount'] ?>
                                                                    <?= $treatment['treatment_type'] ?> 
                                                                    <?= $treatment['medtreat_name'] ?>
                                                                    <?php if ($treatment['medtreat_discount'] != NULL) { ?>
                                                                        <s>Rp <?= rupiah($treatment['medtreat_discount_price']) ?></s>
                                                                    <?php } ?> 
                                                                </td>
                                                                <td class="text-end">Rp <?= rupiah($treatment['medtreat_price']) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                         <?php } ?>
                                                         <?php if (count($medprod) != 0) {?>
                                                            <?php
                                                            foreach ($medprod as $product) :
                                                            $nomor++; ?>
                                                            <tr>
                                                                <td><?= $nomor ?></td>
                                                                <td>PR - 
                                                                    <?= $product['product_type'] ?> 
                                                                    <?= $product['medprod_name'] ?> 
                                                                    (<?= $product['medprod_qty'] ?>) 
                                                                    @<?= rupiah($product['medprod_price']) ?>
                                                                </td>
                                                                <td class="text-end">Rp <?= rupiah($product['medprod_price']*$product['medprod_qty']) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                         <?php } ?>
                                                         <?php if (count($medoth) != 0) {?>
                                                            <?php
                                                            foreach ($medoth as $other) :
                                                            $nomor++; ?>
                                                            <tr>
                                                                <td><?= $nomor ?></td>
                                                                <td>LN - 
                                                                    <?= $other['medoth_name'] ?> 
                                                                    (<?= $other['medoth_qty'] ?>) 
                                                                    @<?= rupiah($other['medoth_price']) ?>
                                                                </td>
                                                                <td class="text-end">Rp <?= rupiah($other['medoth_price']*$other['medoth_qty']) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                         <?php } ?>
                                                        
                                                        <tr>
                                                            <td colspan="2" class="text-end">Sub Total</td>
                                                            <td class="text-end">Rp <?= rupiah($invoice['invoice_amount']-$invoice['invoice_admin_fee']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="border-0 text-end">
                                                                <strong>Fee Transaksi</strong></td>
                                                            <td class="border-0 text-end">Rp <?= rupiah($invoice['invoice_admin_fee']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="border-0 text-end">
                                                                <strong>Total</strong></td>
                                                            <td class="border-0 text-end"><h4 class="m-0">Rp <?= rupiah($invoice['invoice_amount']) ?></h4></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="gallery-1" role="tabpanel">
                        <?php if ($user_role != 1011) { ?>
                        
                            <?= form_open('medical/addgallery', ['class' => 'formadd']) ?>
                            <?= csrf_field(); ?>
                            <input type="hidden" id="medical_code" name="medical_code" value="<?= $medical['medical_code'] ?>">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="medgal_disease">Indikasi Dalam Foto (Jika lebih dari 1 indikasi pisah dengan tanda -)</label>
                                    <input type="text" class="form-control" id="medgal_disease" name="medgal_disease">
                                </div>
                                <div class="mb-3">
                                    <label for="name">Tambah foto</label>
                                    <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images();" accept=".jpg,.jpeg,.png" multiple/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <div style="display: inline-block;" id="image_preview"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary" id="save" name="save"><i class="bx bx-images"></i> Tambah Foto</button>
                                </div>
                            </div>
                            <?= form_close() ?>
                            <hr>
                        <?php } ?>
                        <?php if ($medgal_refer != NULL) {?>
                            <?php
                            foreach ($medgal_refer as $gallery_refer) :
                            ?>
                            
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="product-img position-relative">
                                            <img src="<?= base_url() ?>/public/assets/images/medical/thumb/<?= $gallery_refer['medgal_filename'] ?>" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                        <?php if ($user_role != 1011) { ?>
                                            <div class="mt-4 text-center text-break">
                                                <p class="mb-3"><?= $gallery_refer['medgal_filename'] ?></p> <br>
                                                <button type="button" class="btn btn-danger mb-2" onclick="del('<?= $gallery_refer['medgal_id'] ?>', '<?= $gallery_refer['medgal_filename'] ?>')">
                                                    <i class="bx bx-trash"></i> Hapus
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php } ?>
                       
                        <?php
                        foreach ($medgal as $gallery) :
                        $nomor++; ?>
                        
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-img position-relative">
                                        <img src="<?= base_url() ?>/public/assets/images/medical/thumb/<?= $gallery['medgal_filename'] ?>" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                    <?php if ($user_role != 1011) { ?>
                                        <div class="mt-4 text-center text-break">
                                            <p class="mb-3"><?= $gallery['medgal_filename'] ?></p> <br>
                                            <button type="button" class="btn btn-danger mb-2" onclick="del('<?= $gallery['medgal_id'] ?>', '<?= $gallery['medgal_filename'] ?>')">
                                                <i class="bx bx-trash"></i> Hapus
                                            </button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ($user_role != 1011) { ?>
                        <div class="tab-pane" id="gejala-1" role="tabpanel">

                            <p><i class="bx bx-info-circle"></i> Lihat kode area terjadinya gejala pada setiap bagian memilik kode yg berbeda.</p>
                            <p><i class="bx bx-info-circle"></i> Klik tombol dibawah agar illustrasi area gejala muncul.</p>
                            
                            <div class="d-flex bd-highlight mb-3">
                                <div class="p-2 bd-highlight">
                                <a class="btn btn-success btn-sm mb-3" data-bs-toggle="collapse" href="#face" aria-expanded="true" aria-controls="face">
                                    <i class="bx bx-face mr-2"></i> Area Wajah
                                </a>
                                </div>
                                <div class="p-2 bd-highlight">
                                <a class="btn btn-primary btn-sm mb-3" data-bs-toggle="collapse" href="#body" aria-expanded="true" aria-controls="body">
                                    <i class="bx bx-body mr-2"></i> Area Tubuh
                                </a>
                                </div>
                            </div>

                            <div class="collapse" id="face">
                                <div class="row">
                                    <div class="card border border-primary shadow-lg text-left">
                                        <div class="card-body">
                                            <div class="product-img position-relative">
                                                <img src="<?= base_url() ?>public/assets/images/mapping/face.png" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="body">
                                <div class="row">
                                    <div class="card border border-primary shadow-lg text-left">
                                        <div class="card-body">
                                            <div class="product-img position-relative">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <?php if ($user_role != 1011) { ?>
                        <div class="tab-pane" id="refer-1" role="tabpanel">
                            <?php if ($medical['medical_refer_type'] == NULL) { ?>
                                <div class="row">
                                    <div class="mb-3 text-center">
                                        <a class="btn btn-primary btn-sm" data-bs-toggle="collapse" href="#RujukData" aria-expanded="true" aria-controls="patientData">
                                            <i class="fas fa-expand-alt mr-2"></i> Info Rujukan
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <div class="collapse" id="RujukData">
                                            <div class="card border border-primary shadow-lg">
                                                <div class="card-body">
                                                    <?php foreach ($faskes_list as $key => $data) { ?>
                                                        <strong><?= $data['faskes_name'] ?></strong> <br>
                                                        Biaya Rujuk Store & Foward: Rp <?= rupiah($data['faskes_refersf_price']) ?> <br>
                                                        Biaya Rujuk Teledermatologi: Rp <?= rupiah($data['faskes_refer_price']) ?> <br>
                                                        Note: <?= $data['faskes_refer_note'] ?>
                                                        <hr>
                                                    <?php } ?>
                                                    <p>Tanggal pasti Rujukan Kunjungan/Teledermatologi akan dikonfirmasi oleh Admin RS terlebih dahulu untuk menyesuaikan dengan jadwal Dokter yang tersedia. Pasien akan mendapatkan informasi lebih lanjut.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <style>
                                    .select2-container {
                                        width: 100% !important;
                                    }
                                </style>
                                <?= form_open('refer/create', ['class' => 'formReferAdd']) ?>
                                <?= csrf_field(); ?>
                                <input type="hidden" id="medical_refer_code" name="medical_refer_code" value="<?= $medical['medical_code'] ?>">
                                <input type="hidden" id="medical_user" name="medical_user" value="<?= $medical['medical_user'] ?>">
                                    <div class="mb-3">
                                        <label for="medical_refer_type">Pilih Tipe Rujukan <code>*</code></label> 
                                        <button type="button" class="btn btn-light position-relative p-0 avatar-xs rounded-circle" data-toggle="tooltip" data-placement="top" 
                                        title="Jika memilih opsi Store&Foward/Teledermatologi terdapat biaya yang harus dibayar diawal."> <span class="avatar-title bg-transparent text-reset"> <i class="bx bxs-info-circle"></i> </span>
                                        </button> <br>
                                        <select class="form-select select2-detail" name="medical_refer_type" id="medical_refer_type" onchange="showDiv(this)">
                                            <option selected disabled>Pilih...</option>
                                            <option value="Kunjungan">Rujuk Kunjungan</option>
                                            <option value="StoreFoward">Rujuk Store & Foward</option>
                                            <option value="Teledermatologi">Rujuk Teledermatologi</option>
                                        </select>
                                        <div class="invalid-feedback error_medical_refer_type"></div>
                                    </div>
                                    <div class="mb-3" id="hidden_bayar" style="display: none;">
                                        <label class="form-label">Cara Bayar<code>*</code></label> <br>
                                        <select class="form-select select2-detail" name="invoice_method" id="invoice_method">
                                            <option value="VA">Virtual Account (+ Rp 4.440)</option>
                                            <?php if ($device != "hp") { ?> 
                                                <option value="QR">QRIS (+ 0.7%)</option>
                                            <?php } ?>
                                            <!-- <option value="Gopay">GoPay (+ 2%)</option> -->
                                        </select>
                                    </div>
                                <div class="mb-3">
                                    <label for="medical_faskes">Pilih Rumah Sakit Rujukan <code>*</code></label> <br>
                                    <select class="form-control select2-detail" id="medical_faskes" name="medical_faskes"> 
                                        <option selected disabled>Pilih...</option>
                                        <?php foreach ($faskes_list as $key => $data) { ?>
                                            <option value="<?= $data['faskes_code'] ?>"><?= $data['faskes_name'] ?> </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback error_medical_faskes"></div>
                                </div>
                                <div class="mb-3" id="hidden_tgl" style="display: none;">
                                <label class="form-label">Tanggal Perkiraan Kunjungan (Jadwal akan ditetapkan oleh faskes rujukan)</label>
                                    <div class="input-group" id="datepicker2">
                                        <input type="text" id="appointment_date_expect" name="appointment_date_expect" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                            data-provide="datepicker" data-date-autoclose="true">

                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catatan Lain </label>
                                    <textarea class="form-control" name="appointment_note_user" id="appointment_note_user" placeholder="Tulis catatan rujukan jika ada ..."></textarea>
                                    
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-warning" id="refer" name="refer"><i class="bx bx-transfer-alt"></i> Rujuk</button>
                                    </div>
                                </div>
                                <?= form_close() ?>
                            <?php } ?> 
                            <?php if ($medical['medical_refer_type'] != NULL) { ?> 
                                <h5 class="text-center">Data Kunjungan ini sudah dirujuk.</h5>
                            <?php } ?> 
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function preview_images() {
    var total_file=document.getElementById("images").files.length;
    for(var i=0;i<total_file;i++) {
        $('#image_preview').append("<img style='object-fit:scale-down;width:150px;height:150px; margin-right:10px;' class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>");
    }
};

function showDiv(select){
    if(select.value=="Teledermatologi" || select.value=="StoreFoward"){
        document.getElementById('hidden_bayar').style.display = "block";
        } else{
        document.getElementById('hidden_bayar').style.display = "none";
    }
    if (select.value=="Teledermatologi" || select.value=="Kunjungan") {
        document.getElementById('hidden_tgl').style.display = "block";
    } else {
        document.getElementById('hidden_tgl').style.display = "none";
    }
} 

$(document).ready(function () {
    $('.select2-detail').select2({
            dropdownParent: $('#modaldetail'),
            minimumResultsForSearch: Infinity
        });

    $(".formadd").submit(function (e) {
    e.preventDefault();
    var form_data = new FormData($('form')[0]);
    $.ajax({
    type: "post",
    url: $(this).attr("action"),
    data: form_data,
    processData: false,
    contentType: false,
    dataType: "json",
    beforeSend: function () {
        $("#save").attr("disabled", true);
        $("#save").html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
        );
    },
    complete: function () {
        $("#save").removeAttr("disabled", false);
        $("#save").html("Tambah Data");
    },
    success: function (response) {
        if (response.error) {

            if (response.error.medical_user) {
                $("#medical_user").addClass("is-invalid");
                $(".error_medical_user").html(response.error.medical_user);
            } else {
                $("#medical_user").removeClass("is-invalid");
                $(".error_medical_user").html("");
            }

        } else {
        if (response.success) {
            Swal.fire({
            title: "Berhasil!",
            text: response.success,
            icon: response.icon,
            showConfirmButton: false,
            timer: 1500,
            }).then(function () {
                window.location = response.link;
            });
        }
        }
    },
    });
    });

    $(".formReferAdd").submit(function (e) {
    e.preventDefault();
    var form_data = new FormData($('form')[1]);
    $.ajax({
    type: "post",
    url: $(this).attr("action"),
    data: form_data,
    processData: false,
    contentType: false,
    dataType: "json",
    beforeSend: function () {
        $("#refer").attr("disabled", true);
        $("#refer").html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
        );
    },
    complete: function () {
        $("#refer").removeAttr("disabled", false);
        $("#refer").html("Rujuk");
    },
    success: function (response) {
        if (response.error) {

            if (response.error.medical_refer_type) {
                $("#medical_refer_type").addClass("is-invalid");
                $(".error_medical_refer_type").html(response.error.medical_refer_type);
            } else {
                $("#medical_refer_type").removeClass("is-invalid");
                $(".error_medical_refer_type").html("");
            }

            if (response.error.medical_faskes) {
                $("#medical_faskes").addClass("is-invalid");
                $(".error_medical_faskes").html(response.error.medical_faskes);
            } else {
                $("#medical_faskes").removeClass("is-invalid");
                $(".error_medical_faskes").html("");
            }

        } else {
        if (response.success) {
            Swal.fire({
            title: "Berhasil!",
            text: response.success,
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
            }).then(function () {
                window.location = response.link;
            });
        }
        }
    },
    });
    });
});

function del(medgal_id, medgal_filename) {
    Swal.fire({
        title: 'Hapus foto?',
        text: `Apakah anda yakin menghapus foto ${medgal_filename}? `,
        icon: 'warning',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "medical/deletegallery",
                type: "post",
                dataType: "json",
                data: {
                    medgal_id: medgal_id,
                    medgal_filename: medgal_filename
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.success,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location = response.link;
                        });
                    }
                }
            });
        }
    })
}
</script>