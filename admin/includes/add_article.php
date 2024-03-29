<?php

$invalidTitleClass = "";
$showTitleError = "none";
$titleErrorMsg = "";
$invalidTextClass = "";
$showTextError = "none";

//check if username exists
if(isset($_GET['error'])){
  if($_GET['error'] == "title"){
   $invalidTitleClass = "is-invalid";
   $showTitleError = "block";
   $titleErrorMsg = "You must provide a title.";
  }
  if($_GET['error'] == "title_taken"){
    $invalidTitleClass = "is-invalid";
    $showTitleError = "block";
    $titleErrorMsg = "This title is already taken! Please choose another.";
   }
  if($_GET['error'] == "text"){
    $invalidTextClass = "is-invalid";
    $showTextError = "block";
  }
}

$titleInputValue = isset($_GET['title']) ? $_GET['title'] : "";
$tickerInputValue = isset($_GET['ticker']) ? $_GET['ticker'] : "";
$subtitleInputValue = isset($_GET['subtitle']) ? $_GET['subtitle'] : "";
$dateInputValue = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
$textInputValue = isset($_GET['article_text']) ? $_GET['article_text'] : "";

if(isset($_POST['add_article'])) {
  $title = $_POST['title'];
  $ticker = $_POST['ticker'];
  $subtitle = $_POST['subtitle'];
  $date = escape($_POST['date']);
  $article_text = $_POST['article_text'];
  $link_to = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $title));
  $status = $_POST['status'];

  $image = $_FILES["image"]["name"];
  
  // Check for errors
  //check if project link exists
  $link_to = stripSpecialChars($title);
  $is_name_taken = isNameTaken ("news", "title", $title);

 if($is_name_taken){
    header("Location: news.php?source=add_article&error=title_taken&title=$title&ticker=$ticker&subtitle=$subtitle&date=$date&article_text=$article_text");
    exit();
  }
  if(empty($title)){
    header("Location: news.php?source=add_article&error=title&title=$title&ticker=$ticker&subtitle=$subtitle&date=$date&article_text=$article_text");
    exit();
  }
  if(empty($article_text)){
    header("Location: news.php?source=add_article&error=text&title=$title&ticker=$ticker&subtitle=$subtitle&date=$date&article_text=$article_text");
    exit();
  }
  else{
    //add new user to db
    uploadImage('image', '../img/news/', 'image');
    createArticle($title, $ticker, $subtitle, $date, $image, $article_text, $link_to, $status);

   header("Location: news.php");
   exit();
  }
}
?>

<?php $page_title = "Add News Article"; ?>
    <?php include "page_title.php"; ?>

  <!-- Main content -->
  <section class="content">
    <form id="user-form" action="" method="post" enctype="multipart/form-data">
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
                <label for="title">Title *</label>
                <input type="text" name="title" class="form-control <?php echo $invalidTitleClass ?>" value="<?php echo $titleInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php echo $showTitleError ?>"><?php echo $titleErrorMsg ?></span>
              </div>

              <div class="form-group">
                <label for="ticker">Ticker</label>
                <input type="text" name="ticker" class="form-control" value="<?php echo $tickerInputValue ?>">
              </div>

              <div class="form-group">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $dateInputValue ?>">
              </div>

              <div class="form-group">
                <label for="customFile">Image</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="image" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>

              <div class="form-group">
                <label for="subtitle">Subtitle</label>
                <textarea name="subtitle" class="form-control">
                    <?php echo $subtitleInputValue ?>
                </textarea>
              </div>

              <div class="form-group">
                <label for="article_text">Article Text *</label>
                <span class="error invalid-feedback" style="display: <?php echo $showTextError ?>">You must provide article text.</span>
                <textarea id="body" name="article_text">
                    <?php echo $textInputValue ?>
                </textarea>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                  <option value="Draft">Draft</option>
                  <option value="Published">Published</option>
                </select>
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
          <input onclick="return confirm('Create article?')" type="submit" value="Create Article" name="add_article" class="btn btn-success float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
