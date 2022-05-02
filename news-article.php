<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<section id="news-section">
  <h2 class="section-title">News</h2>
  <?php
  $article_id = "";
  if(isset($_GET['articleId'])){
    $article_id = $_GET['articleId'];
  }

  $query = "SELECT * FROM news WHERE id = $article_id AND status = 'Published' ORDER BY date DESC LIMIT 1";
  $select_users = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($select_users)) {
    
    $id = $row['id'];
    $title = (!empty($row['title']) ? $row['title'] : "");
    $ticker = (!empty($row['ticker']) ? $row['ticker'] : "");
    $subtitle = (!empty($row['subtitle']) ? $row['subtitle'] : "");
    $date = $row['date'];
    $formated_date = date('d/m/Y',strtotime($date));
    $image = (!empty($row['image']) ? $row['image'] : "");
    $article_text = (!empty($row['article_text']) ? $row['article_text'] : ""); 

?>

  <article class="news-article">
    <h1 class="article-title">
      <?php echo $title ?>
      <?php if(!empty($ticker)){ ?>
      <span class="ticker-span">
        [<?php echo $ticker ?>]
      </span>
      <?php } ?>
    </h1>
    <p class="article-date"><i>Published:</i>
      <?php echo $formated_date ?>
    </p>
    <div class="article-content full-article-content">
      <?php
        if(!empty($image)){
      ?>
      <img src="img/news/<?php echo $image ?>" alt="Article poster" class="article-image full-article-image">
      <?php } ?>

      <?php if(!empty($subtitle)){ ?>
      <h2 class="article-subtitle">
        <?php echo $subtitle ?>
      </h2>
      <?php } ?>
      <?php echo $article_text ?>
    </div>
  </article>

  <?php } ?>

  <?php include "PHP/newsletter_form.php"; ?>

</section>

<?php include "PHP/footer.php"; ?>