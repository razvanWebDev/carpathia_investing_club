<?php
 include "../../PHP/db.php";
session_start();
$output = "";

if(isset($_SESSION['incoming_id']) && !empty($_SESSION['incoming_id'])){

    $query = "UPDATE messages SET seen='true' WHERE incomming_msg_id = {$_SESSION['unique_id']} AND outgoing_msg_id = {$_SESSION['incoming_id']}";
    $setStatusQuery =  mysqli_query($connection, $query);
}
?>