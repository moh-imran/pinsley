<?php
ob_start();
set_time_limit(0);
//// file uploading functionality


if(!empty($_FILES)){


  $target = "upload/"; 
  //$target = $target . basename( $_FILES['uploaded']['name']) ; 
  $ok=1;

  // if ($_FILES['uploaded']['size'] > 350000) { 
  // echo "Your file is too large.<br>"; $ok=0; 
  // }
 $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//print_r($ext); exit();
  // if ($ext != "xlsx") { 
  // echo "Only excel files allowed<br>"; $ok=0; 
  // } 
  
  $extensions = array("xlsx","xls");

  if(in_array($ext,$extensions)=== false){
         echo "Only excel files allowed<br>"; $ok=0; 
    }

  if ($ok==0) { 
  echo "Sorry your file was not uploaded"; 
  } else { 

              $file_name = "file";
              $file_value = $_FILES['file']['name'];              
              setcookie($file_name, $file_value, time() + (86400 * 30 * 30), "/");

              //$var = move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
              //print_r($var); exit();
              if(move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { 
                       echo "The file ". basename( $_FILES['file']['name']). " has been uploaded"; 
              } else { echo "Sorry, there was a problem uploading your file."; } 
  }


$urll = 'http://'.$_SERVER['HTTP_HOST'].'/phone/upload.php';
header( "refresh:5; url=$urll"); 

} /// end of file uploading
ob_end_flush();
?>