<!-- Modal -->
<div class="modal fade" id="modaladd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <div class="modal-body">
                <?= form_open('appointment-create', ['class' => 'formsave']) ?>
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Pasien</label>
                    <input type="text" class="form-control" value="<?= $user_name  ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Estimasi Tgl Kunjungan Pasien</label>
                    <div class="input-group" id="datepicker2">
                        <input type="text" id="appointment_date_expect" name="appointment_date_expect" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                            data-provide="datepicker" data-date-autoclose="true">
                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        <div class="invalid-feedback error_appointment_date_expect"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan Pengantar</label>
                    <textarea style="height: 150px;" type="text" class="form-control" id="appointment_note_user" name="appointment_note_user"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="save" name="save"><i class="bx bx-calendar-check"></i> Ajukan Appointment</button>
                </div>
            </div>
            <?= form_close() ?>
        </div><!-- /.modal-content -->
        
       
    </div><!-- /.modal-dialog -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function () {

    $(".formsave").submit(function (e) {
        e.preventDefault();
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: {
            appointment_date_expect: $('input#appointment_date_expect').val(),
            appointment_note_user: $('textarea#appointment_note_user').val(),
        },
        // processData: false,
        // contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#save").attr("disabled", true);
            $("#save").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#save").removeAttr("disabled", false);
            $("#save").html("Ajukan Appointment");
        },
        success: function (response) {
            if (response.error) {

            if (response.error.appointment_date_expect) {
                $("#appointment_date_expect").addClass("is-invalid");
                $(".error_appointment_date_expect").html(response.error.appointment_date_expect);
            } else {
                $("#appointment_date_expect").removeClass("is-invalid");
                $(".error_appointment_date_expect").html("");
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
                    window.location.reload();
                });
            }
            }
        },
        });
    });
});
</script>