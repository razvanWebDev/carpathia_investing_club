<?php
 include "../../PHP/db.php";
session_start();

if(isset($_SESSION['incoming_id']) && !empty($_SESSION['incoming_id'])){
    $unique_id = " @" . $_SESSION['unique_id'] . "@";

    $query = "SELECT * FROM messages WHERE incomming_msg_id = {$_SESSION['incoming_id']} AND seen_by LIKE '{$unique_id}'";
    $select_members = mysqli_query($connection, $query);
    if(mysqli_num_rows($select_members) == 0){
        $query = "UPDATE messages SET seen_by=CONCAT(seen_by, '$unique_id') WHERE incomming_msg_id = {$_SESSION['incoming_id']}";
        $setStatusQuery =  mysqli_query($connection, $query);
    }
   
}
?>