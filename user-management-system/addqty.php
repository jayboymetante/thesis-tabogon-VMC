<?php
 
include "connect.php";



$sql1 = "SELECT * FROM vaccine_stocks WHERE vaccine_brand='".$_GET['Name']."'";
$res1 =  $mysqli->query($sql1);
while($row=$res1->fetch_assoc()){
$oldqty = $row['stock_quantity'];

}
$newqty = $oldqty + $_GET['Stock'];
$sql = "UPDATE  vaccine_stocks SET stock_quantity='".$newqty."' WHERE vaccine_brand='".$_GET['Name']."'";
$res =  $mysqli->query($sql);

if($res){
 echo "{\"res\" :\"success\"}";
}
else{
    echo "{\"res\" :\"error\"}";
}


?>