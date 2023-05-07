<!-- Modal -->
<div class="modal fade" id="modalorder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            <?= form_open('order-product/cart', ['class' => 'formcart']) ?>
            <?= csrf_field(); ?>
                <div class="row">
                        <input type="hidden" id="cart_product" name="cart_product" value="<?= $product['product_code'] ?>">
                        <input type="hidden" id="cart_qty_max" name="cart_qty_max" value="<?= $product['product_qty'] ?>">
                        <div class="mb-3">
                            <label for="stock_type" class="form-label">Product</label>
                            <input type="text" class="form-control" value="<?= $product['product_code'] ?> - <?= $product['product_name'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="stock_type" class="form-label">Available Stock</label>
                            <input type="text" class="form-control" value="<?= $product['product_qty'] ?> <?= $product['product_unit'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="stock_type" class="form-label">Jumlah Order</label>
                            <input class="form-control" type="number" min="1" step="1" max="<?= $product['product_qty'] ?>" name="cart_qty" id="cart_qty">
                            <div class="invalid-feedback error_cart_qty"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="cart" name="cart"><i class="fas fa-cart-plus"></i> Masukan Keranjang</button>
                </div>
            <?= form_close() ?>

            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function () {

        $(".formcart").submit(function (e) {
        e.preventDefault();
        // var form_data = new FormData($('form')[0]);
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: {
            cart_product: $('input#cart_product').val(),
            cart_qty: $('input#cart_qty').val(),
            cart_qty_max: $('input#cart_qty_max').val(),
        },
        // processData: false,
        // contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#cart").attr("disabled", true);
            $("#cart").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#cart").removeAttr("disabled", false);
            $("#cart").html("Masukan Keranjang");
        },
        success: function (response) {
            if (response.error) {
            if (response.error.cart_qty) {
                $("#cart_qty").addClass("is-invalid");
                $(".error_cart_qty").html(response.error.cart_qty);
            } else {
                $("#cart_qty").removeClass("is-invalid");
                $(".error_cart_qty").html("");
            }

            } else {
            if (response.success) {
                Swal.fire({
                title: response.data.title,
                text: response.success,
                icon: response.data.icon,
                showConfirmButton: false,
                timer: 1500,
                }).then(function () {
                    window.location = response.data.link;
                });
            }
            }
        },
        });
        });
    });
</script>