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
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle mb-0 table-nowrap">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Produk Deskripsi</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th colspan="2">Total</th>
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
                                                            <p class="mb-0"><?= $data['product_description'] ?></p>
                                                        </td>
                                                        <td>
                                                            Rp <?= rupiah($data['product_price']) ?>
                                                        </td>
                                                        <td>
                                                            <?= $data['cart_qty'] ?>
                                                        </td>
                                                        <td>
                                                            Rp <?= rupiah($data['cart_qty']*$data['product_price']) ?>
                                                        </td>
                                                        <td>
                                                            <a class="action-icon text-danger" onclick="cancel('<?= $data['cart_id'] ?>', '<?= $data['product_name'] ?>')"> <i class="mdi mdi-trash-can font-size-18"></i></a>
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
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Pilih Metode Pembayaran</h5>
                                        <select class="form-select" name="invoice_method" id="invoice_method">
                                            <option selected disabled>Pilih...</option>
                                            <option value="VA">Virtual Account (+ Rp 4.440)</option>
                                            <option value="Gopay">GoPay (+ 2%)</option>
                                            
                                        </select>
                                        <div class="invalid-feedback error_invoice_method"></div>
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
                                                        <td>Rp </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total :</th>
                                                        <th>Rp </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-sm-end mt-2 mt-4">
                                                <a href="javascript: void(0);" class="btn btn-success">
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