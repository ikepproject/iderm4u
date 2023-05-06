<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><?= $title ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><b>ID Appointment</b></td>
                            <td><?= $appointment['appointment_code'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Nama Pengaju</b></td>
                            <td><?= $appointment['patient_name'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Faskes Tujuan</b></td>
                            <td><?= $appointment['faskes_name'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Appointment Status</b></td>
                            <td>
                            <?php if ($appointment['appointment_status'] == 'Diajukan') { ?> 
                                <span class="badge bg-secondary">Diajukan</span>
                            <?php } ?>
                            <?php if ($appointment['appointment_status'] == 'Dijadwalkan') { ?> 
                                <span class="badge bg-success">Dijadwalkan</span>
                            <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Tipe Appointment</b></td>
                            <td>
                            <?php if ($appointment['appointment_type'] == 'Lokal') { ?> 
                                <span class="badge bg-info">Kunjungan </span>
                            <?php } ?>
                            <?php if ($appointment['appointment_type'] == 'Teledermatologi') { ?> 
                                <span class="badge bg-warning">Rujuk Teledermatologi </span>
                            <?php } ?>
                            <?php if ($appointment['appointment_type'] == 'Kunjungan') { ?> 
                                <span class="badge bg-warning">Rujuk Kunjungan </span>
                            <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Diajukan pada Tgl</b></td>
                            <td>
                                <?php if ($appointment['appointment_create'] != NULL) { ?> 
                                    <?= longdate_indo(substr($appointment['appointment_create'],0,10)) ?> <?= substr($appointment['appointment_create'],11,5)?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Catatan Pengantar</b></td>
                            <td><?= $appointment['appointment_note_user'] ?></td>
                        </tr>
                        <tr>
                            <td><b>Estimasi Tgl Appointment</b></td>
                            <td>
                                <?php if ($appointment['appointment_date_expect'] != NULL) { ?> 
                                    <?= longdate_indo(substr($appointment['appointment_date_expect'],0,10)) ?> <?= substr($appointment['appointment_date_expect'],11,5)?>
                                <?php } ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td><b>Tanggal FINAL Appointment Terkonfirmasi</b></td>
                            <td>
                                <?php if ($appointment['appointment_date_fix'] != NULL) { ?> 
                                    <?= longdate_indo(substr($appointment['appointment_date_fix'],0,10)) ?> <?= substr($appointment['appointment_date_fix'],11,5)?>
                                <?php } ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td><b>Catatan dari Faskes</b></td>
                            <td><?= $appointment['appointment_note_faskes'] ?></td>
                        </tr>
                        <?php if ($appointment['appointment_type'] == 'Teledermatologi') { ?> 
                        <tr>
                            <td><b>Link Teledermatologi</b></td>
                            <td><?= $appointment['appointment_link'] ?></td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
        
       
    </div><!-- /.modal-dialog -->
</div>
