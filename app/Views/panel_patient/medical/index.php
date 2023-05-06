<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Riwayat Data Kunjungan Pasien</h4>

                        <div class="dataMedical">
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
function datatable_medical() {
  $.ajax({
    url: "medical-getdata",
    dataType: "json",
    success: function (response) {
      $(".dataMedical").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_medical();
});

</script>

<?= $this->endSection('isi') ?>