<!-- DELETE COMPANY -->
<?php 
 if(isset($_GET['delete'])) {
    if(isset($_SESSION['username'])){
        $delete_id = mysqli_real_escape_string($connection, $_GET['delete']);
        deleteItem("channels", $delete_id);
    }
    header("Location: channels.php");
    exit();
 }
?>

<?php $page_title = "Channels"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">

    <a href="channels.php?source=add_channel" class="btn bg-primary mb-4">
      <i class="fas fa-plus mr-2"></i>Add Channel
    </a>

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Channel Name</th>
            <th>Channel Short Name</th>
            <th>Channel Color</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
        //pagination
        $rowCounter_per_page = 0;
        //the number of posts per page
        $articles_per_page = 30;
    
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

        $post_query_count = "SELECT * FROM channels";
        $select_post_query_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($select_post_query_count);
        $count = ceil($count / $articles_per_page); 

        $query = "SELECT * FROM channels ORDER BY id DESC LIMIT $page_1, $articles_per_page";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $rowCounter_per_page++;
            $totalRowCounter = $rowCounter_per_page + (($page-1) * $articles_per_page);
            
            $id = $row['id'];
            $c_unique_id = $row['c_unique_id'];
            $c_name = $row['c_name'];
            $c_short_name = $row['c_short_name'];
            $bg_color = $row['bg_color'];
        ?>
          <tr>
            <td>
              <?php echo $totalRowCounter ?>
            </td>
            <td>
              <?php echo $c_name ?>
            </td>
            <td>
              <?php echo $c_short_name ?>
            </td>
            <td style="background-color: <?php echo convertTailwindColors($bg_color) ?>">
              
            </td>
            <td class="text-center">
              <a href="channels.php?source=edit_channel&id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
                <i class="far fa-edit mr-2"></i>Edit
              </a>
            </td>
            <td class="text-center">
              <a href="channels.php?delete=<?php echo $id; ?>" onClick="javascript:return confirm('Delete channel <?php echo $c_name; ?>?')"; class="btn btn-sm bg-danger">
                <i class="fas fa-trash-alt mr-2"></i>
                  Delete
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
      <nav>
        <ul class="pagination justify-content-center m-0">
          <?php
        if($count > 1){
            for($i = 1; $i <= $count; $i++){
                if($i == $page){
                    echo "<li class='page-item active'><a class='page-link' href='channels.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='channels.php?page={$i}'>$i</a></li>";
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
