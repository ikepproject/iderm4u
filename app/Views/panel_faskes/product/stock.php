<!-- Modal -->
<div class="modal fade" id="modalstock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#restock-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-notes-medical"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-notes-medical mr-2"></i> Restock Form</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#history-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-history"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-history mr-2"></i> Riwayat Restock</span>   
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="restock-1" role="tabpanel">
                        <?= form_open('product/restock', ['class' => 'formrestock']) ?>
                        <?= csrf_field(); ?>
                            <div class="row">
                                    <input type="hidden" id="product_code" name="product_code" value="<?= $product['product_code'] ?>">
                                    <div class="mb-3">
                                        <label for="stock_type" class="form-label">Tindakan <code>*</code></label>
                                        <select class="form-select" id="stock_type" name="stock_type">
                                            <option selected disabled>Pilih...</option>
                                            <option value="Penambahan">+ Penambahan</option>
                                            <option value="Pengurangan">- Pengurangan</option>
                                        </select>
                                        <div class="invalid-feedback error_stock_type"></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="col">

                                        </div>
                                        <div class="col">
                                            <label for="stock_qty" class="form-label">Jumlah Restock<code>*</code></label>
                                            <input type="number" class="form-control" id="stock_qty" name="stock_qty" placeholder="Masukan jumlah restock produk..." >
                                            <div class="invalid-feedback error_stock_qty"></div>
                                        </div>
                                        
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock_description" class="form-label">Keterangan Restcok</label>
                                        <textarea class="form-control" id="stock_description" name="stock_description">
                                        </textarea>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" id="restock" name="restock"><i class="bx bx-save"></i> Restcok</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                    <div class="tab-pane" id="history-1" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr class="table-secondary">
                                        <th width="2%">#</th>
                                        <th width="20%">Tgl</th>
                                        <th width="18%">Jumlah</th>
                                        <th width="50%">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $nomor = 0;
                                foreach ($stock as $data) :
                                $nomor++; ?>
                                    <tr <?php if ($data['stock_type'] == 'Penambahan') { ?> class="table-success" <?php } ?> <?php if ($data['stock_type'] == 'Pengurangan') { ?> class="table-danger" <?php } ?> >
                                        <th scope="row"><?= $nomor ?></th>
                                        <td><?= longdate_indo(substr($data['stock_create'],0,10)) ?></td>
                                        <td>
                                            <?php if ($data['stock_type'] == 'Penambahan') { ?> + <?php } ?>
                                            <?php if ($data['stock_type'] == 'Pengurangan') { ?> - <?php } ?>
                                            <?= $data['stock_qty'] ?>
                                        </td>
                                        <td><?= $data['stock_description'] ?></td>
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

        $(".formrestock").submit(function (e) {
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
            $("#restock").attr("disabled", true);
            $("#restock").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#restock").removeAttr("disabled", false);
            $("#restock").html("Restock");
        },
        success: function (response) {
            if (response.error) {
            if (response.error.stock_type) {
                $("#stock_type").addClass("is-invalid");
                $(".error_stock_type").html(response.error.stock_type);
            } else {
                $("#stock_type").removeClass("is-invalid");
                $(".error_stock_type").html("");
            }

            if (response.error.stock_qty) {
                $("#stock_qty").addClass("is-invalid");
                $(".error_stock_qty").html(response.error.stock_qty);
            } else {
                $("#stock_qty").removeClass("is-invalid");
                $(".error_stock_qty").html("");
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
                $("#modalstock").modal("hide");
                datatable_product();
            }
            }
        },
        });
        });
    });
</script>