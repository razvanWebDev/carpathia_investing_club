<?php 
    if(isset($_GET['u_id'])) {
        $the_user_id = $_GET['u_id'];
    }
    
    $query = "SELECT * FROM users WHERE id = $the_user_id";
    $select_users_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_by_id)) {
        $id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $db_username = $row['username'];
        $db_email = $row['email'];
        $phone = $row['phone'];
        $user_password = $row['user_password'];
        $user_image = $row['user_image'];   
    }

    if(isset($_POST['edit_user'])) {
        
        $firstname = escape($_POST['firstname']);
        $lastname = escape($_POST['lastname']);
        $username = escape($_POST['username']);
        $email = escape($_POST['email']);
        $phone = escape($_POST['phone']);
        $user_password = escape($_POST['user_password']);


        // TOOOOOOO DOOOOOOOO -> find a better way do display the error
        if(($db_username !== $username && userExists($username, $username))){
            echo "<p class='alert alert-danger'>Username already taken</p>";
        }elseif(($db_email !== $email && userExists($email, $email))){
            echo "<p class='alert alert-danger'>Email already taken</p>";
        }else{
            if(ifExists(escape($_FILES['user_image']['name']))){
                $user_image = escape($_FILES['user_image']['name']);
                $user_image_temp = $_FILES['user_image']['tmp_name'];
                move_uploaded_file($user_image_temp, "dist/img/users/$user_image");
            }

            $query = "UPDATE users SET ";
            $query .= "firstname = '{$firstname}', ";
            $query .= "lastname = '{$lastname}', ";
            $query .= "username = '{$username}', ";
            $query .= "email = '{$email}', ";
            $query .= "phone = '{$phone}', ";
            $query .= "user_image = '{$user_image}', ";
            $query .= "user_password = '{$user_password}' ";
            $query .= "WHERE id = {$the_user_id}";

            $update_user = mysqli_query($connection, $query);

            if(!$update_user) {
                die("QUERY FAILED" . mysqli_error($connection));
            }

            header("Location: users.php");
            exit();
        }
    }
?>

<?php $page_title = "Edit user $db_username"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
  <form id="edit-user-form" action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Image</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class='image-container'>
                <img src='dist/img/users/<?php echo $user_image; ?>'>
                <div class='image-actions'>
                  <a class='btn btn-primary'
                    href='users.php?source=edit_user_photo&id=<?php echo $the_user_id ?>'>Chage</a>
                  <a class='btn btn-danger' href='users.php?source=edit_user&u_id=<?php echo $the_user_id; ?>&delete=<?php echo $the_user_id; ?>'
                    onClick="javascript:return confirm('Delete photo?');">Delete</a>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Information</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
            <div class="form-group">
                <label for="firstname">First Name*</label>
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstname ?>">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name*</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastname ?>">
              </div>
              <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" name="username" class="form-control" value="<?php echo $db_username ?>">
              </div>
              <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" name="email" class="form-control" value="<?php echo $db_email ?>">
              </div>
              <div class="form-group">
                <label for="phone">Phone*</label>
                <input type="tel" name="phone" class="form-control" value="<?php echo $phone ?>">
              </div>

              <div class="form-group">
                <label for="user_password">Password</label>
                <input type="password" id="user_password" name="user_password" class="form-control">
              </div>
              <div class="form-group">
                <label for="repeat_user_password">Repeat Password</label>
                <input type="password" name="repeat_user_password" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a onclick="return confirm('Cancel?')" href="users.php" class="btn btn-secondary">Cancel</a>
        <input onclick="return confirm('Edit user?')" type="submit" value="Edit user" name="edit_user"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->