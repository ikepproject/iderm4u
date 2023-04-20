<table id="datatable_refer" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="9%">Faskes Asal</th>
            <th width="5%">Tgl Dirujuk</th>
            <th width="7%">Status</th>
            <th width="7%">Jenis</th>
            <th width="8%">Jadwal Fix</th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
    <?php

use Faker\Provider\Base;

 $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['patient_name'] ?></td>
                <td><?= $data['faskes_name'] ?></td>
                <td>
                    <?= longdate_indo(substr($data['medical_create'],0,10)) ?>, <?= substr($data['medical_create'],11,5)?> WIB
                </td>
                <td>
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        <span class="badge rounded-pill bg-success">Selesai</span>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 
                        <span class="badge rounded-pill bg-secondary">Proses</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($data['appointment_type'] == 'Kunjungan') { ?> 
                        <span class="badge bg-success">Kunjungan</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <span class="badge bg-success">Dijadwalkan</span>
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],11,5)?>WIB
                    <?php } ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['medical_code'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <button type="button" class="btn btn-success mb-2" onclick="accept('<?= $data['medical_code'] ?>')">
                            <i class="bx bx-calendar-check"></i>
                        </button>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?>
                        <?php if ($data['medical_type'] == NULL) { ?>
                            <button type="button" class="btn btn-warning mb-2" onclick="accept('<?= $data['medical_code'] ?>')">
                                <i class="bx bx-calendar-check"></i>
                            </button>
                        <?php } ?>
                        <?php if ($data['medical_type'] == NULL) { ?>
                            <a type="button" class="btn btn-success mb-2" href="<?= base_url('refer-visit/add').'?medical='.$data['medical_code'] ?>">
                                <i class="bx bx-plus-medical"></i>
                            </a> 
                        <?php } ?>

                        <?php if ($data['medical_type'] != NULL) { ?>
                            <?php if ($data['invoice_midtrans'] == NULL) { ?> 
                                <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>', '<?= $data['invoice_id'] ?>')">
                                <i class="bx bx-x"></i>
                                </button>
                            <?php } ?> 

                            <a type="button" class="btn btn-success mb-2" href="<?= base_url('transaction/checkout/' . $data['medical_code']) ?>">
                                <i class="bx bx-check"></i>
                            </a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($data['medical_type'] != NULL) { ?>
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
<div class="acceptmodal"></div>
<script>
$(document).ready(function () {
    //Patient Table
    var table_refer = $("#datatable_refer").DataTable({
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
    .appendTo("#datatable_refer_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});
function detail(medical_code) {
    $.ajax({
        type: "post",
        url: "medical/formdetail",
        data: {
            medical_code: medical_code
        },
        dataType: "json",
        success: function(response) {
            $('.detailmodal').html(response.data).show();
            $('#modaldetail').modal('show');
        }
    });
}
function accept(medical_code) {
    $.ajax({
        type: "post",
        url: "appointment/formaccept",
        data: {
            medical_code: medical_code
        },
        dataType: "json",
        success: function(response) {
            $('.acceptmodal').html(response.data).show();
            $('#modalaccept').modal('show');
        }
    });
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

function cancel(medical_code, patient_name, invoice_id) {
    Swal.fire({
        title: 'Batalkan data kunjungan?',
        text: `Apakah anda yakin membatalkan data kunjungan ${patient_name}? `,
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
                url: "refer_visit/cancel",
                type: "post",
                dataType: "json",
                data: {
                    medical_code: medical_code,
                    invoice_id: invoice_id,
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
</script>