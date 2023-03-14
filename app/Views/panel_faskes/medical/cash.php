<!-- Modal -->
<div class="modal fade" id="modalcash" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="text" class="form-control" id="invoice_amount" name="invoice_amount" value="<?= $invoice['invoice_amount'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="invoice_pay" class="form-label">Dibayar<code>*</code></label>
                    <input type="text" class="form-control" id="invoice_pay" name="invoice_pay" >
                    <div class="invalid-feedback error_invoice_pay"></div>
                </div>
                <div class="mb-3">
                    <label for="invoice_back" class="form-label">Kembalian<code>*</code></label>
                    <input type="text" class="form-control" id="invoice_back" name="invoice_back" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="cash" name="cash"><i class="bx bx-dollar"></i> Bayar</button>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<script>
$(document).ready(function () {

    // $('#invoice_pay').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
});

function invoice_back(){
    const amount = document.getElementById('invoice_amount').value;
    const pay = document.getElementById('invoice_pay').value;
    const back = pay - amount;
    document.getElementById('invoice_back').value = back; 
}
</script>