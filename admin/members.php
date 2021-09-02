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
          case 'add_member';
          include "includes/add_member.php";
          break;

          case 'edit_member';
          include "includes/edit_member.php";
          break;

          case 'edit_member_photo';
          include "includes/edit_member_photo.php";
          break;

          default:
          include "includes/view_all_members.php";
      }
    ?>
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include "includes/footer.php"; ?>