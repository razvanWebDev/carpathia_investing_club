<?php 
    if(isset($_GET['id'])) {
        $member_id = $_GET['id'];
    }

    //get photo 
    $query = "SELECT * FROM members WHERE m_id = '$member_id'";
    $select_by_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_by_id)) {
        $m_image = ifExists($row['m_image']) ? $row['m_image'] : "member.png";
    }

    if(isset($_POST['update'])) {
   
        //Upload new images
        if($_FILES['m_image']['name'] !== ""){
            //delete old image
            if($_FILES['m_image']['name'] !== "member.png"){
                deleteFileFromRowDiffID("members", 'm_id', "m_image", $member_id, "dist/img/members/");
            }
            //upload new image to folder
            uploadImage('m_image', "dist/img/members/", 'm_image');
            //update db
            $query = "UPDATE members SET ";
            $query .= "m_image = '{$m_image}' ";  
            $query .= "WHERE m_id = {$member_id}";

            $update_photo = mysqli_query($connection, $query);

            if(!$update_photo) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
        }

        header("Location: members.php?source=edit_member&m_id={$member_id}");
        exit();
    }
?>

<br><h2>Change User Photo</h2><br>
<form action="" method="post" enctype="multipart/form-data">    

    <img class="edit-photo-img" src="dist/img/members/<?php echo $m_image; ?>">

    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="m_image" id="customFile">
            <label class="custom-file-label" for="customFile">Choose new file</label>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <a href="javascript:history.back(1)" class="btn btn-secondary">Cancel</a>
          <input onclick="return confirm('Update member image?')" type="submit" value="Update image" name="update" class="btn btn-success float-right">
        </div>
      </div>
</form>