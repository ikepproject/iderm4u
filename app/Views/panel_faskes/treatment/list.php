<table id="datatable-treatment" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="22%">Nama</th>
            <th width="7%">Tipe</th>
            <th width="10%">ID</th>
            <th width="10%">Status</th>
            <th width="10%">Harga</th>
            <th width="20%">Keterangan</th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['treatment_name'] ?></td>
                <td><?= $data['treatment_type'] ?></td>
                <td><?= $data['treatment_code'] ?></td>
                <td>
                    <?php if ($data['treatment_status'] == 't') { ?> 
                        <span class="badge rounded-pill bg-success">Aktif</span>
                    <?php } ?>
                    <?php if ($data['treatment_status'] == 'f') { ?> 
                        <span class="badge rounded-pill bg-secondary">Nonaktif</span>
                    <?php } ?>    
                </td>
                <td>
                    <?php if ($data['treatment_discount'] == 'f' || $data['treatment_discount'] == NULL) { ?> Rp <?= rupiah( $data['treatment_price']) ?> <?php } ?>
                    <?php if ($data['treatment_discount'] == 't') { ?> <s>Rp <?= rupiah($data['treatment_price']) ?></s> -> <br> Rp <?= rupiah($data['treatment_discount_price']) ?> <br> <i class="bx bxs-offer"></i> <?= round((($data['treatment_price']-$data['treatment_discount_price'])/$data['treatment_price'])*100,2) ?> % <?php } ?>
                </td>
                <td><?= $data['treatment_description'] ?></td>
                <td>
                    <button type="button" class="btn btn-warning mb-2" onclick="edit('<?= $data['treatment_code'] ?>')">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button type="button" class="btn btn-primary mb-2" onclick="discount('<?= $data['treatment_code'] ?>')">
                        <i class="bx bxs-offer"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<div class="editmodal"></div>
<div class="discountmodal"></div>
<script>
$(document).ready(function () {
    //treatment Table
    var table_treatment = $("#datatable-treatment").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_treatment
    .buttons()
    .container()
    .appendTo("#datatable-treatment_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});

function edit(treatment_code) {
    $.ajax({
        type: "post",
        url: "treatment/formedit",
        data: {
            treatment_code: treatment_code
        },
        dataType: "json",
        success: function(response) {
            $('.editmodal').html(response.data).show();
            $('#modaledit').modal('show');
        }
    });
}

function discount(treatment_code) {
    $.ajax({
        type: "post",
        url: "treatment/formdiscount",
        data: {
            treatment_code: treatment_code
        },
        dataType: "json",
        success: function(response) {
            $('.discountmodal').html(response.data).show();
            $('#modaldiscount').modal('show');
        }
    });
}
</script>