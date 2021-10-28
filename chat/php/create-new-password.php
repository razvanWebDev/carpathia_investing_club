<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>

<?php
if(isset($_POST['reset-password-submit'])) {
    $selector = escape($_POST['selector']);
    $validator = escape($_POST['validator']);
    $password = escape($_POST['password']);
    $passwordRepeat = escape($_POST['repeat_password']);

    $currentDate = date("U");

    // VALIDATE FORM
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
    }elseif($password != $passwordRepeat){
      $passwordErr = "&passwordErr=missmatch";
    }

    if(empty($passwordRepeat)){
      $repeatPasswordErr = "&repeatPasswordErr=required";
    }

    $errorMsg = $passwordErr . $repeatPasswordErr;

    //Show possible errors
    if(!empty($errorMsg)){
      header("Location: ../create-new-password.php?reset=failed$errorMsg");
      exit();
    }
    // *********************************

    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($connection);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error1";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)){
            echo "Request expired. You need to resubmit your reset request.";
            exit();
        }else{
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

            if($tokenCheck === false){
                echo "You need to resubmit your reset request";
                exit();
            }elseif($tokenCheck === true) {
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM members WHERE m_email=?";
                $stmt = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "There was an error!";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)){
                        echo "There was an error!";
                        exit();
                    }else{
                        $sql = "UPDATE members SET m_password=? WHERE email=?";

                        $stmt = mysqli_stmt_init($connection);
                        if(!mysqli_stmt_prepare($stmt, $sql)){
                            echo "There was an error!";
                            exit();
                        }else{
                            $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash,  $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            //delete tokens
                            $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?;";
                            $stmt = mysqli_stmt_init($connection);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                echo "There was an error!";
                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../login.php?newpwd=passwordupdated");
                            }
                        }
                    }
                }
            }
        }
    }
}else{
    header("Location: ../login.php");
}
