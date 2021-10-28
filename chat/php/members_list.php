
<?php
    while($row = mysqli_fetch_assoc($select_members)){
        $firstname = $row['m_firstname'];
        $lastname = $row['m_lastname'];
        $username = $row['m_username'];
        $unique_id = $row['m_unique_id'];
        $status = $row['m_status'];
        $status_color = ($status == "active" ? "bg-green-400" : "bg-gray-400");
        $image = !empty($row['m_image']) ? $row['m_image'] : "member.png";

        $currentPanelItem = ($unique_id == $_SESSION['incoming_id'] ? "active-panel-item" : "");

        //Get last message
        $getLastMsgQuery = "SELECT * FROM messages WHERE 
            (incomming_msg_id = {$unique_id} OR outgoing_msg_id = {$unique_id})
             AND (incomming_msg_id = {$outgoing_id} OR outgoing_msg_id = {$outgoing_id})
             ORDER BY msg_id DESC LIMIT 1";

        $getLastMsg  = mysqli_query($connection, $getLastMsgQuery);

        $lastMsg = $lastMsgTime = $you = $fontWeight = "";

        $row2 = mysqli_fetch_assoc($getLastMsg);
        if(mysqli_num_rows($getLastMsg) > 0){
            $lastMsg = $row2['msg'];
            $seenMsg = $row2['seen'];
            $msgTimestamp = strtotime($row2['timestamp']);
            // Set text bold if there are unread messages
            $fontWeight = ($seenMsg == "true" || $outgoing_id == $row2['outgoing_msg_id'] ? "font-normal" : "font-semibold");

            //check if the last msg was today
            $dateDiff = date("Ymd") - date("Ymd", $msgTimestamp);
            $lastMsgTime = $dateDiff == 0 ? date('H:i', $msgTimestamp) : ($dateDiff == 1 ? "Yesterday" : date("Y/m/d", $msgTimestamp));
            $you = $outgoing_id == $row2['outgoing_msg_id'] ? "You: " : "";
        }else{
            $lastMsg = "No messages";
        }

        //Display member
        $output .= '<div data-id="'.$unique_id.'"
                        class="'.$currentPanelItem.' flex h-18 py-2 px-4 mb-2 mr-6 transition rounded cursor-pointer bg-gray-50 panel-item chat-panel-item">
                        <div class="flex-none w-16">
                            <div style="background-image: url(../admin/dist/img/members/'.$image.')"
                                class="relative w-12 h-12 mr-3 bg-center bg-cover rounded-full user-image">
                                <div class="absolute bottom-0 right-0 w-4 h-4 '.$status_color.' rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex flex-col flex-auto h-full truncate justify-evenly">
                            <div class="flex w-full max-w-full overflow-hidden truncate">
                                <p class="'.$fontWeight.' flex-auto mb-1 text-sm truncate">'.$username.'</p>
                                <p class="'.$fontWeight.' flex-none float-right ml-2 text-xs text-gray-500">'.$lastMsgTime.'</p>
                            </div>
                            <div>
                                <p class="w-full text-xs text-gray-500 truncate">
                                    '.$you.$lastMsg.'
                                </p>
                            </div>
                        </div>
                    </div>';
    }
?>