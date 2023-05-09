<?= $this->extend('partials/main_auth') ?>
<?= $this->section('isi') ?>
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                /* display: none; <- Crashes Chrome on hover */
                -webkit-appearance: none;
                margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
            }

            input[type=number] {
                -moz-appearance:textfield; /* Firefox */
            }
        </style>
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
                                <?= form_open('doregister', ['class' => 'formregister']) ?>
                                <?= csrf_field() ?>
                                <form class="form-horizontal">
                                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">Nama <code>*</code></label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Masukan alamat nama anda..." >
                                        <div class="invalid-feedback error_user_name"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="user_email" class="form-label">Email <code>*</code></label>
                                        <input type="email" class="form-control text-lowercase" id="user_email" name="user_email" placeholder="Masukan alamat email anda..." >
                                        <div class="invalid-feedback error_user_email"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="user_phone" class="form-label">No. WA <code>*</code> Contoh: 08123456789 
                                            <button type="button" class="btn btn-light position-relative p-0 avatar-xs rounded-circle" data-toggle="tooltip" data-placement="top" title="OTP untuk verifikasi akun anda akan dikirim via WA pada nomor yang anda daftarkan ini. Harap diisi sesuai dengan No. HP anda yang terdaftar pada WA.">
                                                <span class="avatar-title bg-transparent text-reset">
                                                    <i class="bx bxs-info-circle"></i>
                                                </span>
                                            </button>
                                        </label>
                                        <input type="number" class="form-control" id="user_phone" name="user_phone" placeholder="Masukan No. HP yang terdaftar WA">
                                        <div class="invalid-feedback error_user_phone"></div>
                                    </div>
                                        
                                    <div class="mb-3">
                                        <label for="user_faskes" class="form-label">Pilih Faskes Asal <code>*</code> </label>
                                        <select class="form-control select2-register" id="user_faskes" name="user_faskes">
                                            <option selected disabled>Pilih...</option>
                                            <?php foreach ($faskes as $key => $data) { ?>
                                                <option value="<?= $data['faskes_code'] ?>"><?= $data['faskes_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback error_user_faskes"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="user_password" class="form-label">Password <code>*</code> (Min. 8 Karakter)</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" id="user_password"  name="user_password" placeholder="Masukan password...">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            <div class="invalid-feedback error_user_password"></div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Konfirmasi Password <code>*</code></label>
                                        <input type="password" class="form-control" id="confirm_password" placeholder="Masukan ulang password..." name="confirm_password">
                                        <div class="invalid-feedback error_confirm_password"></div>
                                    </div>
                                    
                                    <!-- <label class="form-label">Konfirmasi capctha dibawah <code>*</code></label>
                                    <div class="g-recaptcha mb-3 required" data-sitekey="<?= $site_key ?>"></div> -->

                                    <div class="mb-3">
                                        <!-- <button type="button" class="btn btn-link waves-effect" data-bs-toggle="modal" data-bs-target="#TermAndCondition">
                                        Baca Syarat & Ketentuan Penggunaan.
                                        </button> -->
                                        <a href="terms-and-conditions">Baca Syarat & Ketentuan Penggunaan.</a> <br>
                                        <a href="privacy">Baca Kebijakan Privacy.</a>
                                    </div>

                                    <div class="mt-2 form-check">
                                        <input class="form-check-input" type="checkbox" name="toc" id="toc">
                                        <p class="mb-0">Dengan ini Anda menyatakan telah membaca, memahami, mengetahui, menerima, dan menyetujui seluruh informasi, syarat-syarat, dan ketentuan-ketentuan penggunaan fitur yang terdapat pada platform iDerm4U. </p>
                                    </div>
                                    
                                    <div class="mt-4 ml-4">
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
        <!-- Modal Syarat dan Ketentuan -->
        <div class="modal fade" id="TermAndCondition" tabindex="-1" aria-labelledby="TermAndConditionLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TermAndConditionLabel">Syarat & Ketentuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
        </div>

<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
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
        $('.select2-register').select2();

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
                if (response.error.user_name) {
                    $("#user_name").addClass("is-invalid");
                    $(".error_user_name").html(response.error.user_name);
                } else {
                    $("#user_name").removeClass("is-invalid");
                    $(".error_user_name").html("");
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

                if (response.error.user_faskes) {
                    $("#user_faskes").addClass("is-invalid");
                    $(".error_user_faskes").html(response.error.user_faskes);
                } else {
                    $("#user_faskes").removeClass("is-invalid");
                    $(".error_user_faskes").html("");
                }

                if (response.error.user_password) {
                    $("#user_password").addClass("is-invalid");
                    $(".error_user_password").html(response.error.user_password);
                } else {
                    $("#user_password").removeClass("is-invalid");
                    $(".error_user_password").html("");
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
                    title: response.title,
                    text: response.message,
                    icon: response.icon,
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
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
        
<!-- End Page-content -->
<?= $this->endSection('isi') ?>
