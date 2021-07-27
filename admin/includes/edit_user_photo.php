<?php 
    if(isset($_GET['id'])) {
        $user_id = $_GET['id'];
    }

    //get photo 
    $query = "SELECT * FROM users WHERE id = '$user_id'";
    $select_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_by_id)) {
        $user_image = $row['user_image'];
    }

    if(isset($_POST['update'])) {
   
        //Upload new images
        if($_FILES['user_image']['name'] !== ""){
            //delete old image
            if($_FILES['user_image']['name'] !== "user.png"){
                deleteFileFromRow('users', 'user_image', $user_id, "dist/img/users/");
            }
            //upload new image to folder
            uploadImage('user_image', "dist/img/users/", 'user_image');
            //update db
            $query = "UPDATE users SET ";
            $query .= "user_image = '{$user_image}' ";  
            $query .= "WHERE id = {$user_id}";

            $update_photo = mysqli_query($connection, $query);

            if(!$update_photo) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
          
        }

        header("Location: users.php?source=edit_user&u_id={$user_id}");
        exit();
    }
?>

<br><h2>Change User Photo</h2><br>
<form action="" method="post" enctype="multipart/form-data">    

    <img class="edit-photo-img" src="dist/img/users/<?php echo $user_image; ?>">

    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="user_image" id="customFile">
            <label class="custom-file-label" for="customFile">Choose new file</label>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <a href="users.php?source=edit_user&u_id=<?php echo $user_id ?>" class="btn btn-secondary">Cancel</a>
          <input onclick="return confirm('Update user image?')" type="submit" value="Update image" name="update" class="btn btn-success float-right">
        </div>
      </div>
</form>