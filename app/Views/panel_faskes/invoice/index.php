<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Invoice</h4>

                        <div class="datainvoice">
                        </div>
                        
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
function datatable_invoice() {
  $.ajax({
    url: "invoice/getdata",
    dataType: "json",
    success: function (response) {
      $(".datainvoice").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_invoice();
});

</script>

<?= $this->endSection('isi') ?>