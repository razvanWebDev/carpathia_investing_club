<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>
<?php session_start(); ?>

<?php
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = escape($_POST['searchTerm']);
    $output = "";

    $query = "SELECT * FROM members WHERE NOT m_unique_id={$outgoing_id} AND (m_username LIKE '%{$searchTerm}%')";
    $select_members = mysqli_query($connection, $query);

    if(mysqli_num_rows($select_members) > 0){
        include "members_list.php";
    }else{
        $output = "No member related to your search term";
    }
    echo $output;
?>