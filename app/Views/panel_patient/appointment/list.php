<table id="datatable-appointment" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="5%">ID</th>
            <th width="5%">Status</th>
            <th width="4%">Jenis</th>
            <th width="5%">Tujuan</th>
            <th width="6%">Waktu Pengajuan</th>
            <th width="8%">Waktu Final</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['appointment_code'] ?></td>
                <td>
                    <?php if ($data['appointment_status'] == 'Diajukan') { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_status'] == 'Dijadwalkan') { ?> 
                        <span class="badge bg-success">Dijadwalkan</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($data['appointment_type'] == 'Lokal') { ?> 
                        <span class="badge bg-info">Kunjungan </span>
                    <?php } ?>
                    <?php if ($data['appointment_type'] == 'Teledermatologi') { ?> 
                        <span class="badge bg-warning">Rujuk Teledermatologi </span>
                    <?php } ?>
                    <?php if ($data['appointment_type'] == 'Kunjungan') { ?> 
                        <span class="badge bg-warning">Rujuk Kunjungan </span>
                    <?php } ?>
                </td>
                <td><?= $data['faskes_name'] ?> </td>
                <td>
                    <?php if ($data['appointment_date_expect'] != NULL) { ?> 
                        <?= longdate_indo(substr($data['appointment_date_expect'],0,10)) ?> <?= substr($data['appointment_date_expect'],11,5)?>
                    <?php } ?>
                    
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],11,5)?>
                    <?php } ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['appointment_id'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <?php if ($data['appointment_status'] == 'Diajukan') { ?> 
                        <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['appointment_id'] ?>', '<?= $data['appointment_code'] ?>')">
                            <i class="bx bx-x"></i>
                        </button>
                    <?php } ?>
                    
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="detailmodal"></div>

<script>
$(document).ready(function () {
    //Patient Table
    var table_appointment = $("#datatable-appointment").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_appointment
    .buttons()
    .container()
    .appendTo("#datatable-appointment_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});

function detail(appointment_id) {
    $.ajax({
        type: "post",
        url: "appointment/formdetail",
        data: {
            appointment_id: appointment_id
        },
        dataType: "json",
        success: function(response) {
            $('.detailmodal').html(response.data).show();
            $('#modaldetail').modal('show');
        }
    });
}


function cancel(appointment_id, appointment_code) {
    Swal.fire({
        title: 'Batalkan pengajuan appointment kunjungan?',
        text: `Apakah anda yakin membatalkan appointment kunjungan ${appointment_code}? `,
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
                url: "appointment/cancel",
                type: "post",
                dataType: "json",
                data: {
                    appointment_id: appointment_id,
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
                            window.location.reload();
                        });
                    }
                }
            });
        }
    })
}
</script>