<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>
<!-- Plugins css -->
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">
              <a class="btn btn-primary waves-effect waves-light mb-3" href="<?= site_url('medical') ?>"> <i class="bx bx-arrow-back"></i> Kembali</a> <br>
                <?php if ($modul == 'checkout') { ?> 
                    <i>Checkout</i>
                <?php } ?> 
                <?php if ($modul == 'invoice') { ?> 
                    <i>Invoice</i>
                <?php } ?> 
              </h4>

              <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="/medical">Data Kunjungan</a></li>
                      <li class="breadcrumb-item active">
                        <?php if ($modul == 'checkout') { ?> 
                            <i>Checkout</i>
                        <?php } ?> 
                        <?php if ($modul == 'invoice') { ?> 
                            <i>Invoice</i>
                        <?php } ?> 
                      </li>
                  </ol>
              </div>

          </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h5 class="float-end font-size-16"><?= $faskes_name ?>  #<?= $invoice['invoice_code'] ?></h5>
                            <div class="mb-4">
                                <img src="<?= base_url() ?>/public/assets/images/logo-iderm4u.png" alt="logo" height="20"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <address>
                                    <strong>Kepada:</strong><br>
                                    <?= $patient['patient_name'] ?><br>
                                    <?= $user_patient['user_phone'] ?><br>
                                    <?= $patient['patient_address'] ?>
                                </address>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <address>
                                    <strong>Waktu Kunjungan:</strong><br>
                                    <?= longdate_indo(substr($medical['medical_create'],0,10)) ?><br>
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <address>
                                    <strong>Metode Pembayaran:</strong><br>
                                    <?= $invoice['invoice_method'] ?><br>
                                </address>
                            </div>
                            <div class="col-sm-6 mt-3 text-sm-end">
                                <address class="mt-2 mt-sm-0">
                                    <strong>Petugas:</strong><br>
                                    <?= $medical['medical_employee'] ?><br>
                                </address>
                            </div>
                        </div>
                        <hr>
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 fw-bold">Detail</h3>
                        </div>
                        <div>
                            <p><b>ID Kunjungan: <?= $medical['medical_code'] ?></b> </p>
                            <p><b>Jenis Kunjungan:</b> 
                                <?php if ($medical['medical_type'] == 'Treatment') { ?> 
                                    <i>Treatment</i>
                                <?php } ?>
                                <?php if ($medical['medical_type'] == 'Product') { ?> 
                                    <i>Beli Produk</i>
                                <?php } ?> 
                                <?php if ($medical['medical_type'] == 'Treatment-Product') { ?> 
                                    <i>Treatment, Beli Produk</i>
                                <?php } ?> 
                                <?php if ($medical['medical_type'] == 'Lainnya') { ?> 
                                    <i>Lainnya</i>
                                <?php } ?> 
                            </p>
                            <p><b>Catatan:</b> <?= $medical['medical_description'] ?></p>
                        </div>
                        <div class="py-2 mt-3">
                            <h4 class="font-size-15 fw-bold">Order</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item (Jml)</th>
                                        <th class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $nomor = 0;?>
                                    <?php if (count($medtreat) != 0) {?>
                                        <?php
                                        foreach ($medtreat as $treatment) :
                                        $nomor++; ?>
                                        <tr>
                                            <td><?= $nomor ?></td>
                                            <td>TR - <?= $treatment['treatment_name'] ?></td>
                                            <td class="text-end">Rp <?= rupiah($treatment['treatment_price']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php } ?>
                                        <?php if (count($medprod) != 0) {?>
                                        <?php
                                        foreach ($medprod as $product) :
                                        $nomor++; ?>
                                        <tr>
                                            <td><?= $nomor ?></td>
                                            <td>PR - <?= $product['product_name'] ?> (<?= $product['medprod_qty'] ?>) @<?= rupiah($product['product_price']) ?></td>
                                            <td class="text-end">Rp <?= rupiah($product['product_price']*$product['medprod_qty']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php } ?>
                                        <?php if (count($medoth) != 0) {?>
                                        <?php
                                        foreach ($medoth as $other) :
                                        $nomor++; ?>
                                        <tr>
                                            <td><?= $nomor ?></td>
                                            <td>LN - <?= $other['medoth_name'] ?> (<?= $other['medoth_qty'] ?>) @<?= rupiah($other['medoth_price']) ?></td>
                                            <td class="text-end">Rp <?= rupiah($other['medoth_price']*$other['medoth_qty']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php } ?>
                                    
                                    <tr>
                                        <td colspan="2" class="text-end">Sub Total</td>
                                        <td class="text-end">Rp <?= rupiah($invoice['invoice_amount']-$invoice['invoice_admin_fee']) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-end">
                                            <strong>Fee Transaksi</strong></td>
                                        <td class="border-0 text-end">Rp <?= rupiah($invoice['invoice_admin_fee']) ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0 text-end">
                                            <strong>Total</strong></td>
                                        <td class="border-0 text-end"><h4 class="m-0">Rp <?= rupiah($invoice['invoice_amount']) ?></h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-print-none">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                <?php if ($modul == 'checkout') { ?> 
                                    <?php if ($invoice['invoice_method'] == 'Cash') { ?> 
                                        <!-- <button type="button" class="btn btn-primary w-md waves-effect waves-light" onclick="cash('<?= $medical['medical_code'] ?>', '<?= $invoice['invoice_code'] ?>')"><i class="bx bx-dollar mr-2"></i> Bayar Tunai</button> -->
                                        <button type="button" class="btn btn-primary mb-2 mt-1" onclick="cash('<?= rupiah($invoice['invoice_amount']) ?>', '<?= $invoice['invoice_amount'] ?>','<?= $invoice['invoice_id'] ?>', '<?= $medical['medical_code'] ?>')"><i class="bx bx-dollar mr-2"></i> Bayar Tunai
                                        </button>
                                    <?php } ?>
                                    <?php if ($invoice['invoice_method'] != 'Cash') { ?> 
                                        <a href="#" class="btn btn-primary w-md waves-effect waves-light"><i class="bx bxs-credit-card mr-2"></i> Payment Gateway</a>
                                    <?php } ?> 
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<div class="cashmodal"></div>

<script>
// function cash(medical_code, invoice_code) {
//     $.ajax({
//         type: "post",
//         url: "<?= site_url('transaction/formcash') ?>",
//         data: {
//             medical_code: medical_code,
//             invoice_code: invoice_code
//         },
//         dataType: "json",
//         success: function(response) {
//             $('.cashmodal').html(response.data).show();
//             $('#modalcash').modal('show');
//         }
//     });
// }

function cash(invoice_amount_view, invoice_amount, invoice_id, medical_code) {
    Swal.fire({
        title: 'Bayar Tunai',
        text: `Pembayaran tunai sebesar Rp ${invoice_amount_view}? `,
        icon: 'success',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bayar',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('transaction/cash') ?>",
                type: "post",
                dataType: "json",
                data: {
                    invoice_amount: invoice_amount,
                    invoice_id: invoice_id,
                    medical_code: medical_code
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
                            window.location = "<?= site_url('medical') ?>";
                        });
                    }
                }
            });
        }
    })
}
</script>

<?= $this->endSection('isi') ?>