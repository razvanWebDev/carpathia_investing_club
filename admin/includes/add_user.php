<?php

$invalidUsernameClass = "";
$showUsernameError = "none";
$invalidEmailClass = "";
$showEmailError = "none";

//check if username exists
if(isset($_GET['signup'])){
  if($_GET['signup'] == "username"){
   $invalidUsernameClass = "is-invalid";
   $showUsernameError = "block";
  }
  if($_GET['signup'] == "email"){
    $invalidEmailClass = "is-invalid";
    $showEmailError = "block";
  }
} 
//get input values in case the username or email already exist
$firstNameInputValue = isset($_GET['firstname']) ? $_GET['firstname'] : "";
$lastNameInputValue = isset($_GET['lastname']) ? $_GET['lastname'] : "";
$userNameInputValue = isset($_GET['username']) ? $_GET['username'] : "";
$emailInputValue = isset($_GET['email']) ? $_GET['email'] : "";
$phoneInputValue = isset($_GET['phone']) ? $_GET['phone'] : "";


if(isset($_POST['add_user'])) {
  $firstname = escape($_POST['firstname']);
  $lastname = escape($_POST['lastname']);
  $username = escape($_POST['username']);
  $email = escape($_POST['email']);
  $phone = escape($_POST['phone']);
  $user_password = escape($_POST['user_password']);

  $image_path = $_FILES["user_image"]["name"];
  
  // Check if user already exists
  if(userExists($username, $username)){
    header("Location: users.php?source=add_user&signup=username&firstname=$firstname&lastname=$lastname&username=$username&email=$email&phone=$phone&image_path=$image_path");
    exit();
  }
  if(userExists($email, $email)){
    header("Location: users.php?source=add_user&signup=email&firstname=$firstname&lastname=$lastname&username=$username&email=$email&phone=$phone");
    exit();
  }
  else{
    //add new user to db
    uploadImage('user_image', 'dist/img/users/', 'user_image');
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
    <form id="user-form" action="" method="post" enctype="multipart/form-data">
      <div class="row">
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
                <input type="text" name="firstname" class="form-control" value="<?php echo $firstNameInputValue ?>">
              </div>
              <div class="form-group">
                <label for="lastname">Last Name*</label>
                <input type="text" name="lastname" class="form-control" value="<?php echo $lastNameInputValue ?>">
              </div>
              <div class="form-group">
                <label for="username">Username*</label>
                <input type="text" name="username" class="form-control <?php echo $invalidUsernameClass ?>" value="<?php echo $userNameInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php echo $showUsernameError ?>">Username already taken.</span>
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
                <input type="email" name="email" class="form-control <?php echo $invalidEmailClass ?>" value="<?php echo $emailInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php echo $showEmailError ?>">Email already taken.</span>
              </div>
              <div class="form-group">
                <label for="phone">Phone*</label>
                <input type="tel" name="phone" class="form-control" value="<?php echo $phoneInputValue ?>">
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
          <a href="javascript:history.back(1)" class="btn btn-secondary">Cancel</a>
          <input onclick="return confirm('Create user?')" type="submit" value="Create new User" name="add_user" class="btn btn-success float-right">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
