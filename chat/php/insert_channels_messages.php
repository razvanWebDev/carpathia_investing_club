<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>
<?php session_start(); ?>

<?php
    $outgoing_id = $_SESSION['unique_id'];  
    $incoming_id = $_SESSION['incoming_id'];
    $message = escape($_POST['message']);

    if(!empty($message)){
        $query = "INSERT INTO channels_messages (incomming_msg_id, outgoing_msg_id, msg) VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')";
        $insertMsg = mysqli_query($connection, $query);
    }
?>