<?php include "../../PHP/db.php";?>
<?php include "functions.php";
?>

<?php
if(isset($_POST['submit'])) {
    $email_to = "razvan.crisan@ctotech.io, crsn_razvan@yahoo.com, invest@carpathiainvestingclub.org";
    $email_subject = "Carpathia member request";

    //form data 
    $firstname = escape($_POST['firstname']); 
    $lastname = escape($_POST['lastname']);
    $email = escape($_POST['email']);
    $phone = escape($_POST['phone']);
    $age = escape($_POST['age']);
    $investing_experience = escape($_POST['investing_experience']);
    $message = escape($_POST['message']);

    $errorMsg = $firstnameErr = $lastnameErr = $emailErr = "";

    $userExists = userExists($email, $email);

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

    // Check email field
    if(empty($email)){
      $emailErr = "&emailErr=required";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $emailErr = "&emailErr=invalid";
    }elseif(userExists($email, $email)){
      $emailErr = "&emailErr=emailExists";
    }
  
    $errorMsg = $firstnameErr . $lastnameErr . $emailErr;
  
    if(!empty($errorMsg)){
      header("Location: ../new-member-request.php?signup=failed$errorMsg&firstname=$firstname&lastname=$lastname&email=$email&phone=$phone&age=$age&investing_experience=$investing_experience&message=$message");
      exit();
    }else{

      //Own Email==========================================  
      $email_message = "Detaliile mesajului:<br><br>";
      
      function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
      }

      $email_message .= "<b>Nume si prenume: </b>".clean_string($firstname)." ".clean_string($lastname)."<br>";
      $email_message .= "<b>Email: </b>".clean_string($email)."<br>";
      $email_message .= "<b>Nr. Telefon: </b>".clean_string($phone)."<br>";
      $email_message .= "<b>Varsta: </b>".clean_string($age)."<br>";
      $email_message .= "<b>Experienta : </b>".clean_string($investing_experience)."<br>";
      $email_message .= "<b>Mesaj: </b>".clean_string($message)."<br>";
          
      // create email headers
      $headers = "From: $email\r\n";
      $headers .= "Reply-To: $email\r\n";
      $headers .= "Content-type: text/html\r\n";

      mail($email_to, $email_subject, $email_message, $headers);  

      //DB =======================================================

      $query = "INSERT INTO member_requests (firstname, lastname, email, phone, age, investing_experience, message) ";
      $query .= "VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$phone}', '{$age}', '{$investing_experience}', '{$message}')";

      $result =  mysqli_query($connection, $query);

      if(!$result) {
      die("DB query failed" . mysqli_error());
      }

      header("Location: ../new-member-request.php?signup=success");


    mysqli_close($connection);
  }
}

die();
?>