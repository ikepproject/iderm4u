<!-- Modal -->
<div class="modal fade" id="modalpayinfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card text-left">
                        <div class="card-body">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Bank :</b></td>
                                            <td><?= $midtrans['bank'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Status :</b></td>
                                            <td><?= $midtrans['transaction_status'] ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nomor VA :</b></td>
                                            <td><?= $midtrans['va_number'] ?></td>
                                        </tr>
                                        <?php if ($midtrans['payment_type'] == 'echannel') { ?> 
                                        <tr>
                                            <td><b>Kode :</b></td>
                                            <td>70012</td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td><b>Sisa Waktu Bayar :</b></td>
                                            <td>
                                                <p id="demo"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
            
            
        </div><!-- /.modal-content -->
       
    </div><!-- /.modal-dialog -->
</div>
<!-- Plugins js-->

<script>
    // Set the date we're counting down to
    let exp = <?= $exp ?>;
    var countDownDate = new Date(exp).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();
        
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
        
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = hours + " jam "
    + minutes + " menit " + seconds + " detik ";
        
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
    }, 1000);
</script>