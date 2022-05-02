<!-- DELETE SUBSCRIBERS -->
<?php 
 if(isset($_GET['delete'])) {
    if(isset($_SESSION['username'])){
        $the_item_id = mysqli_real_escape_string($connection, $_GET['delete']);
        $query = "DELETE FROM newsletter WHERE id = {$the_item_id}";
        $delete_query = mysqli_query($connection, $query);
    }
    Header("Location: newsletter");
 }

 //delete in bulk
 if(isset($_POST['checkBoxArray'])){
    if(isset($_SESSION['username'])){
        foreach($_POST['checkBoxArray'] as $valueId){
        $query = "DELETE FROM newsletter WHERE id = {$valueId}";
        $delete_query = mysqli_query($connection, $query);
        }
    }
    Header("Location: newsletter");
}
?>
<?php $page_title = "Newsletter Subscribers"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">
      <form id="exportForm" action="includes/export_newsletter.php" method="post" enctype="multipart/form-data">
      </form>

      <button form="exportForm" type="submit" id="dataExport" name="dataExport" value="Export to excel"
        class="btn btn-primary">Export To Excel</button>
      <input form="deleteForm" type="submit" name="submit" class="btn btn-danger float-right" name="deleteSelected"
        value="Delete Selected" onclick="return confirm('Delete selected subscriptions?')">
      <br><br>

      <form id="deleteForm" action="" method="post">
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>
              <th><input type="checkbox" id="selectAllBoxes"></th>
              <th>Nr</th>
              <th>Email</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php 
      
                  //pagination
                  $rowCounter_per_page = 0;
                  //the number of news per page
                  $items_per_page = 25;
              
                  if(isset($_GET['page'])){
                      $page = $_GET['page'];
                  }else{
                      $page = 1;
                  }
      
                  if($page == "" || $page == 1){
                      $page_1 = 0;
                  }else{
                      $page_1 = ($page * $items_per_page) - $items_per_page;
                  }
      
                  $post_query_count = "SELECT * FROM newsletter ORDER BY id DESC";
                  $select_post_query_count = mysqli_query($connection, $post_query_count);
                  $count = mysqli_num_rows($select_post_query_count);
                  $count = ceil($count / $items_per_page); 
                  
                  $query = "SELECT * FROM newsletter ORDER BY id DESC LIMIT $page_1, $items_per_page";
                  $select_items = mysqli_query($connection, $query);
      
                  while ($row = mysqli_fetch_assoc($select_items)) {
                      $rowCounter_per_page++;
                      $totalRowCounter = $rowCounter_per_page + (($page-1) * $items_per_page);
                      $id = $row['id'];
                      $email = $row['email'];
                      
                      echo "<tr>";
                      ?>
            <td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='<?php echo $id; ?>'></td>
            <?php
                      echo "<td>{$totalRowCounter}</td>";
                      echo "<td>{$email}</td>";     
                      echo "<td><a href='newsletter.php?source=edit_subscriber&id={$id}' class='btn btn-sm btn-primary'> <i class='far fa-edit mr-2'></i> Edit</a></td>";
                      echo "<td><a href='newsletter.php?delete={$id}' onClick=\"javascript:return confirm('Delete {$email} subscription?');\" class='btn btn-sm bg-danger'><i class='fas fa-trash-alt mr-2'></i>Delete</a></td>";
                      echo "</tr>";
                  } 
                  ?>
          </tbody>
        </table>
      </form>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <nav aria-label="Subscribers Page Navigation">
        <ul class="pagination justify-content-center m-0">
          <?php
        if($count > 1){
            for($i = 1; $i <= $count; $i++){
                if($i == $page){
                    echo "<li class='page-item active'><a class='page-link' href='newsletter.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='newsletter.php?page={$i}'>$i</a></li>";
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