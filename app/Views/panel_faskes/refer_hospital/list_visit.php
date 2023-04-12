<table id="datatable-refer" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="9%">Faskes Asal</th>
            <th width="7%">Status</th>
            <th width="10%">Jenis</th>
            <th width="8%">Jadwal Fix</th>
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
                <td><?= $data['faskes_name'] ?></td>
                <td>
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        <span class="badge rounded-pill bg-success">Selesai</span>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 
                        <span class="badge rounded-pill bg-secondary">Proses</span>
                    <?php } ?>
                    <?php if ($data['appointment_type'] == 'Teledermatologi') { ?> 
                        <?php if ($data['invoice_status'] == 'SUCCEEDED') { ?> 
                        <br> Pembayaran: <span class="badge rounded-pill bg-success">SUCCEEDED</span>
                        <?php } ?>
                        <?php if ($data['invoice_status'] == 'PENDING') { ?> 
                        <br> Pembayaran: <span class="badge rounded-pill bg-secondary">PENDING</span>
                        <?php } ?> 
                    <?php } ?>  
                </td>
                <td>
                    <?php if ($data['appointment_type'] == 'Kunjungan') { ?> 
                        <span class="badge bg-success">Kunjungan</span>
                    <?php } ?>
                    <?php if ($data['appointment_type'] == 'Teledermatologi') { ?> 
                        <span class="badge bg-primary">Teledermatologi</span>
                    <?php } ?>  
                </td>
                <td>
                    <?php if ($data['appointment_date_fix'] == NULL) { ?> 
                        <span class="badge bg-secondary">Diajukan</span>
                    <?php } ?>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 
                        <span class="badge bg-success">Dijadwalkan</span>
                        <?= longdate_indo(substr($data['appointment_date_fix'],0,10)) ?>, <?= substr($data['appointment_date_fix'],12,16)?>WIB
                    <?php } ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['medical_code'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <?php if ($data['appointment_date_fix'] == NULL && $data['invoice_status'] == 'SUCCEEDED') { ?> 
                        <button type="button" class="btn btn-success mb-2" onclick="accept('<?= $data['medical_code'] ?>')">
                            <i class="bx bx-calendar-check"></i>
                        </button>
                    <?php } ?>
                    <?php if ($data['appointment_date_fix'] != NULL) { ?> 

                        <?php if ($data['medical_status'] == 'Proses') { ?>
                            <button type="button" class="btn btn-warning mb-2" onclick="edit('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>')">
                            <i class="bx bx-edit"></i>
                            </button>
                        <?php } ?>
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
</script>