<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Rujukan Pasien</h4>

                        <div class="datarefer">
                        </div>
                        
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
function datatable_refer() {
  $.ajax({
    url: "refer/getdata",
    dataType: "json",
    success: function (response) {
      $(".datarefer").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_refer();
});

</script>

<?= $this->endSection('isi') ?>