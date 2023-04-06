<table id="datatable-appointment" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Nama</th>
            <th width="6%">Status</th>
            <th width="6%">Waktu Ajuan</th>
            <th width="8%">Waktu Fix</th>
            <th width="15%">Catatan Pasien</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['patient_name'] ?></td>
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
                        <?= longdate_indo(substr($data['appointment_date_expect'],0,10)) ?>, <?= substr($data['appointment_date_expect'],12,16)?>WIB
                    <?php } ?>
                    
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],12,16)?>WIB
                    <?php } ?>
                </td>
                <td><?= $data['appointment_note_user'] ?></td>
                <td></td>
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
</script>