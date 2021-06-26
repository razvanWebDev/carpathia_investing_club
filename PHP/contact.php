<?php include "db.php";?>
<?php include "../admin/includes/functions.php";
header("Location: ../index.php#contact");
?>

<?php
if(isset($_POST['submit'])) {
    $email_to = "razvan.crisan@ctotech.io, crsn_razvan@yahoo.com, flavian.pah@ctotech.io";
    $email_subject = "Mesaj nou pe site!";
     
    function died($error) {
        // your error code can go here
        echo $error."<br>";
        die();
    };

    //form data 
    $name = escape($_POST['name']); 
    $lastName = escape($_POST['lastName']);
    $phone = escape($_POST['phone']);
    $email = escape($_POST['email']); 
    $message = escape($_POST['message']);

    $contact_date = date("Y-m-d");
    $formated_date = date('d.m.Y',strtotime($contact_date));

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

    $email_message .= "Nume si prenume: ".clean_string($name)." ".clean_string($lastName)."\n";
    $email_message .= "Nr. Telefon: ".clean_string($phone)."\n";
    $email_message .= "Email: ".clean_string($email)."\n";
    $email_message .= "Data: ".clean_string($formated_date)."\n";
    $email_message .= "Mesaj: ".clean_string($message)."\n\n";
         
    // create email headers
    $headers = 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);  

    //DB contact=======================================================

    $query = "INSERT INTO contact (name, lastName, email, phone, message, contact_date) ";
    $query .= "VALUES ('{$name}', '{$lastName}', '{$email}', '{$phone}', '{$message}', '{$contact_date}')";

    $result =  mysqli_query($connection, $query);

    if(!$result) {
    die("DB query failed" . mysqli_error());
    }

  mysqli_close($connection);
}

die();
?>