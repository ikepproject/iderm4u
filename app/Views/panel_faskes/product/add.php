<!-- Modal -->
<div class="modal fade" id="modaladd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('product/create', ['class' => 'formadd']) ?>
                <?= csrf_field(); ?>
                <div class="row">
                        <input type="hidden" id="user_faskes" name="user_faskes" value="<?= $user['user_faskes'] ?>">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Product<code>*</code></label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Masukan nama produk..." >
                            <div class="invalid-feedback error_product_name"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Harga product<code>*</code></label>
                            <input type="text" class="form-control price" id="product_price" name="product_price" placeholder="Masukan harga produk..." >
                            <div class="invalid-feedback error_product_price"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_qty" class="form-label">Jumlah Product<code>*</code></label>
                            <input type="number" class="form-control" id="product_qty" name="product_qty" placeholder="Masukan jumlah produk..." >
                            <div class="invalid-feedback error_product_qty"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_unit" class="form-label">Satuan Jumlah Product<code>*</code></label>
                            <input type="text" class="form-control" id="product_unit" name="product_unit" placeholder="Masukan satuan jumlah produk..." >
                            <div class="invalid-feedback error_product_unit"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_status" class="form-label">Status product <code>*</code></label>
                            <select class="form-select" id="product_status" name="product_status">
                                <option selected disabled>Pilih...</option>
                                <option value="t">Aktif</option>
                                <option value="f">Nonaktif</option>
                            </select>
                            <div class="invalid-feedback error_product_status"></div>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Keterangan product</label>
                            <textarea class="form-control" id="product_description" name="product_description"></textarea>
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
            if (response.error.product_name) {
                $("#product_name").addClass("is-invalid");
                $(".error_product_name").html(response.error.product_name);
            } else {
                $("#product_name").removeClass("is-invalid");
                $(".error_product_name").html("");
            }

            if (response.error.product_price) {
                $("#product_price").addClass("is-invalid");
                $(".error_product_price").html(response.error.product_price);
            } else {
                $("#product_price").removeClass("is-invalid");
                $(".error_product_price").html("");
            }

            if (response.error.product_qty) {
                $("#product_qty").addClass("is-invalid");
                $(".error_product_qty").html(response.error.product_qty);
            } else {
                $("#product_qty").removeClass("is-invalid");
                $(".error_product_qty").html("");
            }

            if (response.error.product_unit) {
                $("#product_unit").addClass("is-invalid");
                $(".error_product_unit").html(response.error.product_unit);
            } else {
                $("#product_unit").removeClass("is-invalid");
                $(".error_product_unit").html("");
            }

            if (response.error.product_status) {
                $("#product_status").addClass("is-invalid");
                $(".error_product_status").html(response.error.product_status);
            } else {
                $("#product_status").removeClass("is-invalid");
                $(".error_product_status").html("");
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
                datatable_product();
            }
            }
        },
        });
        });
    });
</script>