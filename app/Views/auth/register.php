<?= $this->extend('partials/main_auth') ?>
<?= $this->section('isi') ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Pendaftaran Akun <br> iDerm4U</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?= base_url() ?>/public/assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?= base_url() ?>/public/assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <?= form_open('api/web/auth/register', ['class' => 'formregister']) ?>
                                <?= csrf_field() ?>
                                <form class="form-horizontal">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama <code>*</code></label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukan alamat nama anda..." >
                                        <div class="invalid-feedback error_name"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <code>*</code></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan alamat email anda..." >
                                        <div class="invalid-feedback error_email"></div>
                                    </div>
                                        
                                    <div class="mb-3">
                                        <label for="faskes" class="form-label">Pilih Faskes Asal <code>*</code> </label>
                                        <select class="form-select" id="faskes" name="faskes">
                                            <option selected disabled>Pilih...</option>
                                            <?php foreach ($faskes as $key => $data) { ?>
                                                <option value="<?= $data['faskes_code'] ?>"><?= $data['faskes_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback error_faskes"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <code>*</code></label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="password"  name="password" placeholder="Masukan password...">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            <div class="invalid-feedback error_password"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Konfirmasi Password <code>*</code></label>
                                        <input type="password" class="form-control" id="confirm_password" placeholder="Ketik ulang password..." name="confirm_password">
                                        <div class="invalid-feedback error_confirm_password"></div>
                                    </div>

                                    <div class="mt-4 form-check">
                                        <input class="form-check-input" type="checkbox" name="toc" id="toc">
                                        <p class="mb-0">Dengan ini Anda menyatakan telah membaca, memahami, mengetahui, menerima, dan menyetujui seluruh informasi, syarat-syarat, dan ketentuan-ketentuan penggunaan fitur yang terdapat pada platform iDerm4U. <br> <a href="#" class="text-primary">Baca Syarat & Ketentuan Penggunaan.</a></p>
                                    </div>

                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-ligh" type="submit" id="registration" name="registration" disabled>Register</button>
                                    </div>
                                </form>
                                <?= form_close() ?>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Anda sudah memiliki akun ? <a href="login" class="fw-medium text-primary"> Login</a> </p>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

<script>
    // Register - Checked TOC
    $("#toc").click(function () {
        //check if checkbox is checked
        if ($(this).is(":checked")) {
            $("#registration").removeAttr("disabled"); //enable input
        } else {
            $("#registration").attr("disabled", true); //disable input
        }
    });
    $(document).ready(function () {
        // Register
        $(".formregister").submit(function (e) {
            e.preventDefault();
            $.ajax({
            type: "post",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                $("#registration").attr("disabled", true);
                $("#registration").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
                );
            },
            complete: function () {
                $("#registration").removeAttr("disabled", false);
                $("#registration").html("Daftar");
            },
            success: function (response) {
                if (response.error) {
                if (response.error.name) {
                    $("#name").addClass("is-invalid");
                    $(".error_name").html(response.error.name);
                } else {
                    $("#name").removeClass("is-invalid");
                    $(".error_name").html("");
                }

                if (response.error.email) {
                    $("#email").addClass("is-invalid");
                    $(".error_email").html(response.error.email);
                } else {
                    $("#email").removeClass("is-invalid");
                    $(".error_email").html("");
                }

                if (response.error.faskes) {
                    $("#faskes").addClass("is-invalid");
                    $(".error_faskes").html(response.error.faskes);
                } else {
                    $("#faskes").removeClass("is-invalid");
                    $(".error_faskes").html("");
                }

                if (response.error.password) {
                    $("#password").addClass("is-invalid");
                    $(".error_password").html(response.error.password);
                } else {
                    $("#password").removeClass("is-invalid");
                    $(".error_password").html("");
                }

                if (response.error.confirm_password) {
                    $("#confirm_password").addClass("is-invalid");
                    $(".error_confirm_password").html(response.error.confirm_password);
                } else {
                    $("#confirm_password").removeClass("is-invalid");
                    $(".error_confirm_password").html("");
                }
                } else {
                Swal.fire({
                    title: "Success!",
                    text: "Berhasil daftar, Redirect...",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1250,
                }).then(function () {
                    window.location = response.data.link;
                });
                }
            },
            });
            return false;
        });
    });
    
</script>
        
<!-- End Page-content -->
<?= $this->endSection('isi') ?>
