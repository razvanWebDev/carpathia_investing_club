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
          case 'add_article';
          include "includes/add_article.php";
          break;

          case 'edit_article';
          include "includes/edit_article.php";
          break;

          case 'edit_article_photo';
          include "includes/edit_article_photo.php";
          break;

          default:
          include "includes/view_all_articles.php";
      }
    ?>
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<?php include "includes/footer.php"; ?>