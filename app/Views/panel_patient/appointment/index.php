<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Janji Temu (Appointment)</h4>

                        <?php if (count($pending) == 0) { ?> 
                          <button type="button" class="btn btn-primary waves-effect waves-light mb-4 add">
                            <i class="bx bx-plus-circle font-size-16 align-middle me-2"></i> Buat Appointment
                          </button>
                        <?php } ?>

                        <?php if (count($pending) != 0) { ?>
                          <div class="col-lg-4 mt-3">
                            <div class="card border border-warning">
                              <div class="card-body">
                                <div class="card-title bg-transparent border-warning">
                                    <h5 class="my-0 text-warning"><i class="mdi mdi-alert-outline me-3 me-3"></i>Perhatian</h5>
                                </div>
                                  <p class="card-text">Anda tidak dapat mengajukan appointment karena masih memiliki pengajuan appointment yang belum dikonfirmasi.</p>
                              </div>
                            </div>
                          </div>
                          
                        <?php } ?>

                        <div class="dataappointment">
                        </div>

                        <div class="addmodal">
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
function datatable_appointment() {
  $.ajax({
    url: "appointment-getdata",
    dataType: "json",
    success: function (response) {
      $(".dataappointment").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_appointment();
  $(".add").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: "appointment-formadd",
      dataType: "json",
      success: function (response) {
        $(".addmodal").html(response.data).show();

        $("#modaladd").modal("show");
      },
    });
  });
});


</script>


<?= $this->endSection('isi') ?>