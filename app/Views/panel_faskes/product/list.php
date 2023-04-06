<table id="datatable-product" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="15%">Nama</th>
            <th width="10%">ID</th>
            <th width="10%">Status</th>
            <th width="10%">Harga</th>
            <th width="10%">Qty</th>
            <th width="10%">Unit</th>
            <!-- <th width="10%">Create/Edit</th> -->
            <th width="20%">Keterangan</th>
            <th width="5%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['product_name'] ?></td>
                <td><?= $data['product_code'] ?></td>
                <td>
                    <?php if ($data['product_status'] == 't') { ?> 
                        <span class="badge rounded-pill bg-success">Aktif</span>
                    <?php } ?>
                    <?php if ($data['product_status'] == 'f') { ?> 
                        <span class="badge rounded-pill bg-secondary">Nonaktif</span>
                    <?php } ?>    
                </td>
                <td>Rp <?= rupiah($data['product_price']) ?></td>
                <td><?= $data['product_qty'] ?></td>
                <td><?= $data['product_unit'] ?></td>
                <!-- <td><?= $data['product_create'] ?>/ <br> <?= $data['product_edit'] ?></td> -->
                <td><?= $data['product_description'] ?></td>
                <td>
                    <button type="button" class="btn btn-warning mb-2" onclick="edit('<?= $data['product_code'] ?>')">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button type="button" class="btn btn-primary mb-2" onclick="stock('<?= $data['product_code'] ?>')">
                        <i class="bx bx-package"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<div class="editmodal"></div>
<div class="stockmodal"></div>

<script>
$(document).ready(function () {
    //product Table
    var table_product = $("#datatable-product").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_product
    .buttons()
    .container()
    .appendTo("#datatable-product_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});

function edit(product_code) {
    $.ajax({
        type: "post",
        url: "product/formedit",
        data: {
            product_code: product_code
        },
        dataType: "json",
        success: function(response) {
            $('.editmodal').html(response.data).show();
            $('#modaledit').modal('show');
        }
    });
}

function stock(product_code) {
    $.ajax({
        type: "post",
        url: "product/formstock",
        data: {
            product_code: product_code
        },
        dataType: "json",
        success: function(response) {
            $('.stockmodal').html(response.data).show();
            $('#modalstock').modal('show');
        }
    });
}
</script>