<?php
include 'connect.php';
if(isset($_POST['deletesend']) ){
   $user_info_id=$_POST['deletesend'];
   
   $query="DELETE FROM `user_info` WHERE user_info_id=$user_info_id";
   $result = $mysqli->query($query);
}
?>