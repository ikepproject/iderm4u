<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('treatment/update', ['class' => 'formupdate']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="mb-3">
                        <label for="treatment_code" class="form-label">ID Treatment<code>*</code></label>
                        <input type="text" class="form-control" id="treatment_code" name="treatment_code" value="<?= $treatment['treatment_code'] ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_name" class="form-label">Nama Treatment<code>*</code></label>
                        <input type="text" class="form-control" id="treatment_name" name="treatment_name" value="<?= $treatment['treatment_name'] ?>">
                        <div class="invalid-feedback error_treatment_name"></div>
                    </div>
                    <div class="mb-3">
                            <label for="treatment_type" class="form-label">Jenis Treatment<code>*</code></label>
                            <select class="form-control select2-edit" id="treatment_type" name="treatment_type">
                                <option selected disabled>Pilih...</option>
                                <?php foreach ($type_treatment as $key => $data) { ?>
                                    <option value="<?= $data['type_name'] ?>" <?php if ($data['type_name'] == $treatment['treatment_type']) echo "selected"; ?> ><?= $data['type_name'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_treatment_type"></div>
                        </div>
                    <div class="mb-3">
                        <label for="treatment_price" class="form-label">Harga Treatment<code>*</code></label>
                        <input type="text" class="form-control price" id="treatment_price" name="treatment_price" value="<?= $treatment['treatment_price'] ?>" >
                        <div class="invalid-feedback error_treatment_price"></div>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_status" class="form-label">Status Treatment <code>*</code></label>
                        <select class="form-control select2-edit" id="treatment_status" name="treatment_status">
                            <option value="t" <?php if ($treatment['treatment_status'] == "t") echo "selected"; ?> >Aktif</option>
                            <option value="f" <?php if ($treatment['treatment_status'] == "f") echo "selected"; ?> >Nonaktif</option>
                        </select>
                        <div class="invalid-feedback error_treatment_status"></div>
                    </div>
                    <div class="mb-3">
                        <label for="treatment_description" class="form-label">Keterangan Treatment</label>
                        <textarea class="form-control" id="treatment_description" name="treatment_description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="save" name="save"><i class="bx bx-save"></i> Update Data</button>
                </div>
                <?= form_close() ?>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function () {

        $('.select2-edit').select2({
            dropdownParent: $('#modaledit'),
            minimumResultsForSearch: Infinity
        });

        $('#treatment_description').val("<?= $treatment['treatment_description'] ?>");

        $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});

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
            $("#save").attr("disabled", true);
            $("#save").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#save").removeAttr("disabled", false);
            $("#save").html("Update Data");
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

                if (response.error.treatment_type) {
                    $("#treatment_type").addClass("is-invalid");
                    $(".error_treatment_type").html(response.error.treatment_type);
                } else {
                    $("#treatment_type").removeClass("is-invalid");
                    $(".error_treatment_type").html("");
                }

                if (response.error.treatment_price) {
                    $("#treatment_price").addClass("is-invalid");
                    $(".error_treatment_price").html(response.error.treatment_price);
                } else {
                    $("#treatment_price").removeClass("is-invalid");
                    $(".error_treatment_price").html("");
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
                datatable_treatment();
            }
            }
        },
        });
        });
    });
</script>