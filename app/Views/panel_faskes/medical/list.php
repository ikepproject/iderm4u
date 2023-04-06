<table id="datatable-medical" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="11%">Pasien</th>
            <th width="6%">ID</th>
            <th width="7%">Status</th>
            <th width="10%">Jenis</th>
            <th width="8%">Waktu</th>
            <th width="15%">Keterangan</th>
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
                <td><?= $data['medical_code'] ?></td>
                <td>
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        <span class="badge rounded-pill bg-success">Selesai</span>
                    <?php } ?>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 
                        <span class="badge rounded-pill bg-secondary">Proses</span>
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
                    <?php if ($data['medical_refer_type'] != NULL && $data['medical_refer_code'] == NULL) { ?> 
                        <span class="badge bg-danger">Dirujuk</span>
                    <?php } ?>
                </td>
                <td><?= longdate_indo(substr($data['medical_create'],0,10)) ?></td>
                <td><?= $data['medical_description'] ?></td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['medical_code'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <?php if ($data['medical_status'] == 'Proses') { ?> 

                        <?php if ($data['invoice_midtrans'] == NULL) { ?> 
                            <button type="button" class="btn btn-danger mb-2" onclick="cancel('<?= $data['medical_code'] ?>', '<?= $data['patient_name'] ?>')">
                            <i class="bx bx-x"></i>
                            </button>
                        <?php } ?> 

                        <a type="button" class="btn btn-success mb-2" href="<?= base_url('transaction/checkout/' . $data['medical_code']) ?>">
                            <i class="bx bx-check"></i>
                        </a>
                    <?php } ?> 
                    
                    <?php if ($data['medical_status'] == 'Selesai') { ?> 
                        <a type="button" class="btn btn-secondary mb-2" href="<?= base_url('transaction/invoice/' . $data['medical_code']) ?>">
                            <i class="bx bx-receipt"></i>
                        </a>
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


function cancel(medical_code, patient_name) {
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
                url: "medical/cancel",
                type: "post",
                dataType: "json",
                data: {
                    medical_code: medical_code,
                    modul: 'Lokal'
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
                        datatable_medical();
                    }
                }
            });
        }
    })
}
</script>