<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>
<?php session_start(); ?>

<?php
if(isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    loginUser($username, $password);


}
