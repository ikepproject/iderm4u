<table id="datatable-order" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <?php if ($user_role != 1011) { ?> 
                <th width="11%">Pasien</th>
            <?php } ?>
            <th width="6%">ID</th>
            <th width="6%">Invoice Status</th>
            <th width="8%">Waktu Order</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <?php if ($user_role != 1011) { ?>
                    <td><?= $data['patient_name'] ?></td>
                <?php } ?>
                <td><?= $data['medical_code'] ?></td>
                <td>
                    <?php if ($data['invoice_status'] == 'SUCCEEDED') { ?> 
                        <span class="badge rounded-pill bg-success">SUCCEEDED</span>
                    <?php } ?>
                    <?php if ($data['invoice_status'] == 'PENDING') { ?> 
                        <span class="badge rounded-pill bg-secondary">PENDING</span>
                    <?php } ?> 
                </td>
                <td><?= longdate_indo(substr($data['medical_create'],0,10)) ?>, <?= substr($data['medical_create'],11,5)?></td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['medical_code'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <?php if ($user_role == 1011) { ?> 
                        <?php if ($data['medical_status'] == 'Proses') { ?> 
                            <a type="button" class="btn btn-success mb-2" href="<?= base_url('transaction/checkout/' . $data['medical_code']) ?>">
                                <i class="bx bx-check"></i>
                            </a>
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
    var table_order = $("#datatable-order").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_order
    .buttons()
    .container()
    .appendTo("#datatable-order_wrapper .col-md-6:eq(0)");

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