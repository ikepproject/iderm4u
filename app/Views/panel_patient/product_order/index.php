<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Daftar Produk</h4>

                        <div class="row">
                        <div class="col-lg-12">
                            <div class="row mb-3">
                                <div class="col-lg-2 col-sm-6">
                                    <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center" method="POST" action="<?= base_url('order-product-search') ?>">
                                        <div class="search-box me-2">
                                            <div class="position-relative">
                                                <input type="text" id="search_product" name="search_product" class="form-control border-1" placeholder="Cari produk...">
                                                <i class="bx bx-search-alt search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                            <?php if (count($product) != 0) { ?> 
                            <?php 
                            foreach ($product as $data) : ?>
                                <div class="col-xl-3 col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="product-img position-relative">
                                                <img src="public/assets/images/product/default.png" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                            <div class="mt-4 text-center">
                                                <h5 class="mb-3 text-truncate"><a class="text-dark"><?= $data['product_name'] ?></a></h5>
                                                <p class="text-muted">
                                                    <?= $data['product_description'] ?>
                                                </p>
                                                <p><b>Stock:</b> <?= $data['product_qty'] ?></p>
                                                <h5 class="my-0"><b>Rp <?= rupiah($data['product_price']) ?></b></h5>
                                                <?php
                                                    $isInCart = false;
                                                    foreach ($cart as $productInCart) {
                                                        if ($productInCart['cart_product'] == $data['product_code']) {
                                                            $isInCart = true;
                                                            break;
                                                        }
                                                    }
                                                    if ($isInCart): ?>
                                                        <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light mt-2 me-1" disabled>
                                                            <i class="bx bx-cart me-2"></i> Ada di Keranjang
                                                        </button>
                                                    <?php else: ?>
                                                      <?php if ($data['product_qty'] != 0) { ?> 
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mt-2 me-1" onclick="order('<?= $data['product_code'] ?>')">
                                                            <i class="bx bx-cart me-2"></i> Masukan Keranjang
                                                        </button>
                                                        <?php } ?>
                                                        <?php if ($data['product_qty'] == 0) { ?> 
                                                         <p>Out of Stock</p>
                                                        <?php } ?>
                                                <?php endif; ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php }?>
                            <?php if (count($product) == 0) { ?>
                              <div class="col-lg-4">
                                <div class="card border border-warning">
                                    <div class="card-header bg-transparent border-warning">
                                        <h5 class="my-0 text-warning"><i class="mdi mdi-emoticon-sad-outline me-3"></i>Tidak Ditemukan</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mt-0">Maaf, Produk yang Anda Cari Tidak Kami Temukan.</h5>
                                        <p class="card-text">Coba telusuri keyword lainnya.</p>
                                    </div>
                                </div>
                            </div>
                              <?php }?>
                            </div>
                            <!-- end row -->
                            <?php if ($pager != NULL) { ?> 
                              <div class="row">
                                <div class="col-lg-12">
                                    <?= $pager->links('tb_product', 'custom_pagination'); ?>
                                </div>
                              </div>
                            <?php }?>
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

<div class="ordermodal"></div>

<script>
  function order(product_code) {
    $.ajax({
        type: "post",
        url: "order-product/formorder",
        data: {
            product_code: product_code
        },
        dataType: "json",
        success: function(response) {
            $('.ordermodal').html(response.data).show();
            $('#modalorder').modal('show');
        }
    });
  }

</script>

<?= $this->endSection('isi') ?>