<?php
// FORM VALIDATION
$invalidPasswordInput = "";
$showPasswordError = "hidden";
$password_error_msg = "";

$invalidRepeatPasswordInput = "";
$showRepeatPasswordError = "hidden";
$repeat_password_error_msg = "";

if(isset($_GET['reset'])){
    if($_GET['reset'] == 'failed'){
        if(isset($_GET['passwordErr'])){
            $invalidPasswordInput = "-error";
            $showPasswordError = "";
            if($_GET['passwordErr'] == "required"){
                $password_error_msg = "Password is required";
            }elseif($_GET['passwordErr'] == "invalid"){
                $password_error_msg = "Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character";
            }elseif($_GET['passwordErr'] == "missmatch"){
                $password_error_msg = "Passwords don't match";
                $invalidRepeatPasswordInput = "-error";
                $showRepeatPasswordError = "";
                $repeat_password_error_msg = "Passwords didn't match";
            }
        }
        if(isset($_GET['repeatPasswordErr'])){
            if($_GET['repeatPasswordErr'] == "required"){
                $invalidRepeatPasswordInput = "-error";
                $showRepeatPasswordError = "";
                $repeat_password_error_msg = "Required field";
            }
        }
    }

}
?>
<?php 
$header_title = "Recover Password";
include "php/header.php"; 
?>
    <div class="flex items-center justify-center w-screen min-h-screen bg-blue-100 ">
        <div id="login-card"
            class="px-8 py-4 space-y-4 text-gray-600 bg-white border-t-4 rounded-lg shadow-lg border-primary w-96">
            <h2 class="text-3xl text-center">New Password</h2>
            <hr>
        <?php
            $selector = isset($_GET['selector']) ? $_GET['selector'] : "";
            $validator = isset($_GET['validator']) ? $_GET['validator'] : "";

            if(empty($selector) || empty($validator)){
                echo "<p class='text-red-500'>Could not validate your request!</p>";
            }elseif(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
        ?>
            <p class="text-base text-center">You are only one step a way from your new password. Type your new password</p>
            <form action="php/create-new-password.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <div class="flex h-10 rounded-md shadow-sm">
                    <input type="password" name="password"
                        class="flex-1 block rounded-none input<?php echo $invalidPasswordInput ?> rounded-l-md sm:text-sm" placeholder="New Password*">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/lock.svg" alt="password" class="object-contain w-full h-full">
                    </div>
                </div>
                <span class="text-red-500 ml-2 <?php echo $showPasswordError ?>" ><?php echo $password_error_msg ?></span>

                <div class="flex h-10 mt-4 rounded-md shadow-sm">
                    <input type="password" name="repeat_password*"
                        class="flex-1 block rounded-none input<?php echo $invalidRepeatPasswordInput ?> rounded-l-md sm:text-sm" placeholder="Repeat Password">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/lock.svg" alt="repeat passord" class="object-contain w-full h-full">
                    </div>
                </div>
                <span class="text-red-500 ml-2 <?php echo $showRepeatPasswordError ?>" ><?php echo $repeat_password_error_msg ?></span>

                <button type="submit" name="reset-password-submit"
                    class="w-full h-10 py-2 mt-4 text-white transition rounded-md hover:opacity-75 bg-primary">Change
                    Password</button>
            </form>
        <?php } ?>
            <div class="text-primary">
                <p class="mb-1">
                    <a href="login" class="hover:opacity-75">Login</a>
                </p>
            </div>
        </div>
    </div>

<?php include "php/login_footer.php"; ?>