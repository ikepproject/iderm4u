<?= $this->extend('partials/main_report') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Laporan Produk</h4>
                        <form method="POST" action="<?= base_url('report-product/filter') ?>">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="month_filter">Bulan</label>
                              <select class="form-select" name="month_filter" id="month_filter" >
                                    <option value="all" <?php if ($month == 'all') echo "selected"; ?> > Semua </option>
                                  <?php foreach ($unique_month as $data) { ?>
                                    <option value="<?= $data['month_number'] ?>" <?php if ($data['month_number'] == $month) echo "selected"; ?> > <?= $data['month_name'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="year_filter">Tahun</label>
                              <select class="form-select" name="year_filter" id="year_filter">
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
                              <strong>Laporan Register Penjualan Produk 
                                <br> Bulan <?= date("F", mktime(0, 0, 0, ltrim($month, '0'), 1)); ?> <?= $year ?> 
                              </strong>
                            <?php } ?>
                            <?php if ($month == 'all') { ?> 
                              <strong>Laporan Register Penjualan Produk 
                                <br> Tahun <?= $year ?> 
                              </strong>
                            <?php } ?>
                          </h4>
                          <table id="datatable-report-product" class="table table-striped table-bordered dt-responsive wrap w-100 ">
                            <thead>
                                <tr class="table-secondary">
                                    <th width=2%>No.</th>
                                    <th width=10%>Tanggal</th>
                                    <th width=10%>Produk</th>
                                    <th width=6%>Jenis</th>
                                    <th width=5%>Jumlah</th>
                                    <th width=8%>ID Data Medis</th>
                                    <th width=8%>No. Invoice</th>
                                    <th width=9%>Harga Satuan</th>
                                    <th width=8%>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nomor = 0;
                            foreach ($list as $data) :
                                $nomor++; ?>
                                <tr>
                                    <td><?= $nomor ?></td>
                                    <td><?= shortdate_indo(substr($data['medical_create'],0,10)) ?>, <?= substr($data['medical_create'],11,5)?>WIB</td>
                                    <td><?= $data['medprod_name'] ?></td>
                                    <td><?= $data['product_type'] ?></td>
                                    <td><?= $data['medprod_qty'] ?> <?= $data['product_unit'] ?></td>
                                    <td><?= $data['medical_code'] ?></td>
                                    <td><?= $data['invoice_code'] ?></td>
                                    <td>@ Rp <?= rupiah($data['medprod_price']) ?></td>
                                    <td>Rp <?= rupiah($data['medprod_price']*$data['medprod_qty']) ?></td>
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
      //product Table
      var table_report_product = $("#datatable-report-product").DataTable({
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

      table_report_product
      .buttons()
      .container()
      .appendTo("#datatable-report-product_wrapper .col-md-6:eq(0)");

      $(".dataTables_length select").addClass("form-select form-select-sm");
  });
</script>

<?= $this->endSection('isi') ?>