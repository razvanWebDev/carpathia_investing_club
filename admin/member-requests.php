<?php include "includes/header.php"; ?>
<div class="wrapper">

  <?php include "includes/top_navbar.php"; ?>
  <?php include "includes/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php 
      if(isset($_GET['source'])) {
          $source = $_GET['source'];
      }else{
          $source = "";
      }

      switch($source) {

          default:
          include "includes/view_member_requsts.php";
      }
    ?>
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include "includes/footer.php"; ?>