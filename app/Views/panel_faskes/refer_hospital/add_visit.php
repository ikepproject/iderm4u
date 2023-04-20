<?= $this->extend('partials/main') ?>
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
              <h4 class="mb-sm-0 font-size-18">Form Rujuk Kunjungan Pasien</h4>

          </div>
        </div>
        <?= form_open('refer-visit/create', ['class' => 'formadd']) ?>
        <?= csrf_field(); ?>
        <div class="row">
            <div class="mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Data Medis</h4>
                        <input class="form-control" type="hidden" id="medical_code" name="medical_code" value="<?= $medical['medical_code'] ?>">
                        <input class="form-control" type="hidden" id="invoice_id" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">
                        <div class="mb-3">
                          <label class="form-label">Pasien</label>
                          <input class="form-control" type="text" value="<?= $medical['patient_name'] ?> - <?= $medical['faskes_name'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Umur / Jenis Kelamin</label>
                          <input class="form-control" type="text" value="<?= umur($medical['patient_birth']) ?> Tahun / <?= $medical['patient_gender'] ?>" readonly>
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
                            <option value="VA">Virtual Account (+ Rp 4.440)</option>
                            <!-- <option value="Gopay">GoPay (+ 2%)</option> -->
                            <option value="QR">QRIS (+ 0.7%)</option>
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
                                            <option value="<?= $data['treatment_code'] ?>"> 
                                            <?php if ($data['treatment_discount'] == 't') { ?> PROMO  <?= round((($data['treatment_price']-$data['treatment_discount_price'])/$data['treatment_price'])*100,2) ?> % <?php } ?>
                                              <?= $data['treatment_type'] ?> - 
                                              <?= $data['treatment_name'] ?> - 
                                              <?php if ($data['treatment_discount'] == 'f' || $data['treatment_discount'] == NULL) { ?> Rp <?= rupiah( $data['treatment_price']) ?> <?php } ?>
                                              <?php if ($data['treatment_discount'] == 't') { ?> Rp <?= rupiah($data['treatment_discount_price']) ?> <?php } ?>
                                            </option>
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
                                              <option value="<?= $data['product_code'] ?>" <?php if ($data['product_qty'] == 0) echo "disabled"; ?> > <?= $data['product_type'] ?> - <?= $data['product_name'] ?> - Rp <?= rupiah($data['product_price']) ?> (Qty=<?= $data['product_qty'] ?>)</option>
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
                <div class="card shadow-sm">
                  
                    <div class="card-body">
                      <h4 class="card-title mb-4">Data Foto Kunjungan</h4>
                        <!-- <div class="file-loading">
                            <input id="inp-krajee-explorer-fa6-1" name="inp-krajee-explorer-fa6-1" type="file" multiple accept="image">
                        </div> -->
                        <div class="mb-3">
                          <label for="medgal_disease">Indikasi Dalam Foto 
                            <button type="button" class="btn btn-light position-relative p-0 avatar-xs rounded-circle" data-toggle="tooltip" data-placement="top" 
                            title="Masukan kode letak area gejala dan indikasi gejala yang dialami pasien, jika lebih dari 1 indikasi pisah dengan '-'. Contoh: w1jerawat-w3komedo-dst. "> <span class="avatar-title bg-transparent text-reset"> <i class="bx bxs-info-circle"></i> </span>
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#gejalaModal">
                              <i class="bx bx-map-pin font-size-16 align-middle me-2"></i> Kode Area Gejala
                            </button>
                          </label>
                          <input type="text" class="form-control" id="medgal_disease" name="medgal_disease">
                        </div>
                        <div class="mb-3">
                          <label for="name">Pilih foto</label>
                          <input type="file" class="form-control" id="images" name="images[]" onchange="preview_images();" accept=".jpg,.jpeg,.png" multiple/>
                        </div>
                        <div class="row">
                          <div class="mb-3">
                            <div style="display: inline-block;" id="image_preview"></div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="save" name="save"><i class="bx bx-save"></i> Tambah Data</button>
            </div>
        </div>
        <?= form_close() ?>

    </div> <!-- container-fluid -->
</div>

<!-- Modal Kode Area Gejala -->
<div class="modal fade" id="gejalaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="gejalaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gejalaModalLabel">Kode Area Gejala</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <p><i class="bx bx-info-circle"></i> Lihat kode area terjadinya gejala pada setiap bagian memilik kode yg berbeda.</p>
      <p><i class="bx bx-info-circle"></i> Klik tombol dibawah agar illustrasi area gejala muncul.</p>

      <div class="d-flex bd-highlight mb-3">
        <div class="p-2 bd-highlight">
          <a class="btn btn-success btn-sm mb-3" data-bs-toggle="collapse" href="#face" aria-expanded="true" aria-controls="face">
              <i class="bx bx-face mr-2"></i> Area Wajah
          </a>
        </div>
        <div class="p-2 bd-highlight">
          <a class="btn btn-primary btn-sm mb-3" data-bs-toggle="collapse" href="#body" aria-expanded="true" aria-controls="body">
              <i class="bx bx-body mr-2"></i> Area Tubuh
          </a>
        </div>
      </div>

        <div class="collapse" id="face">
          <div class="row">
              <div class="card border border-primary shadow-lg text-left">
                  <div class="card-body">
                    <div class="product-img position-relative">
                        <img src="<?= base_url() ?>public/assets/images/mapping/face.png" alt="" class="img-fluid mx-auto d-block">
                    </div>
                  </div>
              </div>
          </div>
        </div>

        <div class="collapse" id="body">
          <div class="row">
              <div class="card border border-primary shadow-lg text-left">
                  <div class="card-body">
                    <div class="product-img position-relative">
                        
                    </div>
                  </div>
              </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- End Page-content -->
<!-- form repeater js -->
<script src="<?= base_url() ?>/public/assets/libs/jquery.repeater/jquery.repeater.min.js"></script>

<script>
$(function () {
      $('[data-toggle="tooltip"]').tooltip()
  });
function preview_images() 
{
  var total_file=document.getElementById("images").files.length;
  for(var i=0;i<total_file;i++)
  {
  $('#image_preview').append("<img style='object-fit:scale-down;width:150px;height:150px; margin-right:10px;' class='img-responsive' src='"+URL.createObjectURL(event.target.files[i])+"'>");
  }
}
</script>
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
$(document).ready(function () {
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

        if (response.error.medical_type) {
            $("#medical_type").addClass("is-invalid");
            $(".error_medical_type").html(response.error.medical_type);
        } else {
            $("#medical_type").removeClass("is-invalid");
            $(".error_medical_type").html("");
        }

        if (response.error.invoice_method) {
            $("#invoice_method").addClass("is-invalid");
            $(".error_invoice_method").html(response.error.invoice_method);
        } else {
            $("#invoice_method").removeClass("is-invalid");
            $(".error_invoice_method").html("");
        }

        } else {
        if (response.success) {
            Swal.fire({
            title: "Berhasil!",
            text: response.success,
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
            }).then(function () {
                window.location = response.link;
            });
        }
        }
    },
    });
    });
});


</script>

<?= $this->endSection('isi') ?>