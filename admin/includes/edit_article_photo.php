<?php 
    if(isset($_GET['article_id'])) {
        $article_id = $_GET['article_id'];
    }

    // DELETE PHOTO
    if(isset($_GET['delete'])) {
        if(isset($_SESSION['username'])){
            $delete_id = mysqli_real_escape_string($connection, $_GET['delete']);
            deleteFileFromRow('news', 'image', $delete_id, "../img/news/");
            
        header("Location: news.php?source=edit_article_photo&article_id=$article_id");
        exit();
        }
  }
  

    //get photo 
    $query = "SELECT * FROM news WHERE id = '$article_id'";
    $select_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_by_id)) {
        $image = ifExists($row['image']) ? $row['image'] : "news_placeholder.jpg";
    }

    if(isset($_POST['update'])) {
   
        //Upload new images
        if($_FILES['image']['name'] !== ""){
            //delete old image
            if($_FILES['image']['name'] !== ""){
                deleteFileFromRow('news', 'image', $article_id, "../img/news/");
            }
            //upload new image to folder
            uploadImage('image', "../img/news/", 'image');
            //update db
            $query = "UPDATE news SET ";
            $query .= "image = '{$image}' ";  
            $query .= "WHERE id = {$article_id}";

            $update_photo = mysqli_query($connection, $query);

            if(!$update_photo) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
        }

        header("Location: news.php");
        exit();
    }
?>

<br><h2>Change Article Photo</h2><br>
<form action="" method="post" enctype="multipart/form-data">    

    <img class="edit-photo-img" src="../img/news/<?php echo $image; ?>">

    <a class='btn btn-danger mb-4' href='news.php?source=edit_article_photo&article_id=<?php echo $article_id; ?>&delete=<?php echo $article_id; ?>'
                    onClick="javascript:return confirm('Delete photo?');">Delete photo</a>

    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="image" id="customFile">
            <label class="custom-file-label" for="customFile">Choose new file</label>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <a href="news.php" class="btn btn-secondary">Cancel</a>
          <input onclick="return confirm('Update article image?')" type="submit" value="Update image" name="update" class="btn btn-success float-right">
        </div>
      </div>
</form>