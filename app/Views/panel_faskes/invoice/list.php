<table id="datatable-refer" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="5%">ID Invoice</th>
            <th width="7%">Status</th>
            <th width="10%">Metode Bayar</th>
            <th width="8%">Jumlah</th>
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
                <td><?= $data['invoice_code'] ?></td>
                <td>
                    <?php if ($data['invoice_status'] == 'SUCCEEDED') { ?> 
                        <span class="badge rounded-pill bg-success">SUKSES</span>
                    <?php } ?>
                    <?php if ($data['invoice_status'] == 'PENDING') { ?> 
                        <span class="badge rounded-pill bg-secondary">PENDING</span>
                    <?php } ?> 
                    <?php if ($data['invoice_status'] == 'FAILED') { ?> 
                        <span class="badge rounded-pill bg-danger">FAILED</span>
                    <?php } ?> 
                </td>
                <td>
                    <?php if ($data['invoice_method'] == 'Cash') { ?> 
                        <span class="badge bg-success">Cash</span>
                    <?php } ?>
                    <?php if ($data['invoice_method'] == 'VA') { ?> 
                        <span class="badge bg-primary">Virtual Account</span>
                    <?php } ?> 
                    <?php if ($data['invoice_method'] == 'E-WALLET') { ?> 
                        <span class="badge bg-warning">Gopay</span>
                    <?php } ?>
                    <?php if ($data['invoice_method'] == 'QR') { ?> 
                        <span class="badge bg-secondary">QRIS</span>
                    <?php } ?>
                </td>
                <td>Rp <?= rupiah($data['invoice_amount']) ?></td>
                <td>
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

</script>