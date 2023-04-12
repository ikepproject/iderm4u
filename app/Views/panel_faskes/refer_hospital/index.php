<?= $this->extend('partials/main') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Rujukan <?php if ($type_refer == 'Visit') { ?>Kunjungan<?php }else{ ?> Teledermatologi <?php }?></h4>

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
  var type_refer = "<?= $type_refer ?>";
  var getUrl = null;
  if (type_refer == 'Visit') {
    getUrl = "refer-visit/getdata";
  } else {
    getUrl = "refer-teledermatology/getdata";
  }
  $.ajax({
    url: getUrl,
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