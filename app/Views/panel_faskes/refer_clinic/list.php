<hr>
<h5 class="text-left"> Data Rujuk Teledermatologi</h5>

<table id="datatable-refer" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="7%">Status</th>
            <th width="8%">Jadwal Fix</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list_teledermatologi as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['patient_name'] ?></td>
                <td>
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-success"> <i class="bx bx-check"></i> </span> <br>
                    <?php } ?>
                    <?php if ($data['medical_diagnose'] == NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-secondary"> - </span> <br>
                    <?php } ?> 
                    <?php if ($data['appointment_type'] == 'Teledermatologi') { ?> 
                        <?php if ($data['invoice_status'] == 'SUCCEEDED') { ?> 
                        Pembayaran: <span class="badge rounded-pill bg-success">SUCCEEDED</span>
                        <?php } ?>
                        <?php if ($data['invoice_status'] == 'PENDING') { ?> 
                        Pembayaran: <span class="badge rounded-pill bg-secondary">PENDING</span>
                        <?php } ?> 
                    <?php } ?>  
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <span class="badge bg-success">Dijadwalkan</span> <br>
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],11,5)?>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($data['invoice_midtrans'] == NULL) { ?> 
                        <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>', '<?= $data['appointment_type'] ?>')">
                        <i class="bx bx-x"></i>
                        </button>
                        <a type="button" class="btn btn-success mb-2" href="<?= base_url('transaction/checkout/' . $data['medical_code']) ?>">
                            <i class="bx bx-check"></i>
                        </a>
                    <?php } ?>
                    
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        <button type="button" class="btn btn-info mb-2" onclick="diagnose('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>')">
                            <i class="fas fa-notes-medical"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<hr>
<h5 class="text-left">Data Rujuk Store & Foward</h5>

<table id="datatable-refer-snf" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="7%">Status</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor2 = 0; 
            foreach ($list_storefoward as $data) : 
            $nomor2++; ?>
            <tr>
                <td><?= $nomor2 ?></td>
                <td><?= $data['patient_name'] ?></td>
                <td>
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-success"> <i class="bx bx-check"></i> </span> <br>
                    <?php } ?>
                    <?php if ($data['medical_diagnose'] == NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-secondary"> - </span> <br>
                    <?php } ?> 
                </td>
                <td>
                    <?php if ($data['invoice_midtrans'] == NULL) { ?> 
                        <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>', 'StoreFoward')">
                        <i class="bx bx-x"></i>
                        </button>
                        <a type="button" class="btn btn-success mb-2" href="<?= base_url('transaction/checkout/' . $data['medical_code']) ?>">
                            <i class="bx bx-check"></i>
                        </a>
                    <?php } ?>
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        <button type="button" class="btn btn-info mb-2" onclick="diagnose('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>')">
                            <i class="fas fa-notes-medical"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<hr>
<h5 class="text-left">Data Rujuk Kunjungan</h5>

<table id="datatable-refer-visit" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="7%">Status</th>
            <th width="8%">Jadwal Fix</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor2 = 0; 
            foreach ($list_kunjungan as $data) : 
            $nomor2++; ?>
            <tr>
                <td><?= $nomor2 ?></td>
                <td><?= $data['patient_name'] ?></td>
                <td>
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-success"> <i class="bx bx-check"></i> </span> <br>
                    <?php } ?>
                    <?php if ($data['medical_diagnose'] == NULL) { ?> 
                        Diagnosis: <span class="badge rounded-pill bg-secondary"> - </span> <br>
                    <?php } ?> 
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        Kunjungan: <span class="badge rounded-pill bg-success">Selesai</span>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 
                        Kunjungan: <span class="badge rounded-pill bg-secondary">Proses</span>
                    <?php } ?> 
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <span class="badge bg-success">Dijadwalkan</span> <br>
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],11,5)?>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>', '<?= $data['appointment_type'] ?>')"><i class="bx bx-x"></i>
                        </button> 
                    <?php } ?>
                    <?php if ($data['medical_diagnose'] != NULL) { ?> 
                        <button type="button" class="btn btn-info mb-2" onclick="diagnose('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>')">
                            <i class="fas fa-notes-medical"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<div class="diagnosemodal"></div>
<div class="detailmodal"></div>

<script>
$(document).ready(function () {
    //Tldm Table
    var table_refer = $("#datatable-refer").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_refer
    .buttons()
    .container()
    .appendTo("#datatable-refer_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");

    //Visit Table
    var table_refer_visit = $("#datatable-refer-visit").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_refer_visit
    .buttons()
    .container()
    .appendTo("#datatable-refer-visit_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");

    //Refer Snf
    var table_refer_snf = $("#datatable-refer-snf").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_refer_snf
    .buttons()
    .container()
    .appendTo("#datatable-refer-snf_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});

function cancel(medical_code, patient_name, appointment_type) {
    Swal.fire({
        title: 'Batalkan data rujukan?',
        text: `Apakah anda yakin membatalkan data rujukan ${patient_name}? `,
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
                url: "medical/cancel",
                type: "post",
                dataType: "json",
                data: {
                    medical_code: medical_code,
                    modul: appointment_type
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.success,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        datatable_refer();
                    }
                }
            });
        }
    })
}

function diagnose(medical_code) {
    $.ajax({
        type: "post",
        url: "medical/formdiagnose",
        data: {
            medical_code: medical_code
        },
        dataType: "json",
        success: function(response) {
            $('.diagnosemodal').html(response.data).show();
            $('#modaldiagnose').modal('show');
        }
    });
}
</script>