<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Pasien</h4>
                        <button type="button" class="btn btn-primary waves-effect waves-light mb-4 add">
                            <i class="bx bx-plus-circle font-size-16 align-middle me-2"></i> Tambah
                        </button>
                        <button type="button" class="btn btn-success waves-effect waves-light mb-4">
                            <i class="bx bx-import font-size-16 align-middle me-2"></i> Import Data
                        </button>
                        

                        <div class="dataPatien">
                        </div>

                        <div class="addmodal">
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
function datatable_patient() {
  $.ajax({
    url: "patient/getdata",
    dataType: "json",
    success: function (response) {
      $(".dataPatien").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_patient();
  $(".add").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: "patient/formadd",
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