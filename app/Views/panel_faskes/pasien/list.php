<table id="datatable-patient" class="table table-striped table-bordered dt-responsive nowrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width="2%">#</th>
            <th width="8%">ID</th>
            <th width="15%">Nama</th>
            <th width="10%">Jenis Kelamin</th>
            <th width="8%">Usia</th>
            <th width="8%">Kategori</th>
            <th width="8%">No. HP</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tbody>
    <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <tr>
                <td><?= $nomor ?></td>
                <td><?= $data['patient_code'] ?></td>
                <td><?= $data['patient_name'] ?></td>
                <td><?= $data['patient_gender'] ?></td>
                <td><?= umur($data['patient_birth']) ?> Thn</td>
                <td><?= $data['patient_type'] ?></td>
                <td><?= $data['patient_phone'] ?></td>
                <td>
                    <button type="button" class="btn btn-primary mb-2" onclick="detail('<?= $data['user_id'] ?>')">
                        <i class="bx bx-detail"></i>
                    </button>
                    <button type="button" class="btn btn-warning mb-2" onclick="edit('<?= $data['user_id'] ?>')">
                        <i class="bx bx-edit"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-danger mb-2" onclick="del('<?= $data['user_id'] ?>', '<?= $data['patient_code'] ?>' ,'<?= $data['user_name'] ?>')">
                        <i class="bx bx-trash"></i>
                    </button> -->
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<script>
$(document).ready(function () {
    //Patient Table
    var table_patient = $("#datatable-patient").DataTable({
    stateSave: true,
    lengthChange: true,
    lengthMenu: [
        [25, 70, 100, -1],
        [25, 70, 100, "All"],
    ],
    buttons: ["copy", "excel", "pdf"],
    });

    table_patient
    .buttons()
    .container()
    .appendTo("#datatable-patient_wrapper .col-md-6:eq(0)");

    $(".dataTables_length select").addClass("form-select form-select-sm");
});

function detail(user_id) {
    $.ajax({
        type: "post",
        url: "patient/formdetail",
        data: {
            user_id: user_id
        },
        dataType: "json",
        success: function(response) {
            $('.detailmodal').html(response.data).show();
            $('#modaldetail').modal('show');
        }
    });
}

function edit(user_id) {
    $.ajax({
        type: "post",
        url: "patient/formedit",
        data: {
            user_id: user_id
        },
        dataType: "json",
        success: function(response) {
            $('.editmodal').html(response.data).show();
            $('#modaledit').modal('show');
        }
    });
}

function del(user_id, patient_code, user_name) {
    Swal.fire({
        title: 'Hapus data?',
        text: `Apakah anda yakin menghapus data ${user_name}? `,
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
                url: "<?= site_url('patient/delete') ?>",
                type: "post",
                dataType: "json",
                data: {
                    user_id: user_id,
                    patient_code: patient_code
                },
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: response.icon,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        datatable_patient();
                    }
                }
            });
        }
    })
}
</script>