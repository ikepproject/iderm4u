<?= $this->extend('partials/main_report') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Ekspor Laporan Treatment</h4>
                        <form method="POST" action="<?= base_url('report-treatment/filter') ?>">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="month_filter">Bulan</label>
                              <select class="form-control select2-retreat" name="month_filter" id="month_filter" >
                                    <option value="all" <?php if ($month == 'all') echo "selected"; ?> > Semua </option>
                                  <?php foreach ($unique_month as $data) { ?>
                                    <option value="<?= $data['month_number'] ?>" <?php if ($data['month_number'] == $month) echo "selected"; ?> > <?= $data['month_name'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="year_filter">Tahun</label>
                              <select class="form-control select2-retreat" name="year_filter" id="year_filter">
                                  <?php foreach ($unique_year as $key => $data) { ?>
                                  <option value="<?= $data['year'] ?>" <?php if ($data['year'] == $year) echo "selected"; ?> > <?= $data['year'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <button type="submit" class="btn btn-primary mt-4">Filter</button>
                            </div>
                          </div>
                        </form>
                        
                        <div class="row mb-3">
                          <h4 class="text-center"> 
                            <?php if ($month != 'all') { ?> 
                              <strong>Laporan Register Tindakan (Treatment) 
                                <br> Bulan <?= date("F", mktime(0, 0, 0, ltrim($month, '0'), 1)); ?> <?= $year ?> 
                              </strong>
                            <?php } ?>
                            <?php if ($month == 'all') { ?> 
                              <strong>Laporan Register Tindakan (Treatment) 
                                <br> Tahun <?= $year ?> 
                              </strong>
                            <?php } ?>
                          </h4>
                          <table id="datatable-report-treatment" class="table table-striped table-bordered dt-responsive wrap w-100 ">
                            <thead>
                                <tr class="table-secondary">
                                    <th width=2%>No.</th>
                                    <th width=10%>Tanggal</th>
                                    <th width=10%>Tindakan</th>
                                    <th width=8%>ID Data Medis</th>
                                    <th width=8%>No. Invoice</th>
                                    <th width=9%>Keterangan Promo</th>
                                    <th width=8%>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nomor = 0;
                            foreach ($list as $data) :
                                $nomor++; ?>
                                <tr>
                                    <td><?= $nomor ?></td>
                                    <td><?= shortdate_indo(substr($data['medical_create'],0,10)) ?>, <?= substr($data['medical_create'],11,5)?> </td>
                                    <td><?= $data['medtreat_name'] ?></td>
                                    <td><?= $data['medical_code'] ?></td>
                                    <td><?= $data['invoice_code'] ?></td>
                                    <td>
                                      <?php if ($data['medtreat_discount'] == NULL) { ?> 
                                        -
                                      <?php } ?>
                                      <?php if ($data['medtreat_discount'] != NULL) { ?> 
                                        <?= $data['medtreat_discount'] ?>, 
                                      <?php } ?>
                                      <?php if ($data['medtreat_discount_price'] != NULL) { ?> 
                                        Harga asli Rp <?= rupiah($data['medtreat_discount_price']) ?> 
                                      <?php } ?>
                                    </td>
                                    <td>Rp <?= rupiah($data['medtreat_price']) ?></td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                        
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<script>
  $(document).ready(function () {
      $('.select2-retreat').select2({
            minimumResultsForSearch: Infinity
        });

      //product Table
      var table_report_treatment = $("#datatable-report-treatment").DataTable({
      stateSave: true,
      lengthChange: true,
      lengthMenu: [
          [25, 70, 100, -1],
          [25, 70, 100, "All"],
      ],
      buttons: [
        "copy", 
        {
          extend: "excel",
          customize: function (xlsx) {
              var sheet = xlsx.xl.worksheets["sheet1.xml"];

              // Apply borders to all cells
              $('row c', sheet).each(function () {
                  $(this).attr('s', '25');
              });

              // Make title bigger and bold
              $('row:first c', sheet).attr("s", "51");
          },
        },
        {
          extend: "pdf",
          orientation: "landscape",
          pageSize: "A4",
        }],
      });

      table_report_treatment
      .buttons()
      .container()
      .appendTo("#datatable-report-treatment_wrapper .col-md-6:eq(0)");

      $(".dataTables_length select").addClass("form-select form-select-sm");
  });
</script>


<?= $this->endSection('isi') ?>