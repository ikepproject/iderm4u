<!-- Modal -->
<div class="modal fade" id="modaldiagnose" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
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
                        <a class="nav-link active" data-bs-toggle="tab" href="#diagnose-1" role="tab">
                            <span class="d-block d-md-none"><i class="fas fa-notes-medical"></i></span>
                            <span class="d-none d-md-block"><i class="fas fa-notes-medical mr-2"></i> Diagnosis</span> 
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#smart-1" role="tab">
                            <span class="d-block d-md-none"><i class="bx bx-chip"></i></span>
                            <span class="d-none d-md-block"><i class="bx bx-chip mr-2"></i> Smart Detection</span>   
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">

                    <div class="tab-pane active" id="diagnose-1" role="tabpanel">
                    <?= form_open('medical/diagnose', ['class' => 'formdiagnose']) ?>
                    <?= csrf_field(); ?>
                        <input type="hidden" class="form-control" id="medical_code" name="medical_code" value="<?= $medical['medical_code'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Pasien</label>
                            <input type="text" class="form-control" value="<?= $patient_user['user_name'] ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Diagnosis<code>*</code></label>
                            <select class="form-control" name="medical_diagnose" id="medical_diagnose" onchange="showDiv(this)">
                                <option selected disabled>Pilih...</option>
                                <option value="Disease A">Disease A</option>
                                <option value="Disease B">Disease B</option>
                                <option value="Lain">Lain...</option>
                            </select>
                            <div class="invalid-feedback error_medical_diagnose"></div>
                        </div>
                        <div class="mb-3" id="hidden_diagnose" style="display: none;">
                            <label class="form-label">Diagnosis Lainnya<code>*</code></label>
                            <input type="text" name="medical_diagnose_other" id="medical_diagnose_other" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="medical_diagnose_note" class="form-label">Catatan Diagnosis</label>
                            <textarea class="form-control" id="medical_diagnose_note" name="medical_diagnose_note"></textarea>
                        </div>

                        
                        <button type="submit" class="btn btn-primary" id="save" name="save"><i class="bx bx-save"></i> Simpan Diagnosis</button>
                    <?= form_close() ?>
                    </div>

                    <div class="tab-pane" id="smart-1" role="tabpanel">
                        <div class="text-center mb-3 mt-1">
                            <button class="btn btn-primary" id="classify-all-btn">
                                <i class="bx bx-chip mr-2"></i> Run Smart Detection
                            </button>
                        </div>
                        
                        <div id="carouselDiagnose" class="carousel slide carousel-left" data-bs-ride="carousel" data-bs-interval="false">
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="margin-bottom: 12rem;">
                            <?php
                            $nmr = -1;
                            foreach ($diagnose_medgal as $cr1) :
                            $nmr++;   ?>
                            
                            <li style="background-color: #556ee6;" data-bs-target="#carouselDiagnose" data-bs-slide-to="<?=  $nmr ?>"  <?php if ($nmr == 0) { ?> class="active" <?php } ?>  ></li>
                                
                            <?php endforeach; ?>

                            <?php if ($medgal_refer != NULL) {?>
                                <?php
                                foreach ($medgal_refer as $cr3) :
                                $nmr++;   ?>
                                
                                <li style="background-color: #556ee6;" data-bs-target="#carouselDiagnose" data-bs-slide-to="<?=  $nmr ?>"  <?php if ($nmr == 0) { ?> class="active" <?php } ?>  ></li>
                                    
                                <?php endforeach; ?>
                            <?php } ?>
                            </ol>
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                
                                <?php
                                $nmr2 = -1;
                                foreach ($diagnose_medgal as $cr2) :
                                $nmr2++;   ?>
                                
                                    <div class="carousel-item <?php if ($nmr2 == 0) { ?> active <?php } ?>">
                                        <img style="object-fit:scale-down;width:350px;height:350px;" src="<?= base_url() ?>public/assets/images/medical/ori/<?= $cr2['medgal_filename'] ?>" class="img-fluid mx-auto d-block" data-img-id="<?= $cr2['medgal_id'] ?>">
                                        <div class="card border mt-3">
                                            <div class="card-header bg-transparent ">
                                                <h5 class="my-0 text-primary"><i class="bx bx-chip"></i>Hasil Smart Detection</h5>
                                            </div>
                                            <div class="card-body">
                                            <?php
                                            if ($cr2['medgal_prediction'] != NULL) {
                                                $json = $cr2['medgal_prediction'];

                                                $data = json_decode($json, true);

                                                foreach ($data as $item) {
                                                    echo $item['class'] . " = " . $item['score'] . " %<br>";
                                                }
                                            }
                                            ?>
                                            <?php if ($cr2['medgal_prediction_create'] != NULL) { ?>
                                                <br>
                                                <i class="bx bx-time"></i> <i>Running Prediksi</i> = <?= shortdate_indo(substr($cr2['medgal_prediction_create'],0,10)) ?>, <?= substr($cr2['medgal_prediction_create'],11,5)?> WIB 
                                                
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                <?php endforeach; ?>

                                <?php if ($medgal_refer != NULL) {?>
                                    <?php
                                    foreach ($medgal_refer as $cr4) :
                                    $nmr2++;   ?>
                                    
                                        <div class="carousel-item <?php if ($nmr2 == 0) { ?> active <?php } ?>">
                                            <img style="object-fit:scale-down;width:350px;height:350px;" src="<?= base_url() ?>public/assets/images/medical/ori/<?= $cr4['medgal_filename'] ?>" class="img-fluid mx-auto d-block" data-img-id="<?= $cr4['medgal_id'] ?>" >
                                            <div class="card border mt-3">
                                                <div class="card-header bg-transparent ">
                                                    <h5 class="my-0 text-primary"><i class="bx bx-chip"></i>Hasil Smart Detection</h5>
                                                </div>
                                                <div class="card-body">
                                                <?php
                                                if ($cr4['medgal_prediction'] != NULL) {
                                                    $json = $cr4['medgal_prediction'];

                                                    $data = json_decode($json, true);

                                                    foreach ($data as $item) {
                                                        echo $item['class'] . " = " . $item['score'] . " %<br>";
                                                    }
                                                }
                                                    
                                                ?>
                                                <?php if ($cr4['medgal_prediction_create'] != NULL) { ?>
                                                    <br>
                                                    <i class="bx bx-time"></i> <i>Running Prediksi</i> = <?= shortdate_indo(substr($cr4['medgal_prediction_create'],0,10)) ?>, <?= substr($cr4['medgal_prediction_create'],11,5)?> WIB 
                                                    
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php endforeach; ?>
                                <?php } ?>
                                <!-- Controls -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDiagnose" data-bs-slide="prev">
                                    <span> <h1><i class="fa fa-angle-left text-primary" aria-hidden="true"></i></h1> </span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselDiagnose" data-bs-slide="next">
                                    <span> <h1><i class="fa fa-angle-right text-primary" aria-hidden="true"></i></h1> </span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
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
<script>
    function showDiv(select){
        if(select.value=="Lain"){
            document.getElementById('hidden_diagnose').style.display = "block";
            } else{
            document.getElementById('hidden_diagnose').style.display = "none";
        }
    } 

    $(document).ready(function () {
        $('#medical_diagnose_note').val("<?= $medical['medical_diagnose_note'] ?>");

        $(".formdiagnose").submit(function (e) {
            e.preventDefault();
            $.ajax({
            type: "post",
            url: $(this).attr("action"),
            data: {
                medical_code: $('input#medical_code').val(),
                medical_diagnose: $('select#medical_diagnose').val(),
                medical_diagnose_other: $('input#medical_diagnose_other').val(),
                medical_diagnose_note: $('textarea#medical_diagnose_note').val(),
            },
            // processData: false,
            // contentType: false,
            dataType: "json",
            beforeSend: function () {
                $("#save").attr("disabled", true);
                $("#save").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
                );
            },
            complete: function () {
                $("#save").removeAttr("disabled", false);
                $("#save").html("Simpan Diagnosis");
            },
            success: function (response) {
                if (response.error) {

                if (response.error.medical_diagnose) {
                    $("#medical_diagnose").addClass("is-invalid");
                    $(".error_medical_diagnose").html(response.error.medical_diagnose);
                } else {
                    $("#medical_diagnose").removeClass("is-invalid");
                    $(".error_medical_diagnose").html("");
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
                    $("#modaldiagnose").modal("hide");
                    datatable_refer();
                }
                }
            },
            });
        });
    });
</script>

<script>
    async function classifyImagesAndSendResults() {
        const images = document.querySelectorAll('.carousel-item img');
        const results = [];

        for (const image of images) {
            const imgId = image.dataset.imgId;
            const imgSrc = image.src;

            try {
                const response = await fetch('https://clasifier.iderm4u.com/classify', {
                    method: 'POST',
                    body: JSON.stringify({ imageUrl: imgSrc }),
                    headers: { 'Content-Type': 'application/json' },
                });

                const responseText = await response.text();
                console.log('Raw response text for image ID', imgId, ':', responseText);
                const result = JSON.parse(responseText);

                // Send the result to the CodeIgniter 4 API
                const apiResponse = await fetch('/api/diagnose/aiclasify', {
                    method: 'POST',
                    body: JSON.stringify({ img_id: imgId, result: result }),
                    headers: { 'Content-Type': 'application/json' },
                });

                if (!apiResponse.ok) {
                    console.error('Error saving result for image ID:', imgId);
                } else {
                    results.push({ imgId, result });
                }
            } catch (error) {
                console.error('Error classifying image ID:', imgId, error);
            }
        }

        console.log('Classification results:', results);

        // Redirect to the current URL (refresh the page)
        window.location.reload();
    }

    // Add a click event listener to the button
    document.getElementById('classify-all-btn').addEventListener('click', classifyImagesAndSendResults);
</script>
