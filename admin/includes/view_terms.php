<?php $page_title = "Terms & Conditions"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">

      <a href="terms.php?source=edit_terms" class="btn bg-primary mb-4">
        <i class="far fa-edit mr-2"></i>Edit page
      </a>
      <br><br>

      <?php
  $query = "SELECT * FROM terms_and_conditions ORDER BY id LIMIT 1";
  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result)) {
      $page_content = $row['page_content'];

      echo "<div>".$page_content."</div>";
  }
?>



    </div>
  </div>
  <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->