<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Order Produk Pasien</h4>

                        <div class="dataorder">
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
function datatable_order() {
  $.ajax({
    url: "order/getdata",
    dataType: "json",
    success: function (response) {
      $(".dataorder").html(response.data);
    },
  });
}

$(document).ready(function () {
  datatable_order();
});

</script>

<?= $this->endSection('isi') ?>