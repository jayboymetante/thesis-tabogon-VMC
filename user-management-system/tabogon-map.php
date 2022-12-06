<?php
require 'core.php ';
require 'connect.php';






$query = "SELECT brgy,COUNT(brgy) AS total_vaccine_administered, 
SUM( if (vaccine_administered = 'moderna', 1, 0) ) 
AS number_of_moderna_vaccine_administered,
SUM(if(vaccine_administered = 'astrazeneca',1,0) )
AS number_of_astrazeneca_vaccine_administered
FROM vaccine_data GROUP by brgy ";

$result = $mysqli->query($query);
$data = $result->fetch_assoc();
$total_vaccine_administered=$data["total_vaccine_administered"];




?>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPSd3jTUvrNHkCZz7hQf6ppcDUfBNYX9w&callback=initMap"></script>
    <title>Tabogon Map</title>

    <style>
        #map{
            height: 500px;
            width: 100%;
        }
        .window-color{
            color: #20c997;
        }
        table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
    </style>
</head>
<body>
    <h1>Tabogon Map</h1>
    <div id="map"></div>
  
    <table>
  <tr>
    <th>Brgy</th>
    <th>Total Vaccine Administered</th>
  </tr>
  <tr>
<?php
  $query = "SELECT brgy,COUNT(brgy) AS total_vaccine_administered, SUM( if (vaccine_administered = 'moderna', 1, 0) ) AS number_of_moderna_vaccine_administered FROM vaccine_data GROUP by brgy ";
  $result = $mysqli->query($query);
  // $index=0;
  while ($data = $result->fetch_assoc()) {
  echo "<tr>";
      echo "<td>";
          echo "$data[brgy]";
      echo "</td>";
      echo "<td>";
          echo "$data[total_vaccine_administered]";
      echo "</td>";
  echo "</tr>";
}
?>   
  </tr>
</table>
    <script>
     function initMap(){
            //Map Specific place
            var options ={
                zoom:14,
                center:{lat:10.9239,lng: 123.9973}
            }
            //New Map
          var map = new google.maps.Map(document.getElementById('map'),options);
        //For Brgy Alang-alang
        addMarker({coords:{lat:10.9222,lng:124.0210},
       content:'<h2 class="window-color"> <?php  echo $total_vaccine_administered?> Vaccinated </h2>'
        });
        //For Brgy Maslog
        addMarker({coords:{lat:10.9291,lng:124.0238},
        content:'<h2 class="window-color"> Vaccinated</h2>'});
         //For Brgy DaanTabogon
        addMarker({coords:{lat:10.9128,lng:124.0279},
        content:'<h2 class="window-color">10% Vaccinated</h2>'});
        //For Brgy Muabog
        addMarker({coords:{lat:10.8969,lng:124.0391},
        content:'<h2 class="window-color">10% Vaccinated</h2>'});
        //For Brgy Canaocanao
        addMarker({coords:{lat:10.8990,lng:124.0029},
        content:'<h2 class="window-color">10% Vaccinated</h2>'});
         //For Brgy Tabao
         addMarker({coords:{lat:10.8990,lng:124.0224},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
         //For Brgy PIO
         addMarker({coords:{lat:10.9343,lng:124.0210},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
          //For Brgy Tapul
          addMarker({coords:{lat:10.9461,lng:124.0238},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
         //For Brgy Kal-anan
         addMarker({coords:{lat:10.9392,lng:124.0112},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
          //For Brgy Loong
          addMarker({coords:{lat:10.9309,lng:124.0001},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
         // For Brgy Combado
         addMarker({coords:{lat:10.9496,lng:124.0057},
         content:'<h2 class="window-color">10% Vaccinated</h2>'});
          // For Brgy Mabuli
          addMarker({coords:{lat:10.9503,lng:123.9806},
          content:'<h2 class="window-color">10% Vaccinated</h2>'});
          // For Brgy Sambag
          addMarker({coords:{lat:10.9586,lng:124.0015},
          content:'<h2 class="window-color">10% Vaccinated</h2>'});
          // For Brgy Caduawan
          addMarker({coords:{lat:10.9226,lng:123.9694},
          content:'<h2 class="window-color"></h2>'});
          // For Brgy Managase
          addMarker({coords:{lat:10.8997,lng:123.9778},
          content:'<h2 class="window-color">10% Vaccinated</h2>'});
        function addMarker(props){
            var marker = new google.maps.Marker({
            position:props.coords,
            map:map,
           // icon:props.iconImage
          });
          //Check For Costume Icon 
          //Check Content 
          if(props.content){
            var infoWindow = new google.maps.InfoWindow({
           content:props.content
           });
           marker.addListener('click',function(){
            infoWindow.open(map, marker);
          });
          }
        }
     }
    </script>
</body>

</html>
