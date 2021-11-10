<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<section>
  <?php
    $query = "SELECT * FROM terms_and_conditions ORDER BY id LIMIT 1";
    $result = mysqli_query($connection, $query);
  
    while ($row = mysqli_fetch_assoc($result)) {
        $page_content = $row['page_content'];
        if(!empty($page_content)){
          echo "<div class='terms-container'>".$page_content."</div>";
        }  
    }

  ?>

</section>


<?php include "PHP/footer.php"; ?>