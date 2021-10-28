<?php

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function ifExists($item){
  global $connection;
  return $item != "" && $item != " " && $item != "  " && $item != "undefined" && $item != null ;
}

function userExists($username, $email) {
  global $connection;

  $query = "SELECT * FROM members WHERE m_username = ? OR m_email = ?";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: ../login.php");
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

function createUser($firstname, $lastname, $username, $email,  $image, $password) {
  global $connection;
  $status = 'inactive';
  $unique_id = rand(time(), 10000000);

  $query = "INSERT INTO members (m_unique_id, m_firstname, m_lastname, m_username, m_email, m_status, m_image, m_password) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($connection);

  if(!mysqli_stmt_prepare($stmt, $query)){
    header("Location: new-member-request.php?signup=unkmown_error");
    exit();
  }else{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssss", $unique_id, $firstname, $lastname, $username, $email, $status,  $image, $hashed_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);  
  }
}

function loginUser($username, $password){
  global $connection;
  $userExists = userExists($username, $username);

  $hashed_password = $userExists["m_password"];
  $check_passwords = password_verify($password, $hashed_password);

  $errorMsg = $userErr = $pwdErr = "";

  if(empty($username)){
    $userErr = "&user=required";
  }elseif($userExists === false) {
    $userErr = "&user=userExists";
  }

  if(empty($password)){
    $pwdErr = "&pwd=required";
  }elseif(!empty($username) && $check_passwords === false) {
   $pwdErr = "&pwd=wrong";
  }

  $errorMsg = $userErr . $pwdErr;

  if(!empty($errorMsg)){
    header("Location: ../login.php?login=failed$errorMsg");
    exit();
  }elseif($check_passwords === true){
    $status = 'active';
    $query = "UPDATE members SET m_status='{$status}' WHERE m_unique_id = {$userExists["m_unique_id"]}";
    $setStatusQuery =  mysqli_query($connection, $query);
    $_SESSION["memberId"] = $userExists["m_id"];
    $_SESSION["unique_id"] = $userExists["m_unique_id"];
    $_SESSION["m_username"] = $userExists["m_username"];
    $_SESSION["m_image"] = $userExists["m_image"];
    $_SESSION["m_status"] = $userExists["m_status"];

    $_SESSION['incoming_id'] = "";

    header("Location: ../index.php");
    exit();
  }
}

function uploadFile($fileName, $fileTmpName, $fileSize, $fileType, $path){

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpeg', 'jpg', 'png');

  if($fileName){
    if(in_array($fileActualExt, $allowed)){
      if($fileSize < 5000000){
        $fileNameNew = uniqid().rand().".".$fileActualExt;
        $fileDestination = $path.$fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        return $fileNameNew;
      }else{
        echo "Your file is too big! ".$fileSize;
      }
    }else{
      echo "You cannot upload files of this type";
    }
  }
  //return name if no image is selected
  return "member.png";
}

?>