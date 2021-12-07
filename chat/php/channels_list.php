
<?php
    while($row = mysqli_fetch_assoc($select_channels)){
        $unique_id = $row['c_unique_id'];
        $c_name = $row['c_name'];
        $c_short_name = $row['c_short_name'];
        $first_letter = substr($c_short_name, 0, 1);
        $channel_color = $row['bg_color'];


        $currentPanelItem = ($unique_id == $_SESSION['incoming_id'] ? "active-panel-item" : "");

        //Get last message
        $getLastMsgQuery = "SELECT * FROM channels_messages WHERE (incomming_msg_id = {$unique_id}) ORDER BY msg_id DESC LIMIT 1";
        $getLastMsg  = mysqli_query($connection, $getLastMsgQuery);

        $lastMsg = $lastMsgTime = $sender = "";

        $row2 = mysqli_fetch_assoc($getLastMsg);
        if(mysqli_num_rows($getLastMsg) > 0){
            $lastMsg = $row2['msg'];
            $seen_by = $row2['seen_by'];
            //check if seen_by includes current user unique id
            $outgoing_id = "@" . $_SESSION['unique_id'] . "@";

            $fontWeight = "font-semibold";
            //set the message as read if the sender is the current user or seen_by includes current user unique id
            if (($row2['outgoing_msg_id'] == $_SESSION['unique_id']) || (strpos($seen_by, $outgoing_id) !== false)) { 
                $fontWeight = "font-normal";
            }

            $bg_color = "bg-green-200";
            if (($row2['outgoing_msg_id'] == $_SESSION['unique_id']) || (strpos($seen_by, $outgoing_id) !== false)) { 
                $bg_color = "bg-gray-50";
            }

            $msgTimestamp = strtotime($row2['timestamp']);
            //check if the last msg was today
            $dateDiff = date("Ymd") - date("Ymd", $msgTimestamp);
            $lastMsgTime = $dateDiff == 0 ? date('H:i', $msgTimestamp) : ($dateDiff == 1 ? "Yesterday" : date("Y/m/d", $msgTimestamp));
            $sender = (empty($lastMsg) ? "" : "You: ");
            if( $_SESSION['unique_id'] != $row2['outgoing_msg_id']){
                $query = "SELECT m_username FROM members WHERE m_unique_id = {$row2['outgoing_msg_id']}";
                $get_sender_username  = mysqli_query($connection, $query);
                $row3 = mysqli_fetch_assoc($get_sender_username);
                if(mysqli_num_rows($get_sender_username) > 0){
                    $sender = $row3['m_username'] . ": ";
                }

            }
        }else{
            $lastMsg = "No messages";
        }

        //Display member
        $output .= '<div data-id="'.$unique_id.'"
                        class="'.$currentPanelItem.' '.$bg_color.' flex px-4 py-2 mb-2 mr-6 transition rounded cursor-pointer h-18 group-panel-item panel-item bg-gray-50">
                        <div class="flex-none w-16">
                            <div
                                class="'.$channel_color.' flex items-center justify-center flex-none w-12 h-12 mr-3 rounded-full">
                                <span class="inline-block text-2xl align-middle"><b>'.$first_letter.'</b></span>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between flex-auto h-full truncate">
                            <div class="flex w-full max-w-full overflow-hidden truncate">
                                <p class="'.$fontWeight.' flex-auto text-sm truncate">#'.$c_short_name.'
                                </p>
                                <p class="'.$fontWeight.' flex-none float-right ml-2 text-xs text-gray-500">'.$lastMsgTime.'</p>
                            </div>
                            <div>
                            <p class="'.$fontWeight.' w-full text-xs text-gray-500 truncate">
                            '.$sender.$lastMsg.'
                            </p>
                            </div>
                        </div>
                    </div>';
    }
?>