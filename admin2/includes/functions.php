<?php 
$dbClmnName="";
function escape($string) {
  global $connection;
  return mysqli_real_escape_string($connection, trim($string));
}

function ifExists($item){
  global $connection;
  return $item != "" && $item != " " && $item != "  " && $item != "undefined" && $item != null ;
}

function getYTVideoId($videoLink){
  global $connection;

  $ytarray=explode("/", $videoLink);
  $ytendstring=end($ytarray);
  $ytendarray=explode("?v=", $ytendstring);
  $ytendstring=end($ytendarray);
  $ytendarray=explode("&", $ytendstring);
  $ytcode=$ytendarray[0];

  return $ytcode;
}

function resize_image($file, $w, $h, $crop=FALSE) {
  //resize_image(‘/path/to/some/image.jpg’, 200, 200);
  global $connection;

  list($width, $height) = getimagesize($file);
  $r = $width / $height;
  if ($crop) {
      if ($width > $height) {
          $width = ceil($width-($width*abs($r-$w/$h)));
      } else {
          $height = ceil($height-($height*abs($r-$w/$h)));
      }
      $newwidth = $w;
      $newheight = $h;
  } else {
      if ($w/$h > $r) {
          $newwidth = $h*$r;
          $newheight = $h;
      } else {
          $newheight = $w/$r;
          $newwidth = $w;
      }
  }
  $src = imagecreatefromjpeg($file);
  $dst = imagecreatetruecolor($newwidth, $newheight);
  imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

  return $dst;
}

function uploadImage($inputName, $path, $dbClmnName, $inputIndex="no_index"){
  // Call example: uploadImage('image', '../img/', 'post_image');
  //$inputIndex is required for multiple image upload (array)
  global $connection;

  $inputIndexExists = ($inputIndex != "no_index" || $inputIndex === 0);

  $fileName = $inputIndexExists ? $_FILES[$inputName]['name'][$inputIndex] : $_FILES[$inputName]['name'];
  $fileTmpName = $inputIndexExists ? $_FILES[$inputName]['tmp_name'][$inputIndex] : $_FILES[$inputName]['tmp_name'];
  $fileSize = $inputIndexExists ? $_FILES[$inputName]['size'][$inputIndex] : $_FILES[$inputName]['size'];
  $fileError = $inputIndexExists ? $_FILES[$inputName]['error'][$inputIndex] : $_FILES[$inputName]['error'];
  $fileType = $inputIndexExists ? $_FILES[$inputName]['type'][$inputIndex] : $_FILES[$inputName]['type'];
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpeg', 'jpg', 'png');

  if($fileName){
      if(in_array($fileActualExt, $allowed)){
          if($fileError == 0){
              if($fileSize < 5000000){
                  $fileNameNew = uniqid().rand().".".$fileActualExt;
                  $fileDestination = $path.$fileNameNew;
                  move_uploaded_file($fileTmpName, $fileDestination);
                  $GLOBALS[$dbClmnName] = $fileNameNew;
              }else{
                  echo "Your file is too big! ".$fileSize;
              }

          }else{
              echo "There was an error uploading your file";
          }
      }else{
          echo "You cannot upload files of this type";
      }

  }
}


function deleteBulk($tableName){
  // Delete selected rows from the db (mostly useful for rows without files)
  global $connection;
  if(isset($_POST['checkBoxArray'])){
    if(isset($_SESSION['username'])){
        foreach($_POST['checkBoxArray'] as $delete_id){
            $query = "DELETE FROM {$tableName} WHERE id = {$delete_id}";
            $delete_query = mysqli_query($connection, $query);
        }
    }
  }
}

function deleteFile($btnName, $tblName, $clmnName, $idName, $selectedId){
  // Delete a file where you need to provide an id
  global $connection;
  if(isset($_POST[$btnName])){    
    if (array_key_exists($btnName, $_POST)) {
         //delete from db
        $query = "UPDATE {$tblName} SET ";
        $query .= "{$clmnName} = '' ";
        $query .= "WHERE {$idName} = {$selectedId}";
        $update_post = mysqli_query($connection, $query);

        if(!$update_post) {
            die("QUERY FAILED" . mysqli_error($connection));
        }
        //delete actual file
        $filename = $_POST[$btnName];
        if (file_exists($filename)) {
            unlink($filename);
        } else {
            echo 'Could not delete '.$filename.', file does not exist';
        }
    }
  }
}


function deleteItem($tableName, $delete_id){
  //Delete an already selected row frm the db
  global $connection;
  if(isset($_SESSION['username'])){
    $query = "DELETE FROM {$tableName} WHERE id = {$delete_id}";
    $delete_query = mysqli_query($connection, $query);
  }
}

function deleteItemDiffID($tableName, $id, $delete_id){
  //Use this when the id name is different ex: package_id
  //Delete an already selected row from the db
  global $connection;
  if(isset($_SESSION['username'])){
    $query = "DELETE FROM {$tableName} WHERE {$id} = {$delete_id}";
    $delete_query = mysqli_query($connection, $query);
  }
}

function deleteFileFromRow($tblName, $clmnName, $selectedId, $path){
  //When you delete an entire row from the db, CALL THIS TO ALSO REMOVE THE FILE
   // Call example: deleteFileFromRow("news", "post_image", $the_post_id, "../img/");
  global $connection;
  $query = "SELECT * FROM {$tblName} WHERE id = '{$selectedId}'";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
      $fileName = $row[$clmnName]; 
      if(ifExists($fileName)){
        if (file_exists($path.$fileName)) {
             unlink($path.$fileName);
        }

      }    
  }
}

function deleteFileFromRowDiffID($tblName, $id, $clmnName, $selectedId, $path){
  //Use this when the id name is different ex: package_id
  //When you delete an entire row from the db, CALL THIS TO ALSO REMOVE THE FILE
   // Call example: deleteFileFromRow("news", "post_image", $the_post_id, "../img/");
  global $connection;
  $query = "SELECT * FROM {$tblName} WHERE {$id} = {$selectedId}";
  $result = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($result)) {
      $fileName = $row[$clmnName]; 
      if(ifExists($fileName)){
        if (file_exists($path.$fileName)) {
             unlink($path.$fileName);
        }
      }    
  }
}

// delete folder and files in it
function deleteFolder($dir) {
  global $connection;
  if(!empty($dir)){
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? deleteFolder("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
  }else{
    echo "Selected folder does not exist!";
  }
}


?>
