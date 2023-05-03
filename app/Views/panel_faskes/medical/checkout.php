<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>
<!-- Plugins css -->
<div class="page-content">
    <div class="container-fluid">
        <a style="margin-left: 0px !important;" class="btn btn-primary waves-effect waves-light mb-3" href="<?= base_url().$redirect ?>"> <i class="bx bx-left-arrow-alt"></i> Kembali</a>
        
        <div class="row">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">
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
        
        <?php
        if (session()->getFlashdata('pesan')) { 
            echo'<div class="row">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-all me-2"></i>
                        Pembayaran via Payment Gateway sedang diproses. Lakukan pembayaran segera jika anda belum melakukan pembayaran!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>';
        }
        ?>

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
                                    <strong>Pembayaran:</strong><br>
                                    Via: <?= $invoice['invoice_method'] ?><br>
                                    Status:
                                    <?php if ($invoice['invoice_status'] == 'SUCCEEDED') { ?> 
                                        Lunas
                                    <?php } ?>
                                    <?php if ($invoice['invoice_status'] != 'SUCCEEDED') { ?> 
                                        Pending
                                    <?php } ?>
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
                                            <td>TR - 
                                                <?= $treatment['medtreat_discount'] ?>
                                                <?= $treatment['treatment_type'] ?> 
                                                <?= $treatment['medtreat_name'] ?>
                                                <?php if ($treatment['medtreat_discount'] != NULL) { ?>
                                                    <s>Rp <?= rupiah($treatment['medtreat_discount_price']) ?></s>
                                                <?php } ?>
                                            </td>
                                            <td class="text-end">Rp <?= rupiah($treatment['medtreat_price']) ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php } ?>
                                        <?php if (count($medprod) != 0) {?>
                                        <?php
                                        foreach ($medprod as $product) :
                                        $nomor++; ?>
                                        <tr>
                                            <td><?= $nomor ?></td>
                                            <td>PR - 
                                                <?= $product['product_type'] ?> 
                                                <?= $product['medprod_name'] ?> 
                                                (<?= $product['medprod_qty'] ?>) 
                                                @<?= rupiah($product['medprod_price']) ?>
                                            </td>
                                            <td class="text-end">Rp <?= rupiah($product['medprod_price']*$product['medprod_qty']) ?></td>
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
                            <div class="d-flex flex-row-reverse">
                                <div class="p-2">
                                    <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                </div>
                                <div class="p-2">
                                    <?php if ($modul == 'checkout') { ?> 
                                        <?php if ($invoice['invoice_method'] == 'Cash') { ?> 
                                            <!-- <button type="button" class="btn btn-primary w-md waves-effect waves-light" onclick="cash('<?= $medical['medical_code'] ?>', '<?= $invoice['invoice_code'] ?>')"><i class="bx bx-dollar mr-2"></i> Bayar Tunai</button> -->
                                            <button type="button" class="btn btn-primary mb-2 mt-1" onclick="cash('<?= rupiah($invoice['invoice_amount']) ?>', '<?= $invoice['invoice_amount'] ?>','<?= $invoice['invoice_id'] ?>', '<?= $medical['medical_code'] ?>')"><i class="bx bx-dollar mr-2"></i> Bayar Tunai
                                            </button>
                                        <?php } ?>
                                        <?php if ($invoice['invoice_method'] != 'Cash') { ?> 
                                            <?php if ($invoice['invoice_midtrans'] == NULL) { ?> 
                                                <form action="<?= base_url('transaction/finish') ?>" method="post" id="payment-form">
                                                    <input type="hidden" id="medical_code" name="medical_code" value="<?= $medical['medical_code'] ?>">
                                                    <input type="hidden" id="invoice_id" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">
                                                    <input type="hidden" id="invoice_code" name="invoice_code" value="<?= $invoice['invoice_code'] ?>">
                                                    <input type="hidden" id="invoice_method" name="invoice_method" value="<?= $invoice['invoice_method'] ?>">
                                                    <input type="hidden" id="patient_name" name="patient_name" value="<?= $patient['patient_name'] ?>">
                                                    <input type="hidden" id="email" name="email" value="<?= $user_patient['user_email'] ?>">
                                                    <input type="hidden" id="phone" name="phone" value="<?= $user_patient['user_phone'] ?>">
                                                    <input type="hidden" id="address" name="address" value="<?= $patient['patient_address'] ?>">
                                                    <input type="hidden" id="amount"  name="amount" value="<?= $invoice['invoice_amount'] ?>">


                                                    <input type="hidden" name="result_type" id="result-type" value="">
                                                    <input type="hidden" name="result_data" id="result-data" value="">

                                                    <button type="submit" id="pay-button" class="btn btn-primary w-md waves-effect waves-light"><i class="bx bxs-credit-card mr-2"></i> Payment Gateway</button>
                                                </form>
                                            <?php } ?>
                                            <?php if ($invoice['invoice_midtrans'] != NULL && $invoice['invoice_status'] != 'SUCCEEDED') { ?> 
                                                <!-- <button type="button" class="btn btn-info w-md waves-effect waves-light" onclick="payinfo('<?= $invoice['invoice_id'] ?>')"><i class="bx bx-credit-card mr-2"></i> Payment Info</button> -->
                                                <button id="pay-button2" class="btn btn-info w-md waves-effect waves-light"><i class="bx bx-credit-card mr-2"></i> Lanjutkan Pembayaran</button>
                                            <?php } ?>
                                        <?php } ?> 
                                    <?php } ?> 
                                </div>
                                
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
<div class="payinfomodal"></div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-1Q4ylPz1Yq_OD2ZG"></script>
<script type="text/javascript">
    $('#pay-button').click(function(e) {
        e.preventDefault();
        $(this).attr("disabled", "disabled");

        const medical_code  = $('#medical_code').val();
        const invoice_id    = $('#invoice_id').val();
        const invoice_code  = $('#invoice_code').val();
        const invoice_method= $('#invoice_method').val();
        const patient_name  = $('#patient_name').val();
        const email         = $('#email').val();
        const address       = $('#address').val();
        const phone         = $('#phone').val();
        const amount        = $('#amount').val();

        $.ajax({
            url: '<?= base_url('transaction/token') ?>',
            type: "POST",
            data: {
                medical_code: medical_code,
                invoice_id: invoice_id,
                invoice_code: invoice_code,
                invoice_method: invoice_method,
                patient_name: patient_name,
                email: email,
                address: address,
                phone: phone,
                amount: amount
            },
            cache: false,

            success: function(data) {
                //location = data;
                console.log(data);
                console.log('token = ' + data);
                $('#pay-button').removeAttr('disabled');

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {
                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();

                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();

                    },
                    onError: function(result) {
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    })
</script>

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

// function payinfo(invoice_id) {
//     $.ajax({
//         type: "post",
//         url: "<?= site_url('transaction/formpayinfo') ?>",
//         data: {
//             invoice_id: invoice_id
//         },
//         dataType: "json",
//         success: function(response) {
//             $('.payinfomodal').html(response.data).show();
//             $('#modalpayinfo').modal('show');
//         }
//     });
// }

var payButton2 = document.getElementById('pay-button2');
payButton2.onclick = function (event) {
snap.show()
var token = "<?= $invoice['invoice_snap_token'] ?>";
var redirectUrl = null;
if (token == null) {
    window.location.href = redirectUrl;
} else {
    snap.pay(token, {
    // Optional
    onSuccess: function(result){
        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        console.log("OnSuccess : "+ JSON.stringify(result, null, 2));
    },
    // Optional
    onPending: function(result){
        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        console.log("OnPending : "+ JSON.stringify(result, null, 2));
    },
    // Optional
    onError: function(result){
        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
    },
    onClose: function (result) {
        console.log("OnClose : "+ JSON.stringify(result, null, 2));
    },
    language: "ID"
    });
    return false;
}
};

</script>

<?= $this->endSection('isi') ?>