<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Kunjungan Pasien</h4>
                        <a type="button" href="medicalformadd" class="btn btn-primary waves-effect waves-light mb-4">
                            <i class="bx bx-plus-circle font-size-16 align-middle me-2"></i> Tambah
                        </a>

                        <div class="dataMedical">
                        </div>

                        <div class="detailmodal">
                        </div>

                        <div class="editmodal">
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
    url: "medical/getdata",
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