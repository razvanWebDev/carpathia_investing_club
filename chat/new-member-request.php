
<?php
$invalidFirstnameInput = "";
$showFirstnameError = "hidden";
$firstnameErrorMessage = "";

$invalidLastnameInput = "";
$showLastnameError = "hidden";
$lastnameErrorMessage = "";

$invalidEmailInput = "";
$showEmailError = "hidden";
$emailErrorMessage = "";

$phoneInputValue = $ageInputValue = $investing_experienceInputValue = $messageInputValue = "";

$subtitle_p = "Request a new membership";
$subtitle_p_color = "";

$terms_and_conditions_color = "";

// Check for errors
if(isset($_GET['signup'])){
    //failed
  if($_GET['signup'] == "failed"){
    //firstname
    if(isset($_GET['firstnameErr'])){
            $invalidFirstnameInput = "-error";
            $showFirstnameError = "";
        if($_GET['firstnameErr'] == "required"){
            $firstnameErrorMessage = "First name is required";
        }elseif($_GET['firstnameErr'] == "invalid"){
            $firstnameErrorMessage = "Only letters and white space allowed";
        }
    }
    
    //lastname
    if(isset($_GET['lastnameErr'])){
        $invalidLastnameInput = "-error";
        $showLastnameError = "";
        if($_GET['lastnameErr'] == "required"){
            $lastnameErrorMessage = "Last name is required";
        }elseif($_GET['lastnameErr'] == "invalid"){
            $lastnameErrorMessage = "Only letters and white space allowed";
        }
    }

    //email
    if(isset($_GET['emailErr'])){
        $invalidEmailInput = "-error";
        $showEmailError = "";
        if($_GET['emailErr'] == "required"){
            $emailErrorMessage = "Email is required";
        }elseif($_GET['emailErr'] == "invalid"){
            $emailErrorMessage = "Please enter a valid email";
        }elseif($_GET['emailErr'] == "emailExists"){
            $emailErrorMessage = "Email already taken!";
        }
    }

    
    //terms and conditions
    if(isset($_GET['termsErr'])){
        if($_GET['termsErr'] == "required"){
            $terms_and_conditions_color = "text-red-500";
        }
    }
  }
  //success
  if($_GET['signup'] == "success"){
    $subtitle_p = "Request successfully sent!";
    $subtitle_p_color = "text-green-500";
  }
} 
//get input values in case the username or email already exist
$firstNameInputValue = isset($_GET['firstname']) ? $_GET['firstname'] : "";
$lastNameInputValue = isset($_GET['lastname']) ? $_GET['lastname'] : "";
$emailInputValue = isset($_GET['email']) ? $_GET['email'] : "";
$phoneInputValue = isset($_GET['phone']) ? $_GET['phone'] : "";
$ageInputValue = isset($_GET['age']) ? $_GET['age'] : "";
$investing_experienceInputValue = isset($_GET['investing_experience']) ? $_GET['investing_experience'] : "";
$messageInputValue = isset($_GET['message']) ? $_GET['message'] : "";

?>

<?php 
$header_title = "Member request";
include "php/header.php"; 
?>
    <div class="flex items-center justify-center w-screen min-h-screen py-10 bg-blue-100 ">
        <div id="login-card"
            class="px-8 py-4 space-y-4 text-gray-600 bg-white border-t-4 rounded-lg shadow-lg border-primary w-96">
            <h2 class="text-3xl text-center">New Member</h2>
            <hr>
            <p class="text-base text-center <?php echo $subtitle_p_color ?>"><?php echo $subtitle_p ?></p>
            <form action="php/requests.php" method="post"  enctype="multipart/form-data">
                <div class="flex h-10 rounded-md shadow-sm">
                    <input type="text" name="firstname" class="flex-1 block rounded-none input<?php echo $invalidFirstnameInput ?> rounded-l-md sm:text-sm"
                        placeholder="First Name*" value="<?php echo $firstNameInputValue ?>">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/user.svg" alt="first name" class="object-contain w-full h-full">
                    </div>
                </div>
                <span class="text-red-500 ml-2 <?php echo $showFirstnameError ?>" ><?php echo $firstnameErrorMessage ?></span>

                <div class="flex h-10 mt-3 rounded-md shadow-sm">
                    <input type="text" name="lastname" class="flex-1 block rounded-none input<?php echo $invalidLastnameInput ?> rounded-l-md sm:text-sm"
                        placeholder="Last Name*" value="<?php echo $lastNameInputValue ?>">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/user.svg" alt="last name" class="object-contain w-full h-full">
                    </div>
                </div>
                <span class="text-red-500 ml-2 <?php echo $showLastnameError ?>" ><?php echo $lastnameErrorMessage ?></span>

                <div class="flex h-10 mt-3 rounded-md shadow-sm">
                    <input type="email" name="email" class="flex-1 block rounded-none input<?php echo $invalidEmailInput ?> rounded-l-md sm:text-sm"
                        placeholder="Email*" value="<?php echo $emailInputValue ?>">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/email.svg" alt="email" class="object-contain w-full h-full">
                    </div>
                </div>
                <span class="text-red-500 ml-2 <?php echo $showEmailError ?>"><?php echo $emailErrorMessage ?></span>

                <div class="flex h-10 mt-3 rounded-md shadow-sm">
                    <input type="text" name="phone" class="flex-1 block rounded-none input rounded-l-md sm:text-sm"
                        placeholder="Phone" value="<?php echo $phoneInputValue ?>">
                    <div
                        class="inline-flex items-center w-12 h-full p-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50">
                        <img src="img/icons/phone.svg" alt="phone" class="object-contain w-full h-full">
                    </div>
                </div>

                <div class="flex h-10 mt-3 rounded-md shadow-sm">
                    <input type="number" name="age" class="flex-1 block rounded-none input rounded-md sm:text-sm"
                        placeholder="Age" value="<?php echo $ageInputValue ?>">
                </div>
                <div class="mt-3">
                    <label for="investing_experience"><b>Ivesting Experience</b></label>
                    <select value="" name="investing_experience" class="flex h-12 input rounded-md shadow-sm">
                        <option value="Beginner" <?php if($investing_experienceInputValue == "" || $investing_experienceInputValue == "Beginner"){ echo "selected"; }?>>Beginner</option>
                        <option value="Intermediate" <?php if($investing_experienceInputValue == "Intermediate"){ echo "selected"; }?>>Intermediate</option>
                        <option value="Advanced" <?php if($investing_experienceInputValue == "Advanced"){ echo "selected"; }?>>Advanced</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="message"><b>Message</b></label><br>
                    <textarea class="input text-sm p-0" name="message" rows="2"><?php echo $messageInputValue ?></textarea>
                </div>

                <p class="text-sm mt-3 <?php echo $terms_and_conditions_color ?>">
                    <input type="checkbox" name="terms_and_conditions"> 
                    I have read and accept the <b><a href="terms-and-conditions" target="_blank">Terms and Conditions</a></b>
                </p>

                <button type="submit" name="submit"
                    class="w-full h-10 py-2 mt-4 text-white transition rounded-md shadow-sm hover:opacity-75 bg-primary">Request
                    membership</button>
            </form>
            <div class="text-primary">
                <p>
                    <a href="login" class="hover:opacity-75 mb-1">I am already a member</a>
                </p>
                <p class="text-center
                  w-full"><a href="../"><b>GO BACK TO SITE</b></a></p>
            </div>
        </div>
    </div>

<?php include "php/login_footer.php"; ?>