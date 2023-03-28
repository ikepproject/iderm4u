<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('patient/update', ['class' => 'formupdate']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <input type="hidden" id="user_id" name="user_id" value="<?= $profile['user_id'] ?>">
                        <input type="hidden" id="user_photo_old" name="user_photo_old" value="<?= $profile['user_photo'] ?>">
                        <div class="mb-3">
                            <label for="patient_code" class="form-label">ID Pasien <code>*</code></label>
                            <input type="text" class="form-control" id="patient_code" name="patient_code" value="<?= $profile['patient_code'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_name" class="form-label">Nama <code>*</code></label>
                            <input type="text" class="form-control" id="edit_patient_name" name="edit_patient_name" value="<?= $profile['patient_name'] ?>">
                            <div class="invalid-feedback error_edit_patient_name"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_user_email" class="form-label">Email Pasien <code>*</code></label>
                            <input type="email" class="form-control" id="edit_user_email" name="edit_user_email" value="<?= $profile['user_email'] ?>">
                            <div class="invalid-feedback error_edit_user_email"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_user_phone" class="form-label">No. WA <code>*</code></label>
                            <input type="number" class="form-control" id="edit_user_phone" name="edit_user_phone" value="<?= $profile['user_phone'] ?>">
                            <div class="invalid-feedback error_edit_user_phone"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_gender" class="form-label">Jenis Kelamin <code>*</code></label>
                            <select class="form-select" id="edit_patient_gender" name="edit_patient_gender">
                                <option value="Perempuan" <?php if ($profile['patient_gender'] == "Perempuan") echo "selected"; ?> > Perempuan </option>
                                <option value="Laki-Laki" <?php if ($profile['patient_gender'] == "Laki-Laki") echo "selected"; ?> > Laki-Laki </option>
                            </select>
                            <div class="invalid-feedback error_edit_patient_gender"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_birth" class="form-label">Tanggal Lahir <code>*</code></label>
                            <input type="date" class="form-control"  id="edit_patient_birth" name="edit_patient_birth" value="<?= $profile['patient_birth'] ?>">
                            <div class="invalid-feedback error_edit_patient_birth"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_type" class="form-label">Kategori Pasien <code>*</code></label>
                            <select class="form-select" id="edit_patient_type" name="edit_patient_type">
                                <option value="Umum" <?php if ($profile['patient_type'] == "Umum") echo "selected"; ?> >Umum</option>
                                <option value="Eksekutif" <?php if ($profile['patient_type'] == "Eksekutif") echo "selected"; ?> >Eksekutif</option>
                                <option value="BPJS" <?php if ($profile['patient_type'] == "BPJS") echo "selected"; ?> >BPJS</option>
                            </select>
                            <div class="invalid-feedback error_edit_patient_type"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="edit_user_nik" class="form-label">NIK</label>
                            <input type="number" class="form-control" id="edit_user_nik" name="edit_user_nik" value="<?= $profile['user_nik'] ?>" >
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="edit_patient_address" name="edit_patient_address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_patient_other" class="form-label">Keterangan Lain</label>
                            <textarea class="form-control" id="edit_patient_other" name="edit_patient_other"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_user_photo" class="form-label">Ganti foto</label>
                            <p>Pilih foto baru utk mengganti foto</p>
                            <input type="file" class="form-control" id="edit_user_photo" name="edit_user_photo" onchange="edit_preview_images();" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="mb-3">
                            <div class="avatar-sm mx-auto mb-4">
                                <img class="rounded-circle avatar-sm" src="<?= base_url() ?>/public/assets/images/users/<?= $profile['user_photo'] ?>" alt="">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div style="display: inline-block;" id="image_preview_edit"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="update" name="update"><i class="bx bx-save"></i> Update Data</button>
                </div>
                <?= form_close() ?>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function () {
        $('#edit_patient_address').val("<?= $profile['patient_address'] ?>");
        $('#edit_patient_other').val("<?= $profile['patient_other'] ?>");

        $(".formupdate").submit(function (e) {
        e.preventDefault();
        var form_data = new FormData($('form')[0]);
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: form_data,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#update").attr("disabled", true);
            $("#update").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#update").removeAttr("disabled", false);
            $("#update").html("Update Data");
        },
        success: function (response) {
            if (response.error) {

            if (response.error.edit_patient_name) {
                $("#edit_patient_name").addClass("is-invalid");
                $(".error_edit_patient_name").html(response.error.edit_patient_name);
            } else {
                $("#edit_patient_name").removeClass("is-invalid");
                $(".error_edit_patient_name").html("");
            }

            if (response.error.edit_patient_gender) {
                $("#edit_patient_gender").addClass("is-invalid");
                $(".error_edit_patient_gender").html(response.error.edit_patient_gender);
            } else {
                $("#edit_patient_gender").removeClass("is-invalid");
                $(".error_edit_patient_gender").html("");
            }

            if (response.error.edit_patient_birth) {
                $("#edit_patient_birth").addClass("is-invalid");
                $(".error_edit_patient_birth").html(response.error.edit_patient_birth);
            } else {
                $("#edit_patient_birth").removeClass("is-invalid");
                $(".error_edit_patient_birth").html("");
            }

            if (response.error.edit_patient_type) {
                $("#edit_patient_type").addClass("is-invalid");
                $(".error_edit_patient_type").html(response.error.edit_patient_type);
            } else {
                $("#edit_patient_type").removeClass("is-invalid");
                $(".error_edit_patient_type").html("");
            }

            if (response.error.edit_user_email) {
                $("#edit_user_email").addClass("is-invalid");
                $(".error_edit_user_email").html(response.error.edit_user_email);
            } else {
                $("#edit_user_email").removeClass("is-invalid");
                $(".error_edit_user_email").html("");
            }

            if (response.error.edit_user_phone) {
                $("#edit_user_phone").addClass("is-invalid");
                $(".error_edit_user_phone").html(response.error.edit_user_phone);
            } else {
                $("#edit_user_phone").removeClass("is-invalid");
                $(".error_edit_user_phone").html("");
            }

            } else {
            if (response.success) {
                Swal.fire({
                title: "Berhasil!",
                text: response.success,
                icon: "success",
                showConfirmButton: false,
                timer: 1500,
                });
                $("#modaledit").modal("hide");
                datatable_patient();
            }
            }
        },
        });
        });
    });

    function edit_preview_images() 
    {
        var total_file=document.getElementById("edit_user_photo").files.length;
        for(var i=0;i<total_file;i++)
        {
        $('#image_preview_edit').append("<img style='object-fit:scale-down;width:100px;height:100px; margin-right:10px;' class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
    };
</script>