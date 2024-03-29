<?php 
$header_title = "Chat";
include "php/header.php";
if(!isset($_SESSION["m_username"])){
    header("Location: login.php");
    exit();
}
?>
<div id="main-container" class="flex w-screen h-screen">

    <!-- SIDE PANEL -->
    <div class="flex flex-col flex-none w-screen h-screen space-y-6 bg-blue-100 md:w-2/5 lg:w-1/3 xl:1/4 md:static">

        <!-- side panel chat/group selector -->
        <div class="flex flex-none w-full h-20 bg-blue-200 cursor-pointer">
            <div class="flex justify-center w-2/4 h-full p-4 py-6 bg-blue-100 switch-tab" data-switch="chat">
                <img id="chat-icon" src="img/icons/chat.svg" alt="chat" class="h-full opacity-100 switch-icon">
            </div>
            <div class="flex justify-center w-2/4 h-full p-4 py-6 switch-tab" data-switch="channels">
                <img id="channels-icon" src="img/icons/users.svg" alt="channels" class="h-full opacity-50 switch-icon">
            </div>
        </div>
        <!-- Chats Panel -->
        <div id="chat-side-panel" class="flex flex-col flex-auto pl-4 overflow-y-auto side-panel">
            <!-- chats panel title -->
            <div class="flex-none mr-6 h-36">
                <div class="flex justify-between mb-4">
                    <h2 id="active-panel-title" class="text-3xl">Chat</h2>
                </div>
                <div class="flex h-10 mt-4 rounded-md shadow-sm">
                    <input type="text" id="search-members" placeholder="Search"
                        class="flex-1 block border-r-0 rounded-none input rounded-l-md sm:text-sm"
                        placeholder="Password*">
                    <div id="cancel-search-members-btn"
                        class="flex items-center justify-center w-12 h-full text-2xl text-white transition border border-l-0 border-gray-300 cursor-pointer hover:opacity-75 bg-primary rounded-r-md ">
                        <span>&times;</span>
                    </div>
                </div>
            </div>
            <!-- chats panel items container -->
            <div id="chat-panel-list"
                class="flex-auto pb-12 overflow-y-auto scrollbar-thin scrollbar-track-transparent scrollbar-thumb-blue-300">
            </div>
        </div>
    </div>

    <!-- TEXT WINDOW -->
    <div id="text-window"
        class="fixed flex flex-col w-screen h-screen overflow-y-auto transition-transform duration-300 transform translate-x-full shadow-inner md:static md:translate-x-0 bg-gray-50">
        <!-- top bar -->
        <div class="flex items-center justify-between flex-none w-full h-20 px-6 py-4 border-b md:px-12">
            <div class="flex items-center">
                <img src="img/icons/arrow-left.svg" alt="back" id="show-side-panel-arrow"
                    class="w-6 mr-4 cursor-pointer md:hidden">
                <div id="incoming-image-container" class="flex items-center">
                    
                </div>
                
            </div>
            <div id="user-icon" class="relative">
                <img src="img/icons/user.svg" alt="user"
                    class="w-6 transition opacity-50 cursor-pointer hover:opacity-100">
                <div id="logout-div"
                    class="absolute right-0 z-50 hidden w-40 transition transform translate-y-full bg-white border border-gray-200 rounded shadow-xl -bottom-4">
                   <div class="flex flex-col items-center justify-center pt-4 pb-1">
                       <!-- Get loged-in user image -->
                       <?php
                        if(isset($_SESSION['unique_id'])){
                            $query = "SELECT * FROM members WHERE m_unique_id = {$_SESSION['unique_id']}";
                            $select_member = mysqli_query($connection, $query);
                            if(mysqli_num_rows($select_member) > 0){
                                $row = mysqli_fetch_assoc($select_member);
                                $firstname = $row['m_firstname'];
                                $lastname = $row['m_lastname'];
                                $image = !empty($row['m_image']) ? $row['m_image'] : "member.png";
                        ?>

                        <div style="background-image: url(../admin/dist/img/members/<?php echo $image ?>)"
                            class="relative w-20 h-20 bg-center bg-cover rounded-full">
                        </div>
                        <p class="px-4 text-lg text-center"><?php echo $firstname . " " . $lastname ?></p>
                        <?php } } ?>

                   </div>
                    <div class="flex justify-center py-3 cursor-pointer hover:bg-gray-50">
                        <a href="#">View Pofile</a>
                    </div>
                    <div class="w-3/5 mx-auto border-b border-gray-200"></div>                    
                    <div class="flex justify-center py-3 cursor-pointer hover:bg-gray-50">
                        <a href="../">Back to site</a>
                    </div>
                    <div class="w-3/5 mx-auto border-b border-gray-200"></div>
                    <div class="flex justify-center py-3 cursor-pointer hover:bg-gray-50">
                        <img src="img/icons/logout.svg" alt="logout" class="w-4 mr-2">
                        <a href="php/logout.php"><span class="text-sm">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- chat window -->
        <div id="chat-box-container" style="background-image: linear-gradient(rgba(255, 255, 255, 0.80) 0%,rgba(255, 255, 255, 0.90) 100%),
                                            url(img/chat_bg.jpg);"
            class="flex-auto overflow-y-auto bg-center bg-no-repeat bg-cover shadow-inner scrollbar-thin scrollbar-track-blue-50 scrollbar-thumb-blue-300">
            <div id="chat-box"
                class="flex flex-col justify-end min-h-full gap-8 pt-10 pb-6 pl-8 pr-10 md:pr-16 md:pl-14">
                <!-- chat items -->
            </div>
        </div>

        <!-- bottom bar -->
        <div class="flex flex-none px-8 pt-4 pb-4 border-t md:px-12" id="bottom-bar">
            <form action="" id="send-form" class="flex items-center w-full space-x-6" autocomplete="off">
                <input id="incoming-id-input" type="text" name="incoming_id" value="<?php echo $member_id ?>" hidden>
                <textarea style="overflow:hidden;" id="send-input" name="message" placeholder="Enter message..." class="input scrollbar-thin scrollbar-track-blue-50 scrollbar-thumb-blue-300" rows="1"></textarea>
                <img id="emojis-btn" src="img/icons/emoji.svg" alt="emojis"
                    class="h-6 transition cursor-pointer hover:opacity-75">
                <button id="send-btn"><img id="send-message" src="img/icons/send.svg" alt="send message"
                        class="h-10 transition cursor-pointer active:opacity-75"></button>
            </form>
        </div>
    </div>
</div>

<?php include "php/footer.php"; ?>