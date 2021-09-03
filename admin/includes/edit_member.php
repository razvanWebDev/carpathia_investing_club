<?php
// DELETE PHOTO
if(isset($_GET['delete'])) {
  if(isset($_SESSION['username'])){
      $delete_id = mysqli_real_escape_string($connection, $_GET['delete']);
      deleteFileFromRowDiffID("members", 'm_id', "m_image", $delete_id, "dist/img/members/");
  }
}

$userNameInputValue = "";
$invalidUsernameClass = "";
$showUsernameError = "none";

$emailInputValue = "";
$invalidEmailClass = "";
$showEmailError = "none";

if(isset($_GET['m_id'])) {
    $the_member_id = $_GET['m_id'];
}

$query = "SELECT * FROM members WHERE m_id = $the_member_id";
$select_users_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_users_by_id)) {
  $id = $row['m_id'];
  $firstname = $row['m_firstname'];
  $lastname = $row['m_lastname'];
  $db_username = $row['m_username'];
  $db_email = $row['m_email'];
  $phone = $row['m_phone'];
  $m_password = $row['m_password'];
  $m_image = $row['m_image'];  
  $displayMemberImage = ifExists($m_image) ? $m_image : "member.png";

  //get values for username and email inputs
  $userNameInputValue = $db_username; 
  $emailInputValue = $db_email;
}

if(isset($_POST['edit_member'])) {
    
  $firstname = escape($_POST['firstname']);
  $lastname = escape($_POST['lastname']);
  $username = escape($_POST['username']);
  $email = escape($_POST['email']);
  $phone = escape($_POST['phone']);
  $m_password = escape($_POST['m_password']);
  $hashed_password = password_hash($m_password, PASSWORD_DEFAULT);

  if(($db_username !== $username && memberExists($username, $username))){
    $invalidUsernameClass = "is-invalid";
    $showUsernameError = "block";
    $userNameInputValue = $username;
  }elseif(($db_email !== $email && memberExists($email, $email))){
    $invalidEmailClass = "is-invalid";
    $showEmailError = "block";
    $emailInputValue = $email;
  }else{
      if(ifExists(escape($_FILES['m_image']['name']))){
          $m_image = escape($_FILES['m_image']['name']);
          $m_image_temp = $_FILES['m_image']['tmp_name'];
          move_uploaded_file($m_image_temp, "dist/img/members/$m_image");
      }

      $query = "UPDATE members SET ";
      $query .= "m_firstname = '{$firstname}', ";
      $query .= "m_lastname = '{$lastname}', ";
      $query .= "m_username = '{$username}', ";
      $query .= "m_email = '{$email}', ";
      $query .= "m_phone = '{$phone}', ";
      $query .= "m_image = '{$m_image}', ";
      $query .= "m_password = '{$hashed_password}' ";
      $query .= "WHERE m_id = {$the_member_id}";

      $update_user = mysqli_query($connection, $query);

      if(!$update_user) {
          die("QUERY FAILED" . mysqli_error($connection));
      }

      header("Location: members.php");
      exit();
    }
}
?>

<?php $page_title = "Edit member $db_username"; ?>
<?php include "page_title.php"; ?>

<!-- Main content -->
<section class="content">
  <form id="add-member-form" action="" method="post" enctype="multipart/form-data">
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
                <img src='dist/img/members/<?php echo $displayMemberImage; ?>'>
                <div class='image-actions'>
                  <a class='btn btn-primary'
                    href='members.php?source=edit_member_photo&id=<?php echo $the_member_id ?>'>Chage</a>
                  <a class='btn btn-danger' href='members.php?source=edit_member&m_id=<?php echo $the_member_id; ?>&delete=<?php echo $the_member_id; ?>'
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
                <input type="text" name="username" class="form-control <?php echo $invalidUsernameClass ?>" value="<?php echo $userNameInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php $showUsernameError ?>">Username already taken.</span>
              </div>
              <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" name="email" class="form-control <?php echo $invalidEmailClass ?>" value="<?php echo $emailInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php $showEmailError ?>">Email already taken.</span>
              </div>
              <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" name="phone" class="form-control" value="<?php echo $phone ?>">
              </div>

              <div class="form-group">
                <label for="m_password">Password</label>
                <input type="password" id="m_password" name="m_password" class="form-control">
              </div>
              <div class="form-group">
                <label for="repeat_m_password">Repeat Password</label>
                <input type="password" name="repeat_m_password" class="form-control">
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
        <input onclick="return confirm('Edit member?')" type="submit" value="Edit member" name="edit_member"
          class="btn btn-success float-right">
      </div>
    </div>
  </form>
</section>
<!-- /.content -->