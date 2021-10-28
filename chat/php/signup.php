<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>
<?php



if(isset($_POST['signup'])) {
    $firstname = escape($_POST['m_firstname']);
    $lastname = escape($_POST['m_lastname']);
    $username = escape($_POST['m_username']);
    $email = escape($_POST['m_email']);
    $password = escape($_POST['m_password']);
    $repeat_password = escape($_POST['repeat_password']);

    $fileName = $_FILES['m_image']['name'];
    $fileTmpName = $_FILES['m_image']['tmp_name'];
    $fileSize = $_FILES['m_image']['size'];
    $fileType = $_FILES['m_image']['type'];
    $image_path = '../img/members/';

    $firstnameErr = $lastnameErr = $usernameErr = $emailErr = $passwordErr = $repeatPasswordError = "";

    //check firstname field
    if(empty($firstname)){
      $firstnameErr = "&firstnameErr=required";
    }elseif (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
      $firstnameErr = "&firstnameErr=invalid";
    }

    //check lastname field
    if(empty($lastname)){
      $lastnameErr = "&lastnameErr=required";
    }elseif (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) {
      $lastnameErr = "&lastnameErr=invalid";
    }
      
    // Check username field
    if(empty($username)){
      $usernameErr = "&usernameErr=required";
    }elseif(strlen($username) < 4){
      $usernameErr = "&usernameErr=invalid";
    }elseif(userExists($username, $username)){
      $usernameErr = "&usernameErr=userExists";
    }

    // Check email field
    if(empty($email)){
      $emailErr = "&emailErr=required";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $emailErr = "&emailErr=invalid";
    }elseif(userExists($email, $email)){
      $emailErr = "&emailErr=emailExists";
    }

    // check passwords fields
    //Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(empty($password)){
      $passwordErr = "&passwordErr=required";
    }elseif(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8){
      $passwordErr = "&passwordErr=invalid";
    }elseif($password != $repeat_password){
      $passwordErr = "&passwordErr=missmatch";
    }

    if(empty($repeat_password)){
      $repeatPasswordError = "&repeatPasswordErr=required";
    }

    $errorMsg = $firstnameErr . $lastnameErr . $usernameErr . $emailErr . $passwordErr . $repeatPasswordError;

    //Show possible errors
    if(!empty($errorMsg)){
      header("Location: ../new-member-request.php?signup=failed$errorMsg&firstname=$firstname&lastname=$lastname&username=$username&email=$email");
      exit();
    }
    else{
      //add new user to db
      $imageName = uploadFile($fileName, $fileTmpName, $fileSize, $fileType, $image_path);
      createUser($firstname, $lastname, $username, $email, $imageName, $password);
      header("Location: ../new-member-request.php?signup=success");
      exit();
    }
  }
?>