<?php 
function escape($string) {
  global $connection;
  return mysqli_real_escape_string($connection, trim($string));
}

function ifExists($item){
  global $connection;
  return $item != "" && $item != " " && $item != "  " && $item != "undefined" && $item != null ;
}

function getCaptcha($secret_key, $g_response){
  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$g_response");
  $return = json_decode($response);
  return $return;
}

function userExists($username, $email) {
  global $connection;

  $query = "SELECT * FROM users WHERE username = ? OR email = ?";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: users.php?source=add_user");
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
      return $row;
    }else{
      $result = false;
      return $result;
    }
    mysqli_stmt_close($stmt);
  }
}

function createUser($firstname, $lastname, $username, $email, $phone, $user_image, $user_password) {
  global $connection;

  $query = "INSERT INTO users (firstname, lastname, username, email, phone, user_image, user_password) VALUES (?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: users.php?source=add_user");
    exit();
  }else{
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssss", $firstname, $lastname, $username, $email, $phone, $user_image, $hashed_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function memberExists($username, $email) {
  global $connection;

  $query = "SELECT * FROM members WHERE m_username = ? OR m_email = ?";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: members.php?source=add_member");
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if($row = mysqli_fetch_assoc($resultData)){
      return $row;
    }else{
      $result = false;
      return $result;
    }
    mysqli_stmt_close($stmt);
  }
}

function createMember($firstname, $lastname, $username, $email, $phone, $m_image, $m_password) {
  global $connection;

  $status = 'inactive';
  $unique_id = rand(time(), 10000000);

  $query = "INSERT INTO members (m_unique_id, m_firstname, m_lastname, m_username, m_email, m_status, m_phone, m_image, m_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: members.php?source=add_member");
    exit();
  }else{
    $m_image = (empty($m_image) ? "member.png" : $m_image);
    $hashed_password = password_hash($m_password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssssss", $unique_id, $firstname, $lastname, $username, $email, $status, $phone, $m_image, $hashed_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function addCompanytoPortfolio($date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price, $exit_date) {
  global $connection;

  $query = "INSERT INTO portfolio (date_pitched, company, ticker, purchased, purchase_price, exit_price, exit_date) VALUES (?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: portfolio.php?source=add_company");
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "sssssss", $date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price, $exit_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function editAssets($new_amount, $id) {
  global $connection;

  $query = "UPDATE assets_under_advisement SET ";
            $query .= "amount = ? ";
            $query .= "WHERE id = ?";

  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: assets.php?source=edit_assets");
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "ss", $new_amount, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function editPortfolioCompany($the_company_id, $date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price, $exit_date) {
  global $connection;

  $query = "UPDATE portfolio SET ";
            $query .= "date_pitched = ?, ";
            $query .= "company = ?, ";
            $query .= "ticker = ?, ";
            $query .= "purchased = ?, ";
            $query .= "purchase_price = ?, ";
            $query .= "exit_price = ?, ";
            $query .= "exit_date = ? ";
            $query .= "WHERE id = ?";

  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: portfolio.php?source=edit_company&id=$the_company_id");
    exit();
  }else{
    mysqli_stmt_bind_param($stmt, "ssssssss", $date_pitched, $company, $ticker, $purchased, $purchase_price, $exit_price, $exit_date, $the_company_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function loginUser($username, $password){
  $userExists = userExists($username, $username);

  if($userExists === false) {
    header("Location: ../index.php");
    exit();
  }

  $hashed_password = $userExists["user_password"];
  $check_passwords = password_verify($password, $hashed_password);

  if($check_passwords === false) {
    header("Location: ../index.php");
    exit();
  }else if($check_passwords === true){
    $_SESSION["userId"] = $userExists["id"];
    $_SESSION["username"] = $userExists["username"];
    $_SESSION["user_image"] = $userExists["user_image"];

    header("Location: ../admin.php");
    exit();
  }
}

function getYTVideoId($videoLink){
  global $connection;

  $ytarray=explode("/", $videoLink);
  $ytendstring=end($ytarray);
  $ytendarray=explode("?v=", $ytendstring);
  $ytendstring=end($ytendarray);
  $ytendarray=explode("&", $ytendstring);
  $ytcode=$ytendarray[0];

  return $ytcode;
}

function resize_image($file, $w, $h, $crop=FALSE) {
  //resize_image(‘/path/to/some/image.jpg’, 200, 200);
  global $connection;

  list($width, $height) = getimagesize($file);
  $r = $width / $height;
  if ($crop) {
      if ($width > $height) {
          $width = ceil($width-($width*abs($r-$w/$h)));
      } else {
          $height = ceil($height-($height*abs($r-$w/$h)));
      }
      $newwidth = $w;
      $newheight = $h;
  } else {
      if ($w/$h > $r) {
          $newwidth = $h*$r;
          $newheight = $h;
      } else {
          $newheight = $w/$r;
          $newwidth = $w;
      }
  }
  $src = imagecreatefromjpeg($file);
  $dst = imagecreatetruecolor($newwidth, $newheight);
  imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  return $dst;
}

function uploadImage($inputName, $path, $dbClmnName, $inputIndex="no_index"){
  // Call example: uploadImage('image', '../img/', 'post_image');
  //$inputIndex is required for multiple image upload (array)
  global $connection;

  $inputIndexExists = ($inputIndex != "no_index" || $inputIndex === 0);

  $fileError = $inputIndexExists ? $_FILES[$inputName]['error'][$inputIndex] : $_FILES[$inputName]['error'];

  //check if input is empty
  if($fileError != 0) {
    $GLOBALS[$dbClmnName] = "";
    return;
  } 

  $fileName = $inputIndexExists ? $_FILES[$inputName]['name'][$inputIndex] : $_FILES[$inputName]['name'];
  $fileTmpName = $inputIndexExists ? $_FILES[$inputName]['tmp_name'][$inputIndex] : $_FILES[$inputName]['tmp_name'];
  $fileSize = $inputIndexExists ? $_FILES[$inputName]['size'][$inputIndex] : $_FILES[$inputName]['size'];
  $fileType = $inputIndexExists ? $_FILES[$inputName]['type'][$inputIndex] : $_FILES[$inputName]['type'];
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpeg', 'jpg', 'png');

  if($fileName){
      if(in_array($fileActualExt, $allowed)){
          if($fileError == 0){
              if($fileSize < 5000000){
                  $fileNameNew = uniqid().rand().".".$fileActualExt;
                  $fileDestination = $path.$fileNameNew;
                  move_uploaded_file($fileTmpName, $fileDestination);
                  $GLOBALS[$dbClmnName] = $fileNameNew;
              }else{
                  echo "Your file is too big! ".$fileSize;
              }

          }else{
              echo "There was an error uploading your file";
          }
      }else{
          echo "You cannot upload files of this type";
      }

  }
}


function deleteBulk($tableName){
  // Delete selected rows from the db (mostly useful for rows without files)
  global $connection;
  if(isset($_POST['checkBoxArray'])){
    if(isset($_SESSION['username'])){
        foreach($_POST['checkBoxArray'] as $delete_id){
            $query = "DELETE FROM {$tableName} WHERE id = {$delete_id}";
            $delete_query = mysqli_query($connection, $query);
        }
    }
  }
}

function deleteFile($btnName, $tblName, $clmnName, $idName, $selectedId){
  // Delete a file where you need to provide an id
  global $connection;
  if(isset($_POST[$btnName])){    
    if (array_key_exists($btnName, $_POST)) {
         //delete from db
        $query = "UPDATE {$tblName} SET ";
        $query .= "{$clmnName} = '' ";
        $query .= "WHERE {$idName} = {$selectedId}";
        $update_post = mysqli_query($connection, $query);

        if(!$update_post) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
        //delete actual file
        $filename = $_POST[$btnName];
        if (file_exists($filename)) {
            unlink($filename);
        } else {
            echo 'Could not delete '.$filename.', file does not exist';
        }
    }
  }
}


function deleteItem($tableName, $delete_id){
  //Delete an already selected row frm the db
  global $connection;
  if(isset($_SESSION['username'])){
    $query = "DELETE FROM {$tableName} WHERE id = {$delete_id}";
    $delete_query = mysqli_query($connection, $query);
  }
}

function deleteItemDiffID($tableName, $id, $delete_id){
  //Use this when the id name is different ex: package_id
  //Delete an already selected row from the db
  global $connection;
  if(isset($_SESSION['username'])){
    $query = "DELETE FROM {$tableName} WHERE {$id} = {$delete_id}";
    $delete_query = mysqli_query($connection, $query);
  }
}
function deleteFileFromRow($tblName, $clmnName, $selectedId, $path){
  //When you delete an entire row from the db, CALL THIS TO ALSO REMOVE THE FILE
   // Call example: deleteFileFromRow("news", "post_image", $the_post_id, "../img/");
  global $connection;

  //delete actual file
  $query = "SELECT * FROM {$tblName} WHERE id = '{$selectedId}'";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
      $fileName = $row[$clmnName]; 
      if(ifExists($fileName)){
        if (file_exists($path.$fileName)) {
              unlink($path.$fileName);
        }else {
          echo 'Could not delete '.$filename.', file does not exist';
        }
      }    
  }

  //delete from db
  $query = "UPDATE {$tblName} SET ";
  $query .= "{$clmnName} = '' ";
  $query .= "WHERE id = {$selectedId}";
  $update_post = mysqli_query($connection, $query);

  if(!$update_post) {
      die("QUERY FAILED" . mysqli_error($connection));
  }
}

function deleteFileFromRowDiffID($tblName, $id, $clmnName, $selectedId, $path){
  //Use this when the id name is different ex: package_id
  //When you delete an entire row from the db, CALL THIS TO ALSO REMOVE THE FILE
   // Call example: deleteFileFromRow("news", "post_image", $the_post_id, "../img/");
  global $connection;

  //delete actual file
  $query = "SELECT * FROM {$tblName} WHERE {$id} = {$selectedId}";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
      $fileName = $row[$clmnName]; 
      if(ifExists($fileName)){
        if (file_exists($path.$fileName)) {
              unlink($path.$fileName);
        }
      }    
  }

  //delete from db
  $query = "UPDATE {$tblName} SET ";
  $query .= "{$clmnName} = '' ";
  $query .= "WHERE {$id} = {$selectedId}";
  $update_post = mysqli_query($connection, $query);

  if(!$update_post) {
      die("QUERY FAILED" . mysqli_error($connection));
  }
}

// delete folder and files in it
function deleteFolder($dir) {
  global $connection;
  if(!empty($dir)){
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? deleteFolder("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }else{
    echo "Selected folder does not exist!";
  }
}


?>
