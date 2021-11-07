<?php 

    
    $query = "SELECT * FROM terms_and_conditions WHERE id = 1";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $db_page_content = $row['page_content'];
    }

    if(isset($_POST['edit'])) {
        
      $page_content = trim($_POST['page_content']);
      editTermsAndConditions($page_content);

      header("Location: terms.php");
      exit();
    }
?>

<?php $page_title = "Edit Terms & Conditions"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
  <form id="edit-company-form" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-info">
          <div class="card-body">
            <textarea id="summernote" name="page_content">
                <?php echo $db_page_content; ?>
              </textarea>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <div class="row">
      <div class="col-12">
        <a href="javascript:history.back(1)" class="btn btn-secondary">Cancel</a>
        <input onclick="return confirm('Edit Terms & Conditions?')" type="submit" value="Edit Terms & Conditions" name="edit"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->