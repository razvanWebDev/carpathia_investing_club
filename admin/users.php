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
          case 'add_user';
          include "includes/add_user.php";
          break;

          case 'edit_user';
          include "includes/edit_user.php";
          break;

          case 'edit_user_photo';
          include "includes/edit_user_photo.php";
          break;

          default:
          include "includes/view_all_users.php";
      }
    ?>
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include "includes/footer.php"; ?>