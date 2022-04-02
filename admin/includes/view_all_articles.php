<?php
// DELETE PROJECT
 if(isset($_GET['delete'])) {
  if(isset($_SESSION['username'])){
    $delete_id = mysqli_real_escape_string($connection, $_GET['delete']);

    //delete foto
    deleteFileFromRow("news", "image", $delete_id, "../img/news/");
    //remove project
    deleteItem('news', $delete_id);

    header("Location: news.php");
    exit();  
  }else{
    header("Location: index.php");
    exit();
  }
 }

 //set post status
if(isset($_GET["status_select"])){
  $selected_status=$_GET["status_select"];
  $selected_id = $_GET["selected_id"];
  $update_query = "UPDATE news SET status='{$selected_status}' WHERE id=$selected_id";
  $update_query_result = mysqli_query($connection, $update_query);

  if(!$update_query_result) {
      die("STATUS QUERY FAILED" . mysqli_error($connection));
  }else{
    header("Location: news.php");
    exit(); 
  } 
}
?>

<?php $page_title = "News Articles"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">

      <a href="news.php?source=add_article" class="btn bg-primary mb-4">
        <i class="fas fa-plus mr-2"></i>Add an Article
      </a>

      <table class="table table-bordered table-hover text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Status</th>
            <th>Title</th>
            <th>Date</th>
            <th>Image</th>
            <th>Text</th>
            <th>Modifica</th>
            <th>Sterge</th>
          </tr>
        </thead>
        <tbody>
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
          $formated_date = date('d.m.Y',strtotime($date));
          $image = (!empty($row['image']) ? $row['image'] : "");
          $text = (!empty($row['article_text']) ? $row['article_text'] : ""); 
          $status = $row['status'];

          //get short text for expandable table
          // $short_text = strip_tags($description);
          $short_text = $text;
          if (strlen($short_text) > 175) {

            // truncate string
            $stringCut = substr($short_text, 0, 170);
            $endPoint = strrpos($stringCut, ' ');
        
            //if the string doesn't contain any space then it will cut without word basis.
            $short_text = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $short_text .= '...';
          }
      ?>

          <tr>
            <td>
              <?php echo $totalRowCounter ?>
            </td>
            <td>
              <form action="">
                <select name="status_select" onchange="this.form.submit()" class="post-status-select">
                  <option value="Published" <?php echo $status == "Published" ? "selected" : "";?>>Published</option>
                  <option value="Draft" <?php echo $status == "Draft" ? "selected" : "";?>>Draft</option>
                </select>
                <input type="hidden" name="selected_id" value="<?php echo $id ?>">
              </form>
            </td>
            <td>
              <?php echo $title ?>
            </td>
            <td>
              <?php echo $formated_date ?>
            </td>
            <td class="text-center">
              <?php
                if(!empty($image)){
              ?>
                <img class="table-image mb-2" src="../img/news/<?php echo $image ?>" alt="article image">
              <?php } ?>
              <a class='btn btn-sm btn-primary edit-delete-btn'
                href='news.php?source=edit_article_photo&article_id=<?php echo $id ?>'>Change Foto</a>
            </td>
            <td class="text-justify">
              <?php echo $short_text ?>
            </td>
            <td class="text-center">
              <a href="news.php?source=edit_article&id=<?php echo $id ?>"
                class="btn btn-sm btn-primary edit-delete-btn">
                <i class="far fa-edit mr-2"></i>Edit Article
              </a>
            </td>
            <td class="text-center">
              <a href="news.php?delete=<?php echo $id; ?>"
                onClick="javascript:return confirm('Are you shure you want to delete article <?php echo $title; ?>?')"
                ; class="btn btn-sm bg-danger edit-delete-btn">
                <i class="fas fa-trash-alt mr-2"></i>
                Delete Article
              </a>
            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <nav aria-label="Contacts Page Navigation">
      <ul class="pagination justify-content-center m-0">
        <?php
        if($count > 1){
          for($i = 1; $i <= $count; $i++){
            if($i == $page){
                echo "<li class='page-item active'><a class='page-link' href='news.php?page={$i}'>$i</a></li>";
            }else{
                echo "<li class='page-item'><a class='page-link' href='news.php?page={$i}'>$i</a></li>";
            }
          }
        }
        ?>
      </ul>
    </nav>
  </div>
  <!-- /.card-footer -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->