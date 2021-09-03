<!-- DELETE USERS -->
<?php 
 if(isset($_GET['delete'])) {
    if(isset($_SESSION['username'])){
        $the_member_id = mysqli_real_escape_string($connection, $_GET['delete']);
        deleteFileFromRowDiffID("members", "m_id", "m_image", $the_member_id, "dist/img/members/");
        //remove from db
        deleteItemDiffID("members", 'm_id', $the_member_id);
    }
    header("Location: members.php");
    exit();
 }
?>
<?php $page_title = "Members"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">
    <a href="members.php?source=add_member" class="btn bg-primary mb-4">
      <i class="fas fa-plus mr-2"></i>New member
    </a>
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

        $post_query_count = "SELECT * FROM members";
        $select_post_query_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($select_post_query_count);
        $count = ceil($count / $articles_per_page); 

        $query = "SELECT * FROM members LIMIT $page_1, $articles_per_page";
        $select_members = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_members)) {
            $rowCounter_per_page++;
            
            $id = $row['m_id'];
            $firstname = $row['m_firstname'];
            $lastname = $row['m_lastname'];
            $username = $row['m_username'];
            $email = $row['m_email'];
            $phone = $row['m_phone'];
            $m_image = ifExists($row['m_image']) ? $row['m_image'] : "member.png";
        
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
                  <a href="members.php?source=edit_member_photo&id=<?php echo $id ?>" title="Change photo" class="change-photo">
                    <img src="dist/img/members/<?php echo $m_image; ?>" alt="member-avatar" class="img-circle img-fluid">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="members.php?delete=<?php echo $id; ?>" onClick="javascript:return confirm('Delete member <?php echo $username; ?>?')"; class="btn btn-sm bg-danger">
                  <i class="fas fa-trash-alt mr-2"></i>
                   Delete
                </a>
                <a href="members.php?source=edit_member&m_id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
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
                    echo "<li class='page-item active'><a class='page-link' href='members.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='members.php?page={$i}'>$i</a></li>";
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