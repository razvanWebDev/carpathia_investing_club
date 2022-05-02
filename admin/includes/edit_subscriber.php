<?php 
    if(isset($_GET['id'])) {
        $selected_id = $_GET['id'];
    }
    
    $query = "SELECT * FROM newsletter WHERE id = $selected_id";
    $select_company_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_company_by_id)) {
      $id = $row['id'];
      $email = $row['email'];
    }

    if(isset($_POST['edit'])) {
        
      $email = escape($_POST['email']);

      editNewsletterSubscriber($selected_id, $email);

      header("Location: newsletter");
      exit();
    }
?>

<?php $page_title = "Edit newsletter subscriber"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
<form id="edit-company-form" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Subscriber</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="<?php echo $email ?>" name="email" class="form-control">
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
        <input onclick="return confirm('Edit subscriber?')" type="submit" value="Edit subscriber" name="edit"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->