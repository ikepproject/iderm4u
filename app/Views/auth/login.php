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
                                    <h5 class="text-primary">Selamat Datang di iDerm4U</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img width="174px" height="113px" src="<?= base_url()?>/public/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="auth-logo">
                            <a href="/" class="auth-logo-light">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img width=34px height=34px src="<?= base_url()?>/public/assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>

                            <a href="/" class="auth-logo-dark">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img width=34px height=34px src="<?= base_url()?>/public/assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        <div class="p-2">
                            <?= form_open('dologin', ['class' => 'formlogin']) ?>
                            <?= csrf_field() ?>
                            <form class="form-horizontal">

                                <div class="mb-3">
                                    <label for="user_username" class="form-label">Username <code>*</code></label>
                                    <input type="text" class="form-control" name="user_username" placeholder="Masukan username anda...">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password <code>*</code></label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Masukan password anda..." aria-label="Password" aria-describedby="password-addon" name="user_password">
                                        <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                </div>
                                
                                <label class="form-label">Konfirmasi captcha dibawah <code>*</code></label>
                                <div class="g-recaptcha mb-3" data-sitekey="<?= $site_key ?>"></div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>

                                <div class="mt-3 d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit" id="login" name="login">Login</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="" class="text-muted"><i class="mdi mdi-lock me-1"></i> Lupa password anda?</a>
                                </div>
                            </form>
                            <?= form_close() ?>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <div>
                        <p>Belum terdaftar di iDerm4U? <a href="register" class="fw-medium text-primary"> Register sekarang </a> </p>
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $(document).ready(function () {
    // Login
    $(".formlogin").submit(function (e) {
        e.preventDefault();
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#login").attr("disabled", true);
            $("#login").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#login").removeAttr("disabled", false);
            $("#login").html("Login");
        },
        success: function (response) {
            if (response.success == false) {
            Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error",
                showConfirmButton: false,
                timer: 1350,
            });
            }
            if (response.success == true) {
            Swal.fire({
                title: "Success!",
                text: "Barhasil login, Redirect...",
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

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
</script>

<!-- End Page-content -->
<?= $this->endSection('isi') ?>