<!-- Modal -->
<div class="modal fade" id="modalaccept" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('appointment/accept', ['class' => 'formaccept']) ?>
                <?= csrf_field(); ?>
                <input type="hidden" class="form-control" id="appointment_id" name="appointment_id" value="<?= $appointment['appointment_id'] ?>" readonly>
                <input type="hidden" class="form-control" id="appointment_medical" name="appointment_medical" value="<?= $appointment['appointment_medical'] ?>" readonly>
                <div class="mb-3">
                    <label class="form-label">Pasien</label>
                    <input type="text" class="form-control" value="<?= $appointment['patient_name'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jadwal Ekspektasi</label>
                    <input type="text" class="form-control" value="<?= $appointment['appointment_date_expect'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan Pengantar</label>
                    <textarea type="text" class="form-control" id="appointment_note_user" name="appointment_note_user" readonly></textarea>
                </div>
                <div class="mb-3">
                    <label for="appointment_date_fix" class="form-label">Jadwal Final<code>*</code></label>
                    <input type="datetime-local" class="form-control" id="appointment_date_fix" name="appointment_date_fix" value="<?= $appointment['appointment_date_fix'] ?>" >
                    <div class="invalid-feedback error_appointment_date_fix"></div>
                </div>
                <?php if ($appointment['appointment_type'] == 'Teledermatologi') { ?>
                <div class="mb-3">
                    <label for="appointment_link" class="form-label">Link Teledermatologi<code>*</code></label>
                    <input type="text" class="form-control" id="appointment_link" name="appointment_link" value="<?= $appointment['appointment_link'] ?>">
                </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="appointment_note_faskes" class="form-label">Catatan</label>
                    <textarea class="form-control" id="appointment_note_faskes" name="appointment_note_faskes"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="save" name="save"><i class="bx bx-calendar-check"></i> Finalisasi Jadwal</button>
                </div>
            </div>
            <?= form_close() ?>
        </div><!-- /.modal-content -->
        
       
    </div><!-- /.modal-dialog -->
</div>

<script>
$(document).ready(function () {
    $('#appointment_note_user').val("<?= $appointment['appointment_note_user'] ?>");
    $('#appointment_note_faskes').val("<?= $appointment['appointment_note_faskes'] ?>");

    $(".formaccept").submit(function (e) {
        e.preventDefault();
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: {
            appointment_id: $('input#appointment_id').val(),
            appointment_medical: $('input#appointment_medical').val(),
            appointment_date_fix: $('input#appointment_date_fix').val(),
            appointment_link: $('input#appointment_link').val(),
            appointment_note_faskes: $('textarea#appointment_note_faskes').val(),
        },
        // processData: false,
        // contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#accept").attr("disabled", true);
            $("#accept").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#accept").removeAttr("disabled", false);
            $("#accept").html("Finalisasi Jadwal");
        },
        success: function (response) {
            if (response.error) {

            if (response.error.appointment_date_fix) {
                $("#appointment_date_fix").addClass("is-invalid");
                $(".error_appointment_date_fix").html(response.error.appointment_date_fix);
            } else {
                $("#appointment_date_fix").removeClass("is-invalid");
                $(".error_appointment_date_fix").html("");
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
                $("#modalaccept").modal("hide");
                datatable_refer();
            }
            }
        },
        });
    });
});
</script>