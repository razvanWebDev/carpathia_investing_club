<?php include "../../PHP/db.php" ?>
<?php include "functions.php" ?>
<?php session_start(); ?>

<?php
if(isset($_SESSION['unique_id'])){
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = $_SESSION['incoming_id'];
    $output = "";

    if(!empty($incoming_id)){
        // get incomming message sender detais
        $getMemberQuery = "SELECT * FROM members WHERE m_unique_id = {$incoming_id}";
        $getMemberDetails = mysqli_query($connection, $getMemberQuery);
        while($memberRow = mysqli_fetch_assoc($getMemberDetails)){
            $incoming_member_img = $memberRow['m_image'];
        }

        //get messages
        $query = "SELECT * FROM messages WHERE (outgoing_msg_id = {$outgoing_id} AND incomming_msg_id = {$incoming_id})";
        $query .= " OR (outgoing_msg_id = {$incoming_id} AND incomming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $getMessages = mysqli_query($connection, $query);

        if(mysqli_num_rows($getMessages) > 0){
            while($row = mysqli_fetch_assoc($getMessages)){
                //show message time
                $msgTimestamp = strtotime($row['timestamp']);
               //check if the last msg was today
                $dateDiff = date("Ymd") - date("Ymd", $msgTimestamp);
                $msgTime = $dateDiff == 0 ? date('H:i', $msgTimestamp) : ($dateDiff == 1 ? "Yesterday, ".date('H:i', $msgTimestamp) : date('Y/m/d, H:i', $msgTimestamp));
                $msg = nl2br($row['msg']);

                if((int)$row['outgoing_msg_id'] === $outgoing_id){//send message
                    $output .= '<div class="max-w-3/4 w-max text-sm">
                                    <div class="relative self-start px-4 py-1 text-white rounded-lg shadow bg-primary">
                                        <p>'.$msg.'</p>
                                        <div class="absolute p-1 bg-gray-100 rounded-full -left-6 -top-6">
                                            <div style="background-image: url(../admin/dist/img/members/'.$_SESSION['m_image'].')"
                                                class="w-8 h-8 bg-center bg-cover rounded-full ">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="ml-5 text-xs text-gray-500">'.$msgTime.'</p>
                                </div>';
                }else{//receive message
                    $output .= '<div class="self-end max-w-3/4 w-max text-sm">
                                    <div class="relative px-4 py-1 bg-gray-100 rounded-lg shadow">
                                        <p>'.$msg.'</p>
                                        <div class="absolute p-1 rounded-full bg-gray-50 -right-6 -top-6">
                                            <div style="background-image: url(../admin/dist/img/members/'.$incoming_member_img.')"
                                                class="w-8 h-8 bg-center bg-cover rounded-full ">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mr-5 text-xs text-right text-gray-500">'.$msgTime.'</p>
                                </div>';
                }
                
            }
          
        }else{
            $output = "<p>There are no messages yet!</p>";
        }
    }echo $output;
}else{
    header("Location: ../login");
}
exit();
?>