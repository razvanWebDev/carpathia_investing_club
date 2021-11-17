<?php

$invalidNameClass = "";
$showNameError = "none";
$nameErrorMessage = "";

$invalidShortNameClass = "";
$showShortNameError = "none";
$shortNameErrorMessage = "";

$errorMsg = $nameErr = $shortNameErr = "";

//check if username exists
if(isset($_GET['err'])){
  if($_GET['err'] == "failed"){
    if(isset($_GET['nameErr'])){
      $invalidNameClass = "error";
      $showNameError = "block";
      if($_GET['nameErr'] == "required"){
          $nameErrorMessage = "Channel name is required";
      }elseif($_GET['nameErr'] == "exists"){
          $nameErrorMessage = "Chanel name already exists";
      }
    }
    if(isset($_GET['shortNameErr'])){
      $invalidShortNameClass = "error";
      $showShortNameError = "block";
      if($_GET['shortNameErr'] == "required"){
          $shortNameErrorMessage = "Channel short name is required";
      }elseif($_GET['shortNameErr'] == "exists"){
          $shortNameErrorMessage = "Chanel short name already exists";
      }
    }
  }

} 

//get input values in case the username or email already exist
$nameInputValue = isset($_GET['name']) ? $_GET['name'] : "";
$shortNameInputValue = isset($_GET['shortName']) ? $_GET['shortName'] : "";
$bgColorInputValue = isset($_GET['bgColor']) ? $_GET['bgColor'] : "";

if(isset($_POST['add_channel'])) {
  $c_name = escape($_POST['c_name']);
  $c_short_name = escape($_POST['c_short_name']);
  $bg_color = escape($_POST['bg_color']);

  
  // Check if user already exists
  if(empty($c_name)){
    $nameErr = "&nameErr=required";
  }elseif(channelExists($c_name, $c_name)){
    $nameErr = "&nameErr=exists";
  }
  if(empty($c_short_name)){
    $shortNameErr = "&shortNameErr=required";
  }elseif(channelExists($c_short_name, $c_short_name)){
    $shortNameErr = "&shortNameErr=exists";
  }

  $errorMsg = $nameErr . $shortNameErr;

  if(!empty($errorMsg)){
    header("Location: channels.php?source=add_channel&err=failed$errorMsg&name=$c_name&shortName=$c_short_name&bgColor=$bg_color");
  }else{
    //add new user to db
    createChannel($c_name, $c_short_name, $bg_color);
    header("Location: channels.php");
    exit();
  }
}
?>

<?php $page_title = "Add Channel"; ?>
    <?php include "page_title.php"; ?>

  <!-- Main content -->
  <section class="content">
    <form id="add-channel-form" action="" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="c_name">Channel Name*</label>
                <input type="text" name="c_name" class="form-control <?php echo $invalidNameClass ?>" value="<?php echo $nameInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php echo $showNameError ?>"><?php echo $nameErrorMessage ?></span>
              </div>
              <div class="form-group">
                <label for="c_short_name">Short Name*</label>
                <input type="text" name="c_short_name" class="form-control <?php echo $invalidNameClass ?>" value="<?php echo $shortNameInputValue ?>">
                <span class="error invalid-feedback" style="display: <?php echo $showShortNameError ?>"><?php echo $shortNameErrorMessage ?></span>
              </div>
              <div class="form-group">
                <label for="bg_color">Color (select or randomize)</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="button" class="btn btn-dark randomize-select">Randomize</button>
                  </div>
                  <select id="channels-colors-select" name="bg_color" class="form-control">
                    <option value="bg-red-400" data-color=<?php echo convertTailwindColors("bg-red-400") ?> <?php echo $bgColorInputValue=="bg-red-400" ? "selected" : "" ?>>Red</option>
                    <!-- <option value="bg-orange-400" data-color="#f6ad55" <?php echo $bgColorInputValue=="bg-orange-400" ? "selected" : "" ?>>Orange</option> -->
                    <option value="bg-yellow-400" data-color=<?php echo convertTailwindColors("bg-yellow-400") ?> <?php echo $bgColorInputValue=="bg-yellow-400" ? "selected" : "" ?>>Yellow</option>
                    <option value="bg-green-400" data-color=<?php echo convertTailwindColors("bg-green-400") ?> <?php echo $bgColorInputValue=="bg-green-400" ? "selected" : "" ?>>Green</option>
                    <!-- <option value="bg-teal-400" data-color="#4fd1c5" <?php echo $bgColorInputValue=="bg-teal-400" ? "selected" : "" ?>>Teal</option> -->
                    <option value="bg-blue-400" data-color=<?php echo convertTailwindColors("bg-blue-400") ?> <?php echo $bgColorInputValue=="bg-blue-400" ? "selected" : "" ?>>Blue</option>
                    <option value="bg-indigo-400" data-color=<?php echo convertTailwindColors("bg-indigo-400") ?> <?php echo $bgColorInputValue=="bg-indigo-400" ? "selected" : "" ?>>Indigo</option>
                    <option value="bg-purple-400" data-color=<?php echo convertTailwindColors("bg-purple-400") ?> <?php echo $bgColorInputValue=="bg-purple-400" ? "selected" : "" ?>>Purple</option>
                    <option value="bg-pink-400" data-color=<?php echo convertTailwindColors("bg-pink-400") ?> <?php echo $bgColorInputValue=="bg-pink-400" ? "selected" : "" ?>>Pink</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="javascript:history.back(1)" class="btn btn-secondary">Cancel</a>
          <input onclick="return confirm('Create channel?')" type="submit" value="Create new channel" name="add_channel" class="float-right btn btn-success">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
