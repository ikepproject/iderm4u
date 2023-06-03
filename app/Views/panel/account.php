<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="page-content">
        <div class="container-fluid">
        <h5 class="title">Manajemen Profile dan Akun</h5>
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <?php if ($user_role == 1011) { ?>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profile-1" role="tab">
                                <span class="d-block d-md-none">Profile</span>
                                <span class="d-none d-md-block"><i class="fas fa-user-alt mr-2"></i> Profile</span> 
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#account-1" role="tab">
                            <span class="d-block d-md-none">Akun</span>
                            <span class="d-none d-md-block"><i class="bx bx-user-circle mr-2"></i> Akun</span>   
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <?php if ($user_role == 1011) { ?>
                        <div class="tab-pane active" id="profile-1" role="tabpanel">
                            <?= form_open('patient/update', ['class' => 'formupdate']) ?>
                            <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="hidden" id="user_id" name="user_id" value="<?= $profile['user_id'] ?>">
                                        <input type="hidden" id="user_photo_old" name="user_photo_old" value="<?= $profile['user_photo'] ?>">
                                        <input type="hidden" class="form-control" id="patient_code" name="patient_code" value="<?= $profile['patient_code'] ?>" readonly>
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
                                            <select class="form-select select2-edit" id="edit_patient_gender" name="edit_patient_gender">
                                                <option value="Perempuan" <?php if ($profile['patient_gender'] == "Perempuan") echo "selected"; ?> > Perempuan </option>
                                                <option value="Laki-Laki" <?php if ($profile['patient_gender'] == "Laki-Laki") echo "selected"; ?> > Laki-Laki </option>
                                            </select>
                                            <div class="invalid-feedback error_edit_patient_gender"></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_patient_birth" class="form-label">Tanggal Lahir (cth: 1990-12-01)<code>*</code></label>
                                            <div class="input-group" id="datepicker2">
                                            <input type="text" id="edit_patient_birth" name="edit_patient_birth" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                data-provide="datepicker" data-date-autoclose="true" value="<?= $profile['patient_birth'] ?>">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            <div class="invalid-feedback error_edit_patient_birth"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_patient_type" class="form-label">Kategori Pasien <code>*</code></label>
                                            <select class="form-select select2-edit" id="edit_patient_type" name="edit_patient_type">
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
                                            <label for="edit_user_photo" class="form-label">Foto</label>
                                            <div class="avatar-sm mx-auto mb-4">
                                                <img class="rounded-circle avatar-sm" src="<?= base_url() ?>/public/assets/images/users/<?= $profile['user_photo'] ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <p>Pilih foto baru utk mengganti foto</p>
                                            <input type="file" class="form-control" id="edit_user_photo" name="edit_user_photo" onchange="edit_preview_images();" accept=".jpg,.jpeg,.png">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div style="display: inline-block;" id="image_preview_edit"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="update" name="update"><i class="bx bx-save"></i> Update Profile</button>
                                </div>
                            <?= form_close() ?>
                        </div>
                    <?php } ?>
                    <div class="tab-pane" id="account-1" role="tabpanel">
                            <?= form_open('account/update', ['class' => 'formaccount']) ?>
                            <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" id="user_id" name="user_id" value="<?= $profile['user_id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Username <code>*</code></label>
                                            <input type="text" class="form-control" value="<?= $profile['user_username'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="edit_user_nik" class="form-label">Password Lama</label>
                                            <input type="password" class="form-control" id="old_password" name="old_password" >
                                            <div class="invalid-feedback error_old_password"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="edit_user_nik" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" >
                                            <div class="invalid-feedback error_new_password"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="updateAccount" name="updateAccount"><i class="bx bx-save"></i> Update Akun</button>
                                </div>
                            <?= form_close() ?>
                    </div>
                </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    $(document).ready(function () {
        $('.select2-edit').select2({
            minimumResultsForSearch: Infinity
        });

        $('#edit_patient_address').val("<?= $profile['patient_address'] ?>");

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
                        }).then(function () {
                            window.location = '/account';
                        });
                    }
                }
            },
            });
        });

        $(".formaccount").submit(function (e) {
            e.preventDefault();
            var form_data = new FormData($('form')[1]);
            $.ajax({
            type: "post",
            url: $(this).attr("action"),
            data: form_data,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $("#updateAccount").attr("disabled", true);
                $("#updateAccount").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
                );
            },
            complete: function () {
                $("#updateAccount").removeAttr("disabled", false);
                $("#updateAccount").html("Update Akun");
            },
            success: function (response) {
                if (response.error) {

                if (response.error.old_password) {
                    $("#old_password").addClass("is-invalid");
                    $(".error_old_password").html(response.error.old_password);
                } else {
                    $("#old_password").removeClass("is-invalid");
                    $(".error_old_password").html("");
                }

                if (response.error.new_password) {
                    $("#new_password").addClass("is-invalid");
                    $(".error_new_password").html(response.error.new_password);
                } else {
                    $("#new_password").removeClass("is-invalid");
                    $(".error_new_password").html("");
                }

                } else {
                if (response.success) {
                        Swal.fire({
                        title: response.title,
                        text: response.text,
                        icon: response.icon,
                        showConfirmButton: false,
                        timer: 1500,
                        }).then(function () {
                            window.location = response.link;
                        });
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
<?= $this->endSection('isi') ?>