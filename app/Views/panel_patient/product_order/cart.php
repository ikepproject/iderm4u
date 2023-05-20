<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Keranjang</h4>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0 table-wrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="10%">Produk</th>
                                                        <th width="90%">Produk Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                foreach ($cart as $data) : ?>
                                                    <tr>
                                                        <td>
                                                            
                                                            <img src="public/assets/images/product/default.png" alt="product-img"
                                                                title="product-img" class="avatar-md" />
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-14 text-truncate"><a class="text-dark"><?= $data['product_name'] ?></a></h5>
                                                            <p id="product-description"><?= $data['product_description'] ?></p>

                                                            <span>
                                                            Rp <?= rupiah($data['product_price']) ?> (<?= $data['cart_qty'] ?>) <br>
                                                            <b>Rp <?= rupiah($data['cart_qty']*$data['product_price']) ?></b>
                                                            </span>
                                                            <div class="text-right">
                                                                <a class="action-icon text-danger" onclick="cancel('<?= $data['cart_id'] ?>', '<?= $data['product_name'] ?>')"> <i class="mdi mdi-trash-can font-size-18"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-6">
                                                <a href="<?= base_url() ?>order-product" class="btn btn-secondary">
                                                    <i class="mdi mdi-arrow-left me-1"></i> Pilih Produk Lain </a>
                                            </div> <!-- end col -->
                                            <div class="col-sm-6">
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Pilih Metode Pembayaran<code>*</code> </h5>
                                        <select class="form-control select2-cart" name="invoice_method" id="invoice_method">
                                            <option selected disabled>Pilih...</option>
                                            <option value="VA">Virtual Account (+ Rp 4.440)</option>
                                            <option value="Gopay">GoPay (+ 2%)</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">Rincian Order</h4>

                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Grand Total :</td>
                                                        <td>Rp <?= rupiah($total)?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Biaya Transaksi : </td>
                                                        <td>Rp <a id="biaya_transaksi"></a> </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total :</th>
                                                        <th>Rp <a id="total_final"></a></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-sm-end mt-2 mt-4">
                                                <a href="javascript: void(0);" class="btn btn-success" id="checkout-button">
                                                    <i class="bx bx-check me-1"></i> Checkout 
                                                </a>
                                            </div>
                                        </div>
                                        <!-- end table-responsive -->
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
// Get the content of the paragraph
var text = document.getElementById('product-description').textContent;

// Split the text into words
var words = text.split(' ');

// If there are more than 5 words, replace the text with the first 5
if (words.length > 5) {
    words = words.slice(0, 5);
    document.getElementById('product-description').textContent = words.join(' ') + "...";
}

function formatPrice(price) {
    return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(document).ready(function () {
    var total = <?= $total ?>;

    $('.select2-cart').select2({
            minimumResultsForSearch: Infinity
    }).on('change', function() {  // add event listener for 'change' event
        var selectedMethod = $(this).val();
        var biaya_transaksi;
        if (selectedMethod == 'VA') {
            biaya_transaksi = 4440;
        } else if (selectedMethod == 'Gopay') {
            biaya_transaksi = total * 0.02;  // 2% of total
        }
        var total_final = total + biaya_transaksi;
        // format the values and update biaya_transaksi and total_final
        var formattedBiayaTransaksi = formatPrice(biaya_transaksi);
        var formattedTotalFinal = formatPrice(total_final);
        $('#biaya_transaksi').text(formattedBiayaTransaksi);
        $('#total_final').text(formattedTotalFinal);
    });

    $('#checkout-button').click(function() {
        var selectedMethod = $('.select2-cart').val();
        if (!selectedMethod) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap pilih metode pembayaran terlebih dahulu.',
            });
        } else {
            var totalFinal = $('#total_final').text()
            Swal.fire({
                title: 'Lanjuk ke proses checkout?',
                text: "Total yang harus anda bayarkan adalah Rp"+formatPrice(totalFinal),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Code to execute when the user confirms the action, for example:
                    // Submit the form, or redirect to another page
                }
            });
        }
    });
});

function cancel(cart_id, product_name) {
    Swal.fire({
        title: 'Hapus produk dari keranjang?',
        text: `Apakah anda yakin menghapus produk ${product_name}? `,
        icon: 'warning',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Iya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "order-product/cancel",
                type: "post",
                dataType: "json",
                data: {
                    cart_id: cart_id,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.success,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                }
            });
        }
    })
}
</script>

<?= $this->endSection('isi') ?>