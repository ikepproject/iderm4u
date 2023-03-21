<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    input[type=number] {
        -moz-appearance:textfield; /* Firefox */
    }
</style>

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