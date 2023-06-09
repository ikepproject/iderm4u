<?= $this->extend('stagging/main') ?>
<?= $this->section('isi') ?>
<!-- Plugins css -->
<link href="<?= base_url() ?>/public/assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<style>
  [data-repeater-item]:first-child [data-repeater-delete] { display: none; }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
              <h4 class="mb-sm-0 font-size-18">Form Order Treatment / Produk Pasien</h4>

          </div>
        </div>
        <?= form_open('test_checkout', ['class' => 'formadd']) ?>
        <?= csrf_field(); ?>
        <div class="row">
            <div class="mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Data Pasien</h4>
                        <div class="mb-3 ajax-select mt-3 mt-lg-0">
                            <label class="form-label">Pilih Pasien<code>*</code></label>
                            <input type="text" class="form-control" value="User Test" readonly>
                            <div class="invalid-feedback error_medical_user"></div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Type Kunjungan<code>*</code></label>
                          <select class="form-control" name="medical_type" id="medical_type">
                            <option selected disabled>Pilih...</option>
                            <option value="Treatment">Treatment</option>
                            <option value="Product">Beli Produk</option>
                            <option value="Treatment-Product">Treatment & Beli Produk</option>
                            <option value="Lainnya">Lainnya</option>
                          </select>
                          <div class="invalid-feedback error_medical_type"></div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Cara Bayar<code>*</code></label>
                          <select class="form-control" name="invoice_method" id="invoice_method">
                            <option selected disabled>Pilih...</option>
                            <option value="Cash">Cash</option>
                            <option value="VA" disabled>Virtual Account (+ Rp 4.000)</option>
                            <option value="E-WALLET" disabled>GoPay/ShopeePay (+ 2%)</option>
                          </select>
                          <div class="invalid-feedback error_invoice_method"></div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Waktu Kunjungan</label>
                          <input class="form-control" type="datetime-local" name="medical_create" id="medical_create" value="<?= date('Y-m-d H:i:s') ?>">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Catatan Kunjungan</label>
                          <textarea class="form-control" name="medical_description" id="medical_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                      <h4 class="card-title mb-4">Data Treatment</h4>
                        <div class="repeater">
                          <div data-repeater-list="group-medtreat">
                            <div data-repeater-item class="row">
                                <div class="mb-3 col-10 col-sm-8">
                                    <label for="name">Pilih Tratment</label>
                                    <select class="form-select select2repeater" id="medtreat_treatment" name="medtreat_treatment">
                                        <option selected disabled>Pilih...</option>
                                        <?php foreach ($treatment as $key => $data) { ?>
                                            <option value="<?= $data['treatment_code'] ?>"><?= $data['treatment_name'] ?> - Rp <?= rupiah($data['treatment_price']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-2 col-sm-2 align-self-center">
                                  <div class="d-grid">
                                    <button data-repeater-delete type="sumbit" class="btn btn-danger waves-effect waves-light w-sm">
                                        <i class="mdi mdi-trash-can d-block font-size-10"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="+"/>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                      <h4 class="card-title mb-4">Data Product</h4>
                        <div class="repeater">
                          <div data-repeater-list="group-medprod">
                              <div data-repeater-item class="row">
                                  <div class="mb-3 col-6 col-sm-4">
                                      <label for="name">Pilih Product</label>
                                      <select class="form-select select2repeater" id="medprod_product" name="medprod_product">
                                          <option selected disabled>Pilih...</option>
                                          <?php foreach ($product as $key => $data) { ?>
                                              <option value="<?= $data['product_code'] ?>" <?php if ($data['product_qty'] == 0) echo "disabled"; ?> > <?= $data['product_name'] ?> - Rp <?= rupiah($data['product_price']) ?> (Qty=<?= $data['product_qty'] ?>)</option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                  <div class="mb-3 col-4 col-sm-4">
                                      <label for="name">Jumlah</label>
                                      <input class="form-control" type="number" min="1" step="1" name="medprod_qty" id="medprod_qty">
                                  </div>
                                  <div class="col-2 col-sm-2 align-self-center">
                                    <div class="d-grid">
                                      <button data-repeater-delete type="sumbit" class="btn btn-danger waves-effect waves-light w-sm">
                                          <i class="mdi mdi-trash-can d-block font-size-10"></i>
                                      </button>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="+"/>              
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                      <h4 class="card-title mb-4">Data Lainnya</h4>
                      <div class="repeater">
                          <div data-repeater-list="group-medoth">
                              <div data-repeater-item class="row">
                                  <div class="mb-3 col-lg-2">
                                      <label for="name">Lainnya</label>
                                      <input class="form-control" type="text" name="medoth_name" id="medoth_name">
                                  </div>
                                  <div class="mb-3 col-lg-2">
                                      <label for="name">Jumlah</label>
                                      <input class="form-control" type="number" min="1" step="1" name="medoth_qty" id="medoth_qty">
                                  </div>
                                  <div class="mb-3 col-lg-2">
                                      <label for="name">Harga</label>
                                      <input class="form-control price" type="text" name="medoth_price" id="medoth_price">
                                  </div>
                                  <div class="col-lg-2 align-self-center">
                                    <div class="d-grid">
                                      <button data-repeater-delete type="sumbit" class="btn btn-danger waves-effect waves-light w-sm">
                                          <i class="mdi mdi-trash-can d-block font-size-10"></i>
                                      </button>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          <input data-repeater-create type="button" class="btn btn-success mt-3 mt-lg-0" value="+"/>              
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="mb-3">
              <button type="button" class="btn btn-primary" onclick="cash('')"><i class="bx bx-dollar mr-2"></i> Checkout</button>
            </div>
            <div class="mb-3">
              <a href="<?= base_url() ?>terms-and-conditions">Baca syarat dan ketnetuan kami</a> <br>
              <a href="<?= base_url() ?>privacy">Baca privacy policy kami</a> <br>
              <a href="tel:031-5927547"><i class="bx bx-phone-call"></i> Kontak kami</a> <br>
            </div>
            
        </div>
        <?= form_close() ?>

    </div> <!-- container-fluid -->
</div>

<!-- End Page-content -->
<!-- form repeater js -->
<script src="<?= base_url() ?>/public/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>



<script>
  $(document).ready(function () {
    'use strict';
    $(this).find('.select2repeater').select2();
    $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('.repeater').repeater({
        show: function () {
            $(this).slideDown();
            $(this).find('.select2repeater').removeClass('select2-hidden-accessible');
            $(this).find('.select2-container').remove();
            $(this).find('.select2repeater').select2();
            $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
        },
        ready: function (setIndexes) {

        }
    });
  });
</script>
<script>
function cash() {
    Swal.fire({
        title: 'Checkout',
        text: `Pembayaran sebesar Rp 100.000? `,
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
                url: "<?= site_url('test_checkout') ?>",
                type: "post",
                dataType: "json",
                data: {
                    invoice_amount: 'test'
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
                            window.location = "<?= site_url('test_purchase') ?>";
                        });
                    }
                }
            });
        }
    })
}


$(".select2-ajax").select2({
  ajax: {
    url: "api/web/patient/get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term, // search term
      };
    },
    processResults: function (data, params) {
      
      return {
        results: data.items,
      };
    },
    cache: true
  },
  placeholder: 'Ketikan nama pasien...',
  minimumInputLength: 1,
  templateResult: format,
  templateSelection: formatSelection
});

function format (data) {
  if (data.loading) {
    return data.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='"+'/public/assets/images/users/'+data.photo+"' /></div>" +
      "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository__title").text(data.patient_code+' - '+data.patient_name);

  return $container;
}

function formatSelection (data) {
  return data.patient_name || data.text;
}

</script>

<?= $this->endSection('isi') ?>