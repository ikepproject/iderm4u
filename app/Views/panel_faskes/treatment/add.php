<!-- Modal -->
<div class="modal fade" id="modaladd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('treatment/create', ['class' => 'formadd']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                        <input type="hidden" id="user_faskes" name="user_faskes" value="<?= $user['user_faskes'] ?>">
                        <div class="mb-3">
                            <label for="treatment_name" class="form-label">Nama Treatment<code>*</code></label>
                            <input type="text" class="form-control" id="treatment_name" name="treatment_name" placeholder="Masukan nama treatment..." >
                            <div class="invalid-feedback error_treatment_name"></div>
                        </div>
                        <div class="mb-3">
                            <label for="treatment_price" class="form-label">Harga Treatment<code>*</code></label>
                            <input type="text" class="form-control price" id="treatment_price" name="treatment_price" placeholder="Masukan harga treatment..." >
                            <div class="invalid-feedback error_treatment_price"></div>
                        </div>
                        <div class="mb-3">
                            <label for="treatment_status" class="form-label">Status Treatment <code>*</code></label>
                            <select class="form-select" id="treatment_status" name="treatment_status">
                                <option selected disabled>Pilih...</option>
                                <option value="t">Aktif</option>
                                <option value="f">Nonaktif</option>
                            </select>
                            <div class="invalid-feedback error_treatment_status"></div>
                        </div>
                        <div class="mb-3">
                            <label for="treatment_description" class="form-label">Keterangan Treatment</label>
                            <textarea class="form-control" id="treatment_description" name="treatment_description">
                            </textarea>
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

        $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});

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
            if (response.error.treatment_name) {
                $("#treatment_name").addClass("is-invalid");
                $(".error_treatment_name").html(response.error.treatment_name);
            } else {
                $("#treatment_name").removeClass("is-invalid");
                $(".error_treatment_name").html("");
            }

            if (response.error.treatment_price) {
                $("#treatment_price").addClass("is-invalid");
                $(".error_treatment_price").html(response.error.treatment_price);
            } else {
                $("#treatment_price").removeClass("is-invalid");
                $(".error_treatment_price").html("");
            }

            if (response.error.treatment_status) {
                $("#treatment_status").addClass("is-invalid");
                $(".error_treatment_status").html(response.error.treatment_status);
            } else {
                $("#treatment_status").removeClass("is-invalid");
                $(".error_treatment_status").html("");
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
                datatable_treatment();
            }
            }
        },
        });
        });
    });
</script>