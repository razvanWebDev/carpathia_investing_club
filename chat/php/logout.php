<?php 
 session_start();
 if(isset($_SESSION['unique_id'])){
    $logout_id = $_SESSION['unique_id'];
    var_dump($logout_id);
    $status = 'inactive';
    $query = "UPDATE members SET m_status='{$status}' WHERE m_unique_id = {$logout_id}";
    $setStatusQuery =  mysqli_query($connection, $query);
    session_unset();
    session_destroy();
    if(isset($_GET['reason'])){
       if($_GET['reason'] == 'timeout'){
         header("Location: ../login.php?reason=timeout");
         exit();
       }
    }
    header("Location: ../login.php");
    exit();
 }else{
    header("Location: ../login.php");
    exit();
 }


?>