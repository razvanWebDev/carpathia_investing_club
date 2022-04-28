<?php
//get the article data
if(isset($_GET['id'])){
  $post_id = $_GET['id'];
}
$query = "SELECT * FROM news WHERE id = {$post_id}";
$result = mysqli_query($connection, $query);
$db_id = $db_title = $db_date = $db_image = $db_article_text = "";
while ($row = mysqli_fetch_assoc($result)) {
  $db_id = $row['id'];
  $db_title = (!empty($row['title']) ? $row['title'] : "");
  $db_ticker = (!empty($row['ticker']) ? $row['ticker'] : "");
  $db_subtitle = (!empty($row['subtitle']) ? $row['subtitle'] : "");
  $db_date = (!empty($row['date']) ? $row['date'] : "");
  $db_image = (!empty($row['image']) ? $row['image'] : ""); 
  $db_article_text = (!empty($row['article_text']) ? $row['article_text'] : "");
}

$invalidTitleClass = "";
$showTitleError = "none";
$titleErrorText = "";

$invalidTextClass = "";
$showTextError = "none";
$textErrorText = "";

//check for errors
if(isset($_GET['failed'])){
  if($_GET['failed'] == "true"){
    if(isset($_GET['titleErr'])){
      $showTitleError = "block";
      $invalidTitleClass = "is-invalid";
      if($_GET['titleErr'] == "required"){
        $titleErrorText .= "You must provide a title!";
      }
    }
    if(isset($_GET['textErr'])){
      $showTextError = "block";
      $invalidTitleClass = "is-invalid";
      if($_GET['textErr'] == "required"){
        $textErrorText .= "You must provide a decription text!";
      }
    }
  }
} 
//get input values in case of error
$titleInputValue = isset($_GET['title']) ? $_GET['title'] : $db_title;
$tickerInputValue = isset($_GET['ticker']) ? $_GET['ticker'] : $db_ticker;
$subtitleInputValue = isset($_GET['subtitle']) ? $_GET['subtitle'] : $db_subtitle;
$dateInputValue = isset($_GET['date']) ? $_GET['date'] : $db_date;
$textInputValue = isset($_GET["article_text"]) ? $_GET["article_text"] : $db_article_text;

if(isset($_POST['submit'])) {
  $title = escape($_POST['title']);
  $ticker = escape($_POST['ticker']);
  $subtitle = escape($_POST['subtitle']);
  $date = escape($_POST['date']);
  $article_text = $_POST['article_text'];
  
  $titleError = $textError =  "";

  // check for errors
  if(empty($title)){
    $titleError .= "&titleErr=required";
  }
  if(empty($article_text)){
    $textError .= "&textErr=required";
  }
 
  $error_msg = $titleError . $textError;

  if(!empty($error_msg)){
    header('Location: news.php?source=edit_article&id='.$post_id.'&failed=true'.$error_msg.'&title='.$title.'&ticker='.$ticker.'&subtitle='.$subtitle.'&date='.$date.'&article_text='.$article_text.'');
  }else{
    editArticle($title, $ticker, $subtitle, $date, $article_text, $db_id);
    header("Location: news.php");
    exit();
  }
}
?>

<?php $page_title = "Edit Article"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
  <form id="user-form" action="" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">General</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">

            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" class="form-control <?php echo $invalidTitleClass ?>"
                value="<?php echo $titleInputValue ?>">
              <span class="error invalid-feedback" style="display: <?php echo $showTitleError ?>">
                <?php echo $titleErrorText ?>
              </span>
            </div>

            <div class="form-group">
              <label for="ticker">Ticker</label>
              <input type="text" name="ticker" class="form-control" value="<?php echo $tickerInputValue ?>">
            </div>

            <div class="form-group">
              <label for="date">Date</label>
              <input type="date" name="date" class="form-control" value=<?php echo $dateInputValue; ?>>
            </div>

            <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <textarea name="subtitle" class="form-control">
                    <?php echo $subtitleInputValue ?>
                </textarea>
              </div>
            
            <div class="form-group">
              <label for="article_text">Article Text *</label>
              <span class="error invalid-feedback" style="display: <?php echo $showTextError ?>"><?php echo $textErrorText ?></span>
              <textarea id="body" name="article_text">
                    <?php echo $textInputValue; ?>
                </textarea>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>

      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a href="javascript:history.back(1)" class="btn btn-secondary">Back</a>
        <input type="submit" value="Edit Article" name="submit" id="submit"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->