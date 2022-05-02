<?php include "db.php";?>
<?php include "../admin/includes/functions.php";
?>

<?php
  $output = "";
  $email = escape($_POST['email']); 

  $query = "SELECT * FROM newsletter WHERE email = '$email'";
  $result = mysqli_query($connection, $query);
  if ($result) {
    if (mysqli_num_rows($result) > 0) {
      $output = '<span class="error">Email already registered!</span>';
    } else {
      $query = "INSERT INTO newsletter (email) VALUES (?);";
      $stmt = mysqli_stmt_init($connection);
    
      if(!mysqli_stmt_prepare($stmt, $query)){
        exit();
      }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt); 

        $output = '<span class="success">Form submited successfuly!</span>';
      }
    }
  } else {
    $output = '<span class="error">There was an error. Please try again or contact the administrator!</span>';
  }
 echo $output;
?>