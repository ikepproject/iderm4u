<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Treatment <?= $faskes_name ?></h4>
                        <?php if ($user['user_role'] != 1011) { ?> 
                          <button type="button" class="btn btn-primary waves-effect waves-light mb-4 add">
                            <i class="bx bx-plus-circle font-size-16 align-middle me-2"></i> Tambah
                          </button>
                        <?php } ?>
                        
                        <div class="dataTreatment">
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
function datatable_treatment() {
  $.ajax({
    url: "treatment/getdata",
    dataType: "json",
    success: function (response) {
      $(".dataTreatment").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_treatment();
  $(".add").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: "treatment/formadd",
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