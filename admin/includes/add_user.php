<?php 
    if(isset($_POST['add_user'])) {
      $firstname = escape($_POST['firstname']);
      $lastname = escape($_POST['lastname']);
      $username = escape($_POST['username']);
      $email = escape($_POST['email']);
      $phone = escape($_POST['phone']);
      $user_password = escape($_POST['user_password']);

      // TOOOOOOO DOOOOOOOO -> find a better way do display the error
      if(userExists($username, $email) !== false){
          echo "<p class='alert alert-danger'>Username or email already taken</p>";
      }else{
        //add new user to db
        uploadImage('user_image', 'dist/img/users/', 'user_image');
        //used default user image if user image is empty
        $user_image = $user_image !== "" ? $user_image : "user.png"; 

        createUser($firstname, $lastname, $username, $email, $phone, $user_image, $user_password);

        header("Location: users.php");
        exit();
      }
    }
?>

<?php $page_title = "Add User"; ?>
    <?php include "page_title.php"; ?>

  <!-- Main content -->
  <section class="content">
    <form id="add-user-form" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="col-md-6">
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
                <label for="firstname">First Name*</label>
                <input type="text" name="firstname" class="form-control">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name*</label>
                <input type="text" name="lastname" class="form-control">
              </div>
              <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" name="username" class="form-control">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Info</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" name="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="phone">Phone*</label>
                <input type="tel" name="phone" class="form-control">
              </div>

              <div class="form-group">
                <label for="customFile">User Image</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="user_image" id="customFile">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
              
              <div class="form-group">
                <label for="user_password">Password*</label>
                <input type="password" id="user_password" name="user_password" class="form-control">
              </div>
              <div class="form-group">
                <label for="repeat_user_password">Repeat Password*</label>
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
          <input onclick="return confirm('Create user?')" type="submit" value="Create new User" name="add_user" class="btn btn-success float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
