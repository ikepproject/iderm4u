<!-- Modal -->
<div class="modal fade" id="modaldiscount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#discount-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-notes-medical"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-notes-medical mr-2"></i> Discount Form</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#history-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-history"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-history mr-2"></i> Riwayat Discount</span>   
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="discount-1" role="tabpanel">
                        <?= form_open('treatment/discount', ['class' => 'formdiscount']) ?>
                        <?= csrf_field(); ?>
                            <div class="row">
                                    <input type="hidden" id="treatment_code" name="treatment_code" value="<?= $treatment['treatment_code'] ?>">
                                    
                                    <div class="mb-3">
                                        <label for="treatment_name" class="form-label">Nama Treatment</label>
                                        <input type="text" class="form-control" value="<?= $treatment['treatment_code'] ?> - <?= $treatment['treatment_name'] ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="treatment_price" class="form-label">Harga Normal</label>
                                        <input type="text" class="form-control" value="Rp <?= rupiah($treatment['treatment_price'] )?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="treatment_discount" class="form-label">Status Diskon <code>*</code></label>
                                        <select class="form-control select2-discount" id="treatment_discount" name="treatment_discount">
                                            <option value="f" <?php if ($treatment['treatment_discount'] == "f" || $treatment['treatment_discount'] == NULL) echo "selected"; ?> >Nonaktif</option>
                                            <option value="t" <?php if ($treatment['treatment_discount'] == "t") echo "selected"; ?> >Aktif</option>
                                        </select>
                                        <div class="invalid-feedback error_treatment_discount"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="treatment_discount_price" class="form-label">Harga Treatment Diskon<code>*</code></label>
                                        <input type="text" class="form-control price" id="treatment_discount_price" name="treatment_discount_price" value="<?= rupiah($treatment['treatment_discount_price'] )?>" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="discount_description" class="form-label">Keterangan Diskon</label>
                                        <textarea class="form-control" id="discount_description" name="discount_description"></textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" id="discount" name="discount"><i class="bx bx-save"></i> Discount</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                    <div class="tab-pane" id="history-1" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th width="2%">#</th>
                                        <th width="15%">Tgl</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Harga</th>
                                        <th width="5%">User</th>
                                        <th width="30%">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $nomor = 0;
                                foreach ($discount as $data) :
                                $nomor++; ?>
                                    <tr 
                                    <?php if ($data['discount_status'] == 't') { ?> class="table-primary" <?php } ?> >
                                        <th scope="row"><?= $nomor ?></th>
                                        <td><?= date_indo(substr($data['discount_create'],0,10)) ?></td>
                                        <td>
                                            <?php if ($data['discount_status'] == 'f' || $data['discount_status'] == NULL) { ?> Nonaktif <?php } ?>
                                            <?php if ($data['discount_status'] == 't') { ?> Aktif <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($data['discount_status'] == 'f' || $data['discount_status'] == NULL) { ?> Rp <?= rupiah( $data['discount_price_normal']) ?> <?php } ?>
                                            <?php if ($data['discount_status'] == 't') { ?> <s>Rp <?= rupiah($data['discount_price_normal']) ?></s> -> Rp <?= rupiah($data['discount_price']) ?> <?php } ?>
                                        </td>
                                        <td><?= $data['discount_user'] ?></td>
                                        <td><?= $data['discount_description'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function () {
        $('.select2-discount').select2({
            dropdownParent: $('#modaldiscount'),
            minimumResultsForSearch: Infinity
        });

        $('.price').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});

        $(".formdiscount").submit(function (e) {
        e.preventDefault();
        // var form_data = new FormData($('form')[0]);
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: {
            treatment_code: $('input#treatment_code').val(),
            treatment_discount: $('select#treatment_discount').val(),
            treatment_discount_price: $('input#treatment_discount_price').val(),
            discount_description: $('textarea#discount_description').val(),
        },
        // processData: false,
        // contentType: false,
        dataType: "json",
        beforeSend: function () {
            $("#discount").attr("disabled", true);
            $("#discount").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#discount").removeAttr("disabled", false);
            $("#discount").html("Discount");
        },
        success: function (response) {
            if (response.error) {
            if (response.error.treatment_discount) {
                $("#treatment_discount").addClass("is-invalid");
                $(".error_treatment_discount").html(response.error.treatment_discount);
            } else {
                $("#treatment_discount").removeClass("is-invalid");
                $(".error_treatment_discount").html("");
            }

            if (response.error.treatment_discount_price) {
                $("#treatment_discount_price").addClass("is-invalid");
                $(".error_treatment_discount_price").html(response.error.treatment_discount_price);
            } else {
                $("#treatment_discount_price").removeClass("is-invalid");
                $(".error_treatment_discount_price").html("");
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
                $("#modaldiscount").modal("hide");
                datatable_treatment();
            }
            }
        },
        });
        });
    });
</script>