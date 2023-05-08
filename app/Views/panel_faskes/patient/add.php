<!-- Modal -->
<div class="modal fade" id="modaladd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <?= form_open('patient/create', ['class' => 'formadd']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <input type="hidden" id="user_faskes" name="user_faskes" value="<?= $user['user_faskes'] ?>">
                        <div class="mb-3">
                            <label for="patient_name" class="form-label">Nama <code>*</code></label>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Masukan nama pasien..." >
                            <div class="invalid-feedback error_patient_name"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_email" class="form-label">Email Pasien <code>*</code></label>
                            <input type="email" class="form-control text-lowercase" id="user_email" name="user_email" placeholder="Masukan email pasien..." >
                            <div class="invalid-feedback error_user_email"></div>
                        </div>
                        <div class="mb-3">
                            <label for="user_phone" class="form-label">No. WA <code>*</code></label>
                            <input type="number" class="form-control" id="user_phone" name="user_phone" placeholder="Masukan No. WA pasien..." >
                            <div class="invalid-feedback error_user_phone"></div>
                        </div>
                        <div class="mb-3">
                            <label for="patient_gender" class="form-label">Jenis Kelamin <code>*</code></label>
                            <select class="form-select" id="patient_gender" name="patient_gender">
                                <option selected disabled>Pilih...</option>
                                <option value="Perempuan">Perempuan</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                            </select>
                            <div class="invalid-feedback error_patient_gender"></div>
                        </div>
                        <div class="mb-3">
                            <label for="patient_birth" class="form-label">Tanggal Lahir (cth: 1990-12-01)<code>*</code></label>
                            <div class="input-group" id="datepicker2">
                              <input type="text" id="patient_birth" name="patient_birth" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                  data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                  data-provide="datepicker" data-date-autoclose="true">
                              <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                              <div class="invalid-feedback error_patient_birth"></div>
                            </div>
                            
                        </div>
                        <div class="mb-3">
                            <label for="patient_type" class="form-label">Kategori Pasien <code>*</code></label>
                            <select class="form-select" id="patient_type" name="patient_type">
                                <option selected disabled>Pilih...</option>
                                <option value="Umum">Umum</option>
                                <option value="Eksekutif">Eksekutif</option>
                                <option value="BPJS">BPJS</option>
                            </select>
                            <div class="invalid-feedback error_patient_type"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="user_nik" class="form-label">NIK</label>
                            <input type="number" class="form-control" id="user_nik" name="user_nik" placeholder="Masukan nik pasien..." >
                        </div>
                        <div class="mb-3">
                            <label for="patient_address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="patient_address" name="patient_address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="patient_other" class="form-label">Keterangan Lain</label>
                            <textarea style="height: 150px;" class="form-control" id="patient_other" name="patient_other"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="user_photo" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="user_photo" name="user_photo" onchange="preview_images();" name="user_photo" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="mb-3">
                            <div style="display: inline-block;" id="image_preview"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="save" name="save"><i class="bx bx-save"></i> Tambah Data</button>
                </div>
                <?= form_close() ?>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        $(".formadd").submit(function (e) {
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
            $("#save").attr("disabled", true);
            $("#save").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#save").removeAttr("disabled", false);
            $("#save").html("Tambah Data");
        },
        success: function (response) {
            if (response.error) {

            if (response.error.patient_name) {
                $("#patient_name").addClass("is-invalid");
                $(".error_patient_name").html(response.error.patient_name);
            } else {
                $("#patient_name").removeClass("is-invalid");
                $(".error_patient_name").html("");
            }

            if (response.error.user_email) {
                $("#user_email").addClass("is-invalid");
                $(".error_user_email").html(response.error.user_email);
            } else {
                $("#user_email").removeClass("is-invalid");
                $(".error_user_email").html("");
            }

            if (response.error.user_phone) {
                $("#user_phone").addClass("is-invalid");
                $(".error_user_phone").html(response.error.user_phone);
            } else {
                $("#user_phone").removeClass("is-invalid");
                $(".error_user_phone").html("");
            }

            if (response.error.patient_gender) {
                $("#patient_gender").addClass("is-invalid");
                $(".error_patient_gender").html(response.error.patient_gender);
            } else {
                $("#patient_gender").removeClass("is-invalid");
                $(".error_patient_gender").html("");
            }

            if (response.error.patient_birth) {
                $("#patient_birth").addClass("is-invalid");
                $(".error_patient_birth").html(response.error.patient_birth);
            } else {
                $("#patient_birth").removeClass("is-invalid");
                $(".error_patient_birth").html("");
            }

            if (response.error.patient_type) {
                $("#patient_type").addClass("is-invalid");
                $(".error_patient_type").html(response.error.patient_type);
            } else {
                $("#patient_type").removeClass("is-invalid");
                $(".error_patient_type").html("");
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
                $("#modaladd").modal("hide");
                datatable_patient();
            }
            }
        },
        });
        });
    });
    function preview_images() 
    {
        var total_file=document.getElementById("user_photo").files.length;
        for(var i=0;i<total_file;i++)
        {
        $('#image_preview').append("<img style='object-fit:scale-down;width:100px;height:100px; margin-right:10px;' class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
    };
</script>