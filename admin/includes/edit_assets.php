<?php 
  if(isset($_POST['edit'])) {
      
    $new_amount = escape($_POST['new_amount']);
    editAssets($new_amount, 1);

    header("Location: assets.php");
    exit();
  }
?>

<?php $page_title = "Edit assets under advisement"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
<form id="edit-company-form" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Enter new amount</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <input type="number" name="new_amount" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

    </div>
    <div class="row">
      <div class="col-12">
        <a href="javascript:history.back(1)" class="btn btn-secondary">Cancel</a>
        <input type="submit" value="Update" name="edit"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->