<?php include "PHP/db.php" ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="img/Logo.png">
    <meta charset="UTF-8" lang="EN">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Carpathia Investing Club</title>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $site_key ?>"></script>
</head>

<body>
<div class="preloader">
    <img src="img/Logo_small.png" alt="logo">
</div>