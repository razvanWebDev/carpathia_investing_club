<?php
 include "../../PHP/db.php";
session_start();

if(isset($_SESSION["memberId"]) && !empty($_SESSION["memberId"])){
    $last_activity_time = date("Y-m-d H:i:s");
    $query = "UPDATE members SET last_activity_time ='{$last_activity_time}' WHERE m_unique_id = {$_SESSION["unique_id"]}";
    $setStatusQuery =  mysqli_query($connection, $query);
}
?>