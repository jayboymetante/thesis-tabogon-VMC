<?php 
require 'core.php ';
require 'connect.php';
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/c75e69fab4.js" crossorigin="anonymous"></script>
    <title>Print Vaccine Data</title>
</head>
<style>
    .center {
     display: block;
     margin-left: auto;
     margin-right: auto;
     width: 10%;
}
.health-center{
    text-align: center;
}
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
  color: black;
  margin-left: auto;
  margin-right: auto;
  text-decoration: none
}

table {
  border-collapse: collapse;
  width: 70%;
}

th, td {
  padding: 15px;
}
input[type=text] {
  padding: 5px 15px;
  margin: 8px 0;
  box-sizing: border-box;
  border: none;
  border-bottom: 2px solid ;
  align-items: center;
  display:inline-block
 
}
 @media print{
    body *{
        visibility: hidden;
    }
    .print-container, .print-container * {
        visibility: visible;
    }
  }
</style> 
<body>
   
    <div class="print-container">
        <img src="img/Tabogon.png" alt="Paris" class="center">
        <h3 class="health-center">Tabogon Health Center</h3>
        <br>
        <br>
    
        <center>
        <h3 class="fs-4 mb-3">
            <?php
            $query = "SELECT * FROM  user_info  WHERE user_info_id='" . $_GET["user_info_id"] . "'";
            $result = $mysqli->query($query);
            while ($data = $result->fetch_assoc()) {
                echo "$data[first_name]  "."$data[middle_name] "."$data[last_name]";
                echo ' <a href="vaccine_data.php?user_info_id='.$data["user_info_id"].'"/a>';
            }
            ?>
        </h3>      
        </center>
        <table  class="print-container">
            <tr>
                    <th>Number of dosage</th>
                    <th>Vaccine Administered</th>
                    <th>Date Administered</th>
                    <th>Side Effects</th>
            </tr>
            <?php
                $query = "SELECT * FROM  vaccine_data  WHERE user_info_id='" . $_GET["user_info_id"] . "'";
                $result = $mysqli->query($query);
                $index=0;
                while ($data = $result->fetch_assoc()) {
                echo "<td>";
                    echo ++$index;
                echo "</td>";
                echo "<td>";
                    echo "$data[vaccine_administered]";
                echo "</td>";
                echo "<td>";
                    echo "$data[date_administered]";
                echo "</td>";
                echo "<td>";
                    echo "$data[side_effects]";
                echo "</td>";
                echo "</tr>";           
            }
            ?>   
        </table>
    </div>
    <br>
    <center><button type="button" onclick="window.print();" class="btn btn-warning"><i class="fa-solid fa-print"></i>Print</button></center>
</body>
</html>