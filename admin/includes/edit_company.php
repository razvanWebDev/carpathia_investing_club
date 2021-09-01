<?php 
    if(isset($_GET['id'])) {
        $the_company_id = $_GET['id'];
    }
    
    $query = "SELECT * FROM portfolio WHERE id = $the_company_id";
    $select_company_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_company_by_id)) {
      $id = $row['id'];
      $date_pitched = $row['date_pitched'];
      $company = $row['company'];
      $ticker = $row['ticker'];
      $purchased = $row['purchased'];
      $purchase_price = $row['purchase_price'];
      $exit_price = $row['exit_price'];   
      $exit_date = $row['exit_date'];
    }

    if(isset($_POST['edit'])) {
        
      $date_pitched = escape($_POST['date_pitched']);

      $company = escape($_POST['company']);
      $ticker = escape($_POST['ticker']);
      $purchased = escape($_POST['purchased']);
      $purchase_price = escape($_POST['purchase_price']);
      $exit_price = escape($_POST['exit_price']);

      $exit_date = escape($_POST['exit_date']);

      editPortfolioCompany($the_company_id, $date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price, $exit_date);

      header("Location: portfolio.php");
      exit();
    }
?>

<?php $page_title = "Edit company $company"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
<form id="edit-company-form" action="" method="post" enctype="multipart/form-data">
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
                <input type="date" value=<?php echo $date_pitched ?> name="date_pitched" class="form-control">
              </div>
              <div class="form-group">
                <label for="company">Company</label>
                <input type="text" name="company" class="form-control" value=<?php echo $company ?>>
              </div>
              <div class="form-group">
                <label for="ticker">Ticker</label>
                <input type="text" name="ticker" class="form-control" value=<?php echo $ticker ?>>
              </div>
              <div class="form-group">
                <label for="purchased">Purchased</label>
                <select name="purchased" class="form-control">
                  <option value="No" <?php echo $purchased=="No" ? "selected" : "" ?>>No</option>
                  <option value="Yes" <?php echo $purchased=="Yes" ? "selected" : "" ?>>Yes</option>
                  <option value="Under Review" <?php echo $purchased=="Under Review" ? "selected" : "" ?>>Under Review</option>
                </select>
              </div>
              <div class="form-group">
                <label for="purchase_price">Purchase Price</label>
                <input type="number" step="any" name="purchase_price" class="form-control" value=<?php echo $purchase_price ?>>
              </div>
              <div class="form-group">
                <label for="exit_price">Exit Price</label>
                <input type="number" step="any" name="exit_price" class="form-control" value=<?php echo $exit_price ?>>
              </div>
              <div class="form-group">
                <label for="exit_date">Exit Date</label>
                <input type="date" value=<?php echo $exit_date ?> name="exit_date" class="form-control">
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

    </div>
    <div class="row">
      <div class="col-12">
        <a href="portfolio.php" class="btn btn-secondary">Cancel</a>
        <input onclick="return confirm('Edit company?')" type="submit" value="Edit company" name="edit"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->