<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('product/update', ['class' => 'formupdate']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                    <input type="hidden" class="form-control" id="product_code" name="product_code" value="<?= $product['product_code'] ?>" >
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Nama Product<code>*</code></label>
                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product['product_name'] ?>" >
                        <div class="invalid-feedback error_product_name"></div>
                    </div>
                    <div class="mb-3">
                        <label for="product_price" class="form-label">Harga product<code>*</code></label>
                        <input type="text" class="form-control price" id="product_price" name="product_price" value="<?= $product['product_price'] ?>" >
                        <div class="invalid-feedback error_product_price"></div>
                    </div>
                    <div class="mb-3">
                        <label for="product_qty" class="form-label">Jumlah Product<code>*</code></label>
                        <input type="number" class="form-control" id="product_qty" name="product_qty" value="<?= $product['product_qty'] ?>" readonly>
                        <div class="invalid-feedback error_product_qty"></div>
                    </div>
                    <div class="mb-3">
                        <label for="product_unit" class="form-label">Satuan Jumlah Product<code>*</code></label>
                        <input type="text" class="form-control" id="product_unit" name="product_unit" value="<?= $product['product_unit'] ?>" >
                        <div class="invalid-feedback error_product_unit"></div>
                    </div>
                    <div class="mb-3">
                        <label for="product_status" class="form-label">Status Produk <code>*</code></label>
                        <select class="form-select" id="product_status" name="product_status">
                            <option value="t" <?php if ($product['product_status'] == "t") echo "selected"; ?> >Aktif</option>
                            <option value="f" <?php if ($product['product_status'] == "f") echo "selected"; ?> >Nonaktif</option>
                        </select>
                        <div class="invalid-feedback error_product_status"></div>
                    </div>
                    <div class="mb-3">
                        <label for="product_description" class="form-label">Keterangan Produk</label>
                        <textarea class="form-control" id="product_description" name="product_description">
                        </textarea>
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
        $('#product_description').val("<?= $product['product_description'] ?>");

        $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});

        $(".formupdate").submit(function (e) {
        e.preventDefault();
        // var form_data = new FormData($('form')[0]);
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: {
            product_code: $('input#product_code').val(),
            product_name: $('input#product_name').val(),
            product_price: $('input#product_price').val(),
            product_qty: $('input#product_qty').val(),
            product_unit: $('input#product_unit').val(),
            product_status: $('select#product_status').val(),
            product_description: $('textarea#product_description').val(),
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
            $("#save").html("Update Data");
        },
        success: function (response) {
            if (response.error) {
                if (response.error.product_name) {
                    $("#product_name").addClass("is-invalid");
                    $(".error_product_name").html(response.error.product_name);
                } else {
                    $("#product_name").removeClass("is-invalid");
                    $(".error_product_name").html("");
                }

                if (response.error.product_unit) {
                    $("#product_unit").addClass("is-invalid");
                    $(".error_product_unit").html(response.error.product_unit);
                } else {
                    $("#product_unit").removeClass("is-invalid");
                    $(".error_product_unit").html("");
                }

                if (response.error.product_price) {
                    $("#product_price").addClass("is-invalid");
                    $(".error_product_price").html(response.error.product_price);
                } else {
                    $("#product_price").removeClass("is-invalid");
                    $(".error_product_price").html("");
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
                datatable_product();
            }
            }
        },
        });
        });
    });
</script>