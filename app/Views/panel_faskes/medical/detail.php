<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                                        <p class="text-muted mb-1"><?= $user['user_email'] ?> / <?= $patient['patient_phone'] ?> </p>
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
                                                            <td><?= $patient['patient_nik'] ?></td>
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
                                                            <td><b>UID - Email</b></td>
                                                            <td><?= $user['user_id'] ?> - <?= $user['user_email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>HP</b></td>
                                                            <td><?= $patient['patient_phone'] ?></td>
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
                                                        <?= $patient['patient_phone'] ?><br>
                                                        <?= $patient['patient_address'] ?>
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <address>
                                                        <strong>Hari, Tanggal:</strong><br>
                                                        <?= longdate_indo(substr($medical['medical_create'],0,10)) ?><br>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 mt-3">
                                                    <address>
                                                        <strong>Pembayaran:</strong><br>
                                                        Invoice: <?= $invoice['invoice_code'] ?> <br>
                                                        <?= $invoice['invoice_method'] ?><br>
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
                                                <table class="table table-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 70px;">No.</th>
                                                            <th>Item (Jml)</th>
                                                            <th class="text-end">Harga</th>
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
                                                                <td>TR - <?= $treatment['treatment_name'] ?></td>
                                                                <td class="text-end">Rp <?= rupiah($treatment['treatment_price']) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                         <?php } ?>
                                                         <?php if (count($medprod) != 0) {?>
                                                            <?php
                                                            foreach ($medprod as $product) :
                                                            $nomor++; ?>
                                                            <tr>
                                                                <td><?= $nomor ?></td>
                                                                <td>PR - <?= $product['product_name'] ?> (<?= $product['medprod_qty'] ?>) @<?= rupiah($product['product_price']) ?></td>
                                                                <td class="text-end">Rp <?= rupiah($product['product_price']*$product['medprod_qty']) ?></td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                         <?php } ?>
                                                         <?php if (count($medoth) != 0) {?>
                                                            <?php
                                                            foreach ($medoth as $other) :
                                                            $nomor++; ?>
                                                            <tr>
                                                                <td><?= $nomor ?></td>
                                                                <td>LN - <?= $other['medoth_name'] ?> (<?= $other['medoth_qty'] ?>) @<?= rupiah($other['medoth_price']) ?></td>
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
                        <?= form_open('medical/addgallery', ['class' => 'formadd']) ?>
                        <?= csrf_field(); ?>
                        <input type="hidden" id="medical_code" name="medical_code" value="<?= $medical['medical_code'] ?>">
                        <div class="row">
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
                        <?php
                        foreach ($medgal as $gallery) :
                        $nomor++; ?>
                        
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-img position-relative">
                                        <img src="<?= base_url() ?>/public/assets/images/medical/thumb/<?= $gallery['medgal_filename'] ?>" alt="" class="img-fluid mx-auto d-block">
                                    </div>
                                    <div class="mt-4 text-center text-break">
                                        <p class="mb-3"><?= $gallery['medgal_filename'] ?></p> <br>
                                        <button type="button" class="btn btn-danger mb-2" onclick="del('<?= $gallery['medgal_id'] ?>', '<?= $gallery['medgal_filename'] ?>')">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script>
function preview_images() {
    var total_file=document.getElementById("images").files.length;
    for(var i=0;i<total_file;i++) {
        $('#image_preview').append("<img style='object-fit:scale-down;width:150px;height:150px; margin-right:10px;' class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>");
    }
};

$(document).ready(function () {
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