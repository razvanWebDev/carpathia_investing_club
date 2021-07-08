<?php include "db.php";?>
<?php include "../admin/includes/functions.php";
header("Location: ../member-request-sent.php");
?>

<?php
if(isset($_POST['submit'])) {
    $email_to = "razvan.crisan@ctotech.io, crsn_razvan@yahoo.com, invest@carpathiainvestingclub.org";
    $email_subject = "Carpathia member request";
     
    function died($error) {
        // your error code can go here
        echo $error."<br>";
        die();
    };

    //form data 
    $firstname = escape($_POST['firstname']); 
    $lastname = escape($_POST['lastname']);
    $email = escape($_POST['email']);
    $phone = escape($_POST['phone']);
    $age = escape($_POST['age']);
    $investing_experience = escape($_POST['investing_experience']);
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

    $email_message .= "Nume si prenume: ".clean_string($firstname)." ".clean_string($lastname)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Nr. Telefon: ".clean_string($phone)."\n";
    $email_message .= "Varsta: ".clean_string($age)."\n";
    $email_message .= "Experienta : ".clean_string($investing_experience)."\n";
    $email_message .= "Mesaj: ".clean_string($message)."\n\n";
         
    // create email headers
    $headers = 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);  

    //DB =======================================================

    $query = "INSERT INTO members (firstname, lastname, email, phone, age, investing_experience, message) ";
    $query .= "VALUES ('{$firstname}', '{$lastname}', '{$email}', '{$phone}', '{$age}', '{$investing_experience}', '{$message}')";

    $result =  mysqli_query($connection, $query);

    if(!$result) {
    die("DB query failed" . mysqli_error());
    }

  mysqli_close($connection);
}

die();
?>