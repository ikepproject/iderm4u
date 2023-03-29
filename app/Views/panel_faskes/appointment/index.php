<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Janji Temu Pasien (Appointment)</h4>

                        <div class="dataappointment">
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
    url: "appointment/getdata",
    dataType: "json",
    success: function (response) {
      $(".dataappointment").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_appointment();
});

</script>

<?= $this->endSection('isi') ?>