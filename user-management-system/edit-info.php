<?php
include 'connect.php';
if(isset($_POST['updateid']) ){
    $user_info_id=$_POST['updateid'];
    
    $query="SELECT* FROM `user_info` WHERE id=$user_info_id";
    $result = $mysqli->query($query);
    $response=array(); 
    while ( $row->mysqli_fetch_assoc($result )) {
        $response=$row; 

    }
    echo json_encode($response);
 }else{
    $response['status']=200;
    $response['message']="Data not Found";
 }
?>