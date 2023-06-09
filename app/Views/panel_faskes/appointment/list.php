<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<table id="datatable-appointment" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="7%">ID Appointment</th>
            <th width="7%">Nama</th>
            <th width="6%">Jenis</th>
            <th width="6%">Status</th>
            <th width="6%">Waktu Pengajuan</th>
            <th width="8%">Waktu Final</th>
            <th width="3%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['appointment_code'] ?></td>
                <td><?= $data['patient_name'] ?></td>
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
                <td>
                    <?php if ($data['appointment_status'] == 'Diajukan') { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_status'] == 'Dijadwalkan') { ?> 
                        <span class="badge bg-success">Dijadwalkan</span>
                    <?php } ?>
                </td>
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
                    <?php if ($data['appointment_type'] == 'Lokal' && $data['appointment_status'] == 'Diajukan') { ?> 
                        <button type="button" class="btn btn-success mb-2" onclick="accept('<?= $data['appointment_id'] ?>')">
                            <i class="bx bx-calendar-check"></i>
                        </button>
                    <?php } ?>
                    <?php if ($data['appointment_type'] == 'Lokal' && $data['appointment_status'] == 'Dijadwalkan') { ?> 
                        <button type="button" class="btn btn-warning mb-2" onclick="accept('<?= $data['appointment_id'] ?>')">
                            <i class="bx bx-calendar-check"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="acceptmodal"></div>
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

function accept(appointment_id) {
    $.ajax({
        type: "post",
        url: "appointment/formaccept",
        data: {
            appointment_id: appointment_id,
            modul: 'lokal'
        },
        dataType: "json",
        success: function(response) {
            $('.acceptmodal').html(response.data).show();
            $('#modalaccept').modal('show');
        }
    });
}

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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>