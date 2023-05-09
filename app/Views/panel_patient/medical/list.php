<table id="datatable-medical" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="6%">ID</th>
            <th width="8%">Waktu</th>
            <th width="5%">Faskes</th>
            <th width="7%">Status</th>
            <th width="7%">Pembayaran</th>
            <th width="10%">Jenis</th>
            <th width="7%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['medical_code'] ?></td>
                <td><?= longdate_indo(substr($data['medical_create'],0,10)) ?></td>
                <td><?= $data['faskes_name'] ?></td>
                <td>
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        <span class="badge rounded-pill bg-success">Selesai</span>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 
                        <span class="badge rounded-pill bg-secondary">Proses</span>
                    <?php } ?> 
                </td>
                <td>
                    Metode: <?= $data['invoice_method'] ?> <br>
                    Status:
                    <?php if ($data['invoice_status'] == 'SUCCEEDED') { ?> 
                        <span class="badge rounded-pill bg-success">Terbayar</span>
                    <?php } ?>
                    <?php if ($data['invoice_status'] == 'PENDING') { ?> 
                        <span class="badge rounded-pill bg-secondary">-</span>
                    <?php } ?> 
                </td>
                <td>
                    <?php if ($data['medical_type'] == 'Treatment') { ?> 
                        <span class="badge bg-primary">Treatment</span>
                    <?php } ?>
                    <?php if ($data['medical_type'] == 'Product') { ?> 
                        <span class="badge bg-success">Beli Produk</span>
                    <?php } ?> 
                    <?php if ($data['medical_type'] == 'Treatment-Product') { ?> 
                        <div><span class="badge bg-primary">Treatment</span> <span class="badge bg-success">Beli Produk</span></div>
                    <?php } ?> 
                    <?php if ($data['medical_type'] == 'Lainnya') { ?> 
                        <span class="badge bg-warning">Lainnya</span>
                    <?php } ?> 
                    <?php if ($data['medical_refer_type'] != NULL && $data['medical_refer_origin'] != NULL) { ?> 
                        <span class="badge bg-danger">Rujuk <?= $data['medical_refer_type'] ?></span>
                    <?php } ?>
                </td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['medical_code'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    
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

<div class="detailmodal"></div>
<div class="diagnosemodal"></div>
<script>
$(document).ready(function () {
    //Patient Table
    var table_medical = $("#datatable-medical").DataTable({
    stateSave: true,
    lengthChange: true,
    processing: true,
    language: {
        processing: '<i class="fa fa-spinner fa-spin"></i> Loading...'
    },
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_medical
    .buttons()
    .container()
    .appendTo("#datatable-medical_wrapper .col-md-6:eq(0)");

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