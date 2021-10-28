<?php
session_start();
if(isset($_GET['id'])){
    $_SESSION['incoming_id'] = $_GET['id'];
    echo  $_SESSION['incoming_id'];
}

?>