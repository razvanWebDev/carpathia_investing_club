<?php include "db.php";?>
<?php include "../admin/includes/functions.php";?>

<?php
if(isset($_POST['submit'])) {
  //check captcha
  $captcha = getCaptcha($secret_key, $_POST['g-recaptcha-response']);

  //Captcha passed
  if($captcha->success == true && $captcha->score > 0.5){
    $email_to = "razvan.crisan@ctotech.io, crsn_razvan@yahoo.com, invest@carpathiainvestingclub.org";
    $email_subject = "Mesaj nou pe site!";
     
    function died($error) {
        // your error code can go here
        echo $error."<br>";
        die();
    };

    //form data 
    $firstname = escape($_POST['firstname']); 
    $lastName = escape($_POST['lastName']);
    $phone = escape($_POST['phone']);
    $email = escape($_POST['email']); 
    $message = escape($_POST['message']);

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $string_exp = "/^[A-Za-z .'-]+$/";
    $phone_exp = '/^[0-9\-\(\)\/\+\s]*$/';

  if(strlen($error_message) > 0) {
    died($error_message);
  }

    //Own Email==========================================  
    $email_message = "Detaliile mesajului.\n\n";
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Nume si prenume: ".clean_string($firstname)." ".clean_string($lastName)."\n";
    $email_message .= "Nr. Telefon: ".clean_string($phone)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Mesaj: ".clean_string($message)."\n\n";
         
    // create email headers
    $headers = 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);  

    //DB contact=======================================================

    $query = "INSERT INTO contact (firstname, lastName, email, phone, message) ";
    $query .= "VALUES ('{$firstname}', '{$lastName}', '{$email}', '{$phone}', '{$message}')";

    $result =  mysqli_query($connection, $query);

    if(!$result) {
    die("DB query failed" . mysqli_error());
    }
    header("Location: ../index.php#contact");

  mysqli_close($connection);
  }else{
    //Captcha failed
    header("Location: ../index.php#contact?error=captcha_failed");
  }
  mysqli_close($connection);  
}

die();
?>