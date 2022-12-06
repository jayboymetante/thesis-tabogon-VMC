<?php
include 'connect.php';
extract($_POST); 
  if(isset($_POST['firstnameSend']) && isset($_POST['lastnameSend'])  && isset($_POST['positionSend'])  
  && isset($_POST['usernameSend'])  && isset($_POST['passSend'])) {
     $query="INSERT INTO workforce (firstname,lastname,position,username,password) VALUES 
     ('$firstnameSend', '$lastnameSend', '$positionSend', '$usernameSend', '$passSend')";
       $result = mysqli_query($mysqli,$query);
  }
  ?>