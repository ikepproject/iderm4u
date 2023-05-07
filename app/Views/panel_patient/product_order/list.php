<div class="row">
    <div class="col-lg-12">
        <div class="row mb-3">
            <div class="col-lg-2 col-sm-6">
                <form class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                    <div class="search-box me-2">
                        <div class="position-relative">
                            <input type="text" class="form-control border-1" placeholder="Cari produk...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
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
                                Deskripsi: <?= $data['product_description'] ?>
                            </p>
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
                                    <button type="button" class="btn btn-secondary waves-effect waves-light mt-2 me-1">
                                        Produk ada di Keranjang
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                        <i class="bx bx-cart me-2"></i> Masukan Keranjang
                                    </button>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <?= $pager->links('tb_product', 'custom_pagination'); ?>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

