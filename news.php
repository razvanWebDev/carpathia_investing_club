<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<section id="news-section">
  <h2 class="section-title">News</h2>
<?php
  //pagination
  $rowCounter_per_page = 0;
  //the number of posts per page
  $articles_per_page = 12;

  if(isset($_GET['page'])){
      $page = $_GET['page'];
  }else{
      $page = 1;
  }

  if($page == "" || $page == 1){
      $page_1 = 0;
  }else{
      $page_1 = ($page * $articles_per_page) - $articles_per_page;
  }

  $post_query_count = "SELECT * FROM news";
  $select_post_query_count = mysqli_query($connection, $post_query_count);
  $count = mysqli_num_rows($select_post_query_count);
  $count = ceil($count / $articles_per_page); 

  $query = "SELECT * FROM news ORDER BY date DESC LIMIT $page_1, $articles_per_page";
  $select_users = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($select_users)) {
    $rowCounter_per_page++;
    $totalRowCounter = $rowCounter_per_page + (($page-1) * $articles_per_page);
    
    $id = $row['id'];
    $title = (!empty($row['title']) ? $row['title'] : "");
    $date = $row['date'];
    $formated_date = date('d/m/Y',strtotime($date));
    $image = (!empty($row['image']) ? $row['image'] : "");
    $article_text = (!empty($row['article_text']) ? $row['article_text'] : ""); 

?>

  <article class="news-article">
    <h3 class="article-title"><?php echo $title ?></h3>
    <p class="article-date"><i>Published:</i> <?php echo $formated_date ?></p>
    <div>
      <?php
        if(!empty($image)){
      ?>
        <img src="img/news/<?php echo $image ?>" alt="Article poster" class="article-image">
      <?php } ?>

      <div> <?php echo $article_text ?></div>
    </div>
  </article>

  <?php } ?>

</section>

<nav class="pagination-container">
  <div class="pagination">
    <?php
  if($count > 1){
      for($i = 1; $i <= $count; $i++){
          if($i == $page){
              echo "<a class='page-item active' href='news.php?page={$i}'>$i</a>";
          }else{
              echo "<a class='page-item' href='news.php?page={$i}'>$i</a>";
          }
      }
  }
  ?>
  </div>
</nav>

<?php include "PHP/footer.php"; ?>