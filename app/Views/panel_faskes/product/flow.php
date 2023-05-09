<?= $this->extend('partials/main_report') ?>
<?= $this->section('isi') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Data Flow Product</h4>
                        <form method="POST" action="<?= base_url('product-flow/filter') ?>">
                          <div class="row mb-3">
                            <div class="col">
                              <label for="month_filter">Bulan</label>
                              <select class="form-control select2-flow" name="month_filter" id="month_filter" >
                                    <option value="all" <?php if ($month == 'all') echo "selected"; ?> > Semua </option>
                                  <?php foreach ($unique_month as $data) { ?>
                                    <option value="<?= $data['month_number'] ?>" <?php if ($data['month_number'] == $month) echo "selected"; ?> > <?= $data['month_name'] ?> </option>
                                  <?php } ?>
                              </select>
                            </div>
                            <div class="col">
                              <label for="year_filter">Tahun</label>
                              <select class="form-control select2-flow" name="year_filter" id="year_filter">
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
                              <strong>Data Produk Masuk / Keluar 
                                <br> Bulan <?= date("F", mktime(0, 0, 0, ltrim($month, '0'), 1)); ?> <?= $year ?> 
                              </strong>
                            <?php } ?>
                            <?php if ($month == 'all') { ?> 
                              <strong>Data Produk Masuk / Keluar 
                                <br> Tahun <?= $year ?> 
                              </strong>
                            <?php } ?>
                          </h4>
                          <table id="datatable-flow-product" class="table table-striped table-bordered dt-responsive wrap w-100 ">
                            <thead>
                                <tr class="table-secondary">
                                    <th width=2%>No.</th>
                                    <th width=10%>Produk</th>
                                    <th width=5%>Jumlah</th>
                                    <th width=10%>Tgl</th>
                                    <th width=10%>ID</th>
                                    <th width=8%>Jenis</th>
                                    <th width=9%>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nomor = 0;
                            foreach ($list as $data) :
                                $nomor++; ?>
                                <tr <?php if ($data['stock_type'] == 'Penambahan') { ?> class="table-success" <?php } ?> <?php if ($data['stock_type'] == 'Pengurangan') { ?> class="table-danger" <?php } ?> >
                                    <td><?= $nomor ?></td>
                                    <td><?= $data['product_name'] ?></td>
                                    <td>
                                      <?php if ($data['stock_type'] == 'Penambahan') { ?> + <?php } ?>
                                      <?php if ($data['stock_type'] == 'Pengurangan') { ?> - <?php } ?>
                                      <?= $data['stock_qty'] ?>
                                    </td>
                                    <td><?= longdate_indo(substr($data['stock_create'],0,10)) ?></td>
                                    <td><?= $data['product_code'] ?></td>
                                    <td><?= $data['product_type'] ?></td>
                                    <td><?= $data['stock_description'] ?></td>
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
      $('.select2-flow').select2({
            minimumResultsForSearch: Infinity
        });

      //product Table
      var table_product = $("#datatable-flow-product").DataTable({
      stateSave: true,
      lengthChange: true,
      lengthMenu: [
          [25, 70, 100, -1],
          [25, 70, 100, "All"],
      ],
      buttons: ["copy", "excel", "pdf"],
      });

      table_product
      .buttons()
      .container()
      .appendTo("#datatable-flow-product_wrapper .col-md-6:eq(0)");

      $(".dataTables_length select").addClass("form-select form-select-sm");
  });
</script>

<?= $this->endSection('isi') ?>