<?php include "../../PHP/db.php" ?>
<?php session_start(); ?>

<?php
 $outgoing_id = $_SESSION['unique_id'];

$query = "SELECT * FROM members LEFT JOIN messages 
        ON members.m_unique_id=messages.incomming_msg_id OR members.m_unique_id=messages.outgoing_msg_id 
        WHERE NOT m_unique_id={$outgoing_id} 
        GROUP BY members.m_unique_id 
        ORDER BY max(messages.msg_id) DESC";

$select_members = mysqli_query($connection, $query);

$output = "";

if(mysqli_num_rows($select_members) == 0){
    $output .= "No users are available";
}elseif(mysqli_num_rows($select_members) > 0){
    include "members_list.php";
}

echo $output;
exit();
?>