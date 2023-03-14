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
                <ul class="nav nav-pills nav-justified mt-3" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile-1" role="tab">
                            <span class="d-block d-md-none"><i class="far fa-user mr-2"></i></span>
                            <span class="d-none d-md-block"><i class="far fa-user mr-2"></i> Profile</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#medical-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-file-medical mr-2"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-file-medical mr-2"></i> Medical Record</span>   
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="profile-1" role="tabpanel">
                            <div class="row">
                                <div class="card border border-primary shadow-lg text-center">
                                    <div class="card-body">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <img class="rounded-circle avatar-lg" src="<?= base_url() ?>/public/assets/images/users/<?= $profile['user_photo'] ?>" alt="">
                                        </div>
                                        <h5 class="font-size-15 mb-1"><a class="text-dark"><?= $profile['patient_name'] ?></a></h5>
                                        <p class="text-muted mb-1"><?= umur($profile['patient_birth']) ?> Tahun</p>
                                        <p class="text-muted"><?= $profile['patient_gender'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card shadow-lg text-left">
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><b>ID Pasien</b></td>
                                                    <td><?= $profile['patient_code'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>NIK</b></td>
                                                    <td><?= $profile['patient_nik'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tanggal Lahir</b></td>
                                                    <td><?= date_indo($profile['patient_birth']) ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Kategori</b></td>
                                                    <td><?= $profile['patient_type'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>UID - Email</b></td>
                                                    <td><?= $profile['user_id'] ?> - <?= $profile['user_email'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>HP</b></td>
                                                    <td><?= $profile['patient_phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Alamat</b></td>
                                                    <td><?= $profile['patient_address'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Keterangan Lain</b></td>
                                                    <td><?= $profile['patient_other'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Create / Last Edited</b></td>
                                                    <td><?= $profile['patient_create'] ?> / <?= $profile['patient_edit'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="medical-1" role="tabpanel">
                        <?php $nomor = 0;
                        foreach ($medical as $data) :
                            $nomor++; ?>
                            <div class="accordion" id="accordionMedical">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $nomor ?>">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $nomor ?>" aria-expanded="false" aria-controls="collapse<?= $nomor ?>">
                                            #<?= $nomor ?> <?= $data['medical_code'] ?> <?= longdate_indo(substr($data['medical_create'],0,10)) ?> 
                                            <?php if ($data['medical_status'] == 'Selesai') { ?> 
                                                <span class="badge rounded-pill bg-success ml-2">Selesai</span>
                                            <?php } ?>
                                            <?php if ($data['medical_status'] == 'Proses') { ?> 
                                                <span class="badge rounded-pill bg-secondary ml-2">Proses</span>
                                            <?php } ?> 
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $nomor ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $nomor ?>" data-bs-parent="#accordionMedical">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                <strong class="text-dark">Jenis:</strong> 
                                                <?php if ($data['medical_type'] == 'Treatment') { ?> 
                                                    <span class="badge bg-primary">Treatment</span>
                                                <?php } ?>
                                                <?php if ($data['medical_type'] == 'Product') { ?> 
                                                    <span class="badge bg-success">Beli Produk</span>
                                                <?php } ?> 
                                                <?php if ($data['medical_type'] == 'Treatment-Product') { ?> 
                                                    <div><span class="badge bg-primary">Treatment</span> <span class="badge bg-success">Beli Produk</span></div>
                                                <?php } ?> 
                                                <?php if ($data['medical_type'] == 'Lainnya') { ?> 
                                                    <span class="badge bg-warning">Lainnya</span>
                                                <?php } ?> <br>
                                                <strong class="text-dark">Catatan:</strong> 
                                                <?= $data['medical_description'] ?> <br>
                                                <strong class="text-dark">Invoice/Total:</strong> 
                                                <?= $data['invoice_code'] ?> / Rp <?= rupiah($data['invoice_amount']) ?>
                                            </div>
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
$(document).ready(function () {
    //Medical Table
    var table_medical = $("#datatable-medical").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_medical
    .buttons()
    .container()
    .appendTo("#datatable-medical_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});
</script>