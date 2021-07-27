<!-- DELETE USERS -->
<?php 
 if(isset($_GET['delete'])) {
    if(isset($_SESSION['username'])){
        $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
        deleteFileFromRow("users", "user_image", $the_user_id, "dist/img/users/");
        //remove from db
        deleteItem("users", $the_user_id);
    }
    header("Location: users.php");
    exit();
 }
?>
<?php $page_title = "Users"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">
      <div class="row">
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

        $post_query_count = "SELECT * FROM users";
        $select_post_query_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($select_post_query_count);
        $count = ceil($count / $articles_per_page); 

        $query = "SELECT * FROM users LIMIT $page_1, $articles_per_page";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $rowCounter_per_page++;
            
            $id = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $username = $row['username'];
            $email = $row['email'];
            $phone = $row['phone'];
            $user_image = ifExists($row['user_image']) ? $row['user_image'] : "user.png";
        
        ?>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card bg-light d-flex flex-fill">
            <div class="card-header border-bottom-0">
            <h2 class="lead"><b><?php echo $username; ?></b></h2>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7 mt-3">
                  
                  <p class="text-muted text-sm"><i class="fas fa-lg fa-user mr-1"></i><?php echo $firstname." ". $lastname ?></p>
                  <p class="text-muted text-sm"><i class="fas fa-lg fa-envelope  mr-1"></i> <?php echo $email ?></p>
                  <p class="text-muted text-sm"><i class="fas fa-lg fa-phone mr-1"></i> <?php echo $phone ?></p>
                </div>
                <div class="col-5 text-center">
                  <img src="dist/img/users/<?php echo $user_image; ?>" alt="user-avatar" class="img-circle img-fluid">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="users.php?delete=<?php echo $id; ?>" onClick="javascript:return confirm('Delete user <?php echo $username; ?>?')"; class="btn btn-sm bg-danger">
                  <i class="fas fa-trash-alt mr-2"></i>
                   Delete
                </a>
                <a href="users.php?source=edit_user&u_id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
                  <i class="fas fa-user-edit mr-2"></i>Edit
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
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
                    echo "<li class='page-item active'><a class='page-link' href='users.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='users.php?page={$i}'>$i</a></li>";
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