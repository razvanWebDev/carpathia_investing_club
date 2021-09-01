<?php 
  if(isset($_POST['add_company'])) {
    $date_pitched = escape($_POST['date_pitched']);
    $company = escape($_POST['company']);
    $ticker = escape($_POST['ticker']);
    $purchased = escape($_POST['purchased']);
    $purchase_price = escape($_POST['purchase_price']);
    $exit_price = escape($_POST['exit_price']);

    addCompanytoPortfolio($date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price);

    header("Location: portfolio.php");
    exit();
  }
?>

<?php $page_title = "Add Company"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
  <form id="add-company-form" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Company details</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="date_pitched">Date Pitched</label>
                <input type="date" value=<?php echo date("Y-m-d") ?> name="date_pitched" class="form-control">
              </div>
              <div class="form-group">
                <label for="company">Company</label>
                <input type="text" name="company" class="form-control">
              </div>
              <div class="form-group">
                <label for="ticker">Ticker</label>
                <input type="text" name="ticker" class="form-control">
              </div>
              <div class="form-group">
                <label for="purchased">Purchased</label>
                <select name="purchased" class="form-control">
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  <option value='Under Review'>Under Review</option>
                </select>
              </div>
              <div class="form-group">
                <label for="purchase_price">Purchase Price</label>
                <input type="number" step="any" name="purchase_price" class="form-control">
              </div>
              <div class="form-group">
                <label for="exit_price">Exit Price</label>
                <input type="number" step="any" name="exit_price" class="form-control">
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="return confirm('Cancel?')" href="portfolio.php" class="btn btn-secondary">Cancel</a>
        <input onclick="return confirm('Add company?')" type="submit" value="Add company" name="add_company"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->