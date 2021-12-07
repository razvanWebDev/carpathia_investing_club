<?php include "../../PHP/db.php" ?>
<?php session_start(); ?>

<?php
    $outgoing_id = $_SESSION['unique_id'];
    $searchTerm = "";
    if(isset($_GET['searchTerm'])){
        $searchTerm = $_GET['searchTerm'];
    }

    //display entire list
    if(empty($searchTerm)){
        $query = "SELECT * FROM channels LEFT JOIN channels_messages 
        ON channels.c_unique_id=channels_messages.incomming_msg_id OR channels.c_unique_id=channels_messages.outgoing_msg_id 
        -- WHERE NOT m_unique_id={$outgoing_id} 
        GROUP BY channels.c_unique_id 
        ORDER BY max(channels_messages.msg_id) DESC";
    //filter for search
    }else{
        $query = "SELECT * FROM channels LEFT JOIN channels_messages 
        ON channels.c_unique_id=channels_messages.incomming_msg_id OR channels.c_unique_id=channels_messages.outgoing_msg_id 
        -- WHERE NOT m_unique_id={$outgoing_id} AND (m_username LIKE '%{$searchTerm}%') 
        WHERE (c_short_name LIKE '%{$searchTerm}%') OR (c_name LIKE '%{$searchTerm}%')
        GROUP BY channels.c_unique_id 
        ORDER BY max(channels_messages.msg_id) DESC";
    }

    $select_channels = mysqli_query($connection, $query);

    $output = "";

    if(mysqli_num_rows($select_channels) == 0){
        $output .= "No channels are available";
    }elseif(mysqli_num_rows($select_channels) > 0){
        include "channels_list.php";
    }
    
    echo $output;
    exit();
?>