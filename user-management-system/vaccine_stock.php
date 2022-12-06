
<?php
require 'core.php ';
require 'connect.php';

if (loggedin()) {

   // echo   'You\'re Log in, ' . $_SESSION['username'] . ''; 
    
   
    $query = "SELECT COUNT(vaccine_data_id) AS number_of_dosage FROM vaccine_data";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $number_of_dosage_administered=$data["number_of_dosage"];

    $query = "SELECT SUM(stock_quantity) AS stock_quantity FROM vaccine_stocks";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $stock_quantity=$data["stock_quantity"];

    $query = "SELECT SUM(stock_quantity) AS stock_quantity_per_vaccine,vaccine_brand FROM  vaccine_stocks GROUP BY vaccine_brand ORDER BY vaccine_brand";
    $result = $mysqli->query($query);
    $vaccine_stock = [
        'astrazenca',
        'johnson'=> 0,
        'moderna'=> 0,
        'sinovac'=> 0,
        'sputnik'=> 0,
        'pfizer'=> 0,
    ];
    while  ($data = $result->fetch_assoc()){
        $vaccine_stock[$data['vaccine_brand']] = $data['stock_quantity_per_vaccine'];
    }

    $query = "SELECT COUNT(vaccine_data_id) AS number_of_dosage,vaccine_administered FROM vaccine_data GROUP BY vaccine_administered ORDER BY vaccine_administered ";
    $result = $mysqli->query($query);
    $vaccine_administered = [
        'astrazeneca'=> 0,
        'johnson'=> 0,
        'moderna'=> 0,
        'sinovac'=> 0,
        'sputnik'=> 0,
        'pfizer'=> 0,
    ];
    while  ($data = $result->fetch_assoc()){
        $vaccine_administered[$data['vaccine_administered']] = $data['number_of_dosage'];
    }

    $query = "SELECT COUNT(user_info_id) AS number_of_user FROM user_info";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $number_of_user=$data["number_of_user"];

    $query = "SELECT  COUNT(DISTINCT user_info.user_info_id) As number_of_unvaccinated  FROM user_info LEFT JOIN vaccine_data ON user_info.user_info_id = vaccine_data.user_info_id WHERE vaccine_data.vaccine_data_id is  Null";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $number_of_unvaccinated=$data["number_of_unvaccinated"];

    $query = "SELECT  COUNT(DISTINCT user_info.user_info_id) As number_of_vaccinated  FROM user_info LEFT JOIN vaccine_data ON user_info.user_info_id = vaccine_data.user_info_id WHERE vaccine_data.vaccine_data_id is Not Null";
    $result = $mysqli->query($query);
    $data = $result->fetch_assoc();
    $number_of_vaccinated=$data["number_of_vaccinated"];
    
    $search_data="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['search_data']) ){
            $search_data=$_POST['search_data'];
        }
    }
?>
    
    
    
    
    
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/c75e69fab4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Admin Dashboard</title>
    
</head>
<body>
<!-- Modal -->
<div class="modal fade" id="updateModal12" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="updateModal">Additional Stocks</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="inputState">Choose Vaccine to add</label>
                    <select  id="name" class="form-control">
                            <?php
                                $sql = "SELECT * FROM vaccine_stocks";
                                $all_stocks= mysqli_query($mysqli ,$sql);
                                while ($vaccine_stocks = mysqli_fetch_array(
                                     $all_stocks,MYSQLI_ASSOC)):;
                                ?>
                                    <option value="<?php echo $vaccine_stocks["vaccine_brand"];
                                                ?>">
                                            <?php echo $vaccine_stocks["vaccine_brand"];
                                            ?>
                                    </option>
                                <?php
                                endwhile;
                            ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputState">Enter Quantity</label>
                    <input type="number" class="form-control"  id="qty" >
                    
                </div>
            </div>
        </form>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="submit" >Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="hidden" id="hiddendata">
        </div>
        </div>
    </div>
</div>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                class="fas fa-user-secret me-2"></i>DR. STRANGE</div>
                <div class="list-group list-group-flush my-3">
                    <a href="admin-dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="personal-info.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                                class="fas fa-users ">
                            </i>Personal Info</a>
                            <a href="workforce-list.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                            class="fa-solid fa-user ">
                           </i>Workforce</a>
                        <a href="vaccine_stock.php" class="list-group-item list-group-item-action bg-transparent active second-text fw-bold"><i
                        class="fa-sharp fa-solid fa-prescription-bottle me-2"></i>Vaccine Stock</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-paperclip me-2"></i>Reports</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-map-marker-alt me-2"></i>Map</a>
                    <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">Log out</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Vaccine Stock</h2>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                        </li>
                    </ul>
                </div>
            </nav>
         <div class="container-fluid px-4">
                <div class="row g-3 my-2">
               
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                    <?php
                                      echo $vaccine_administered['sputnik']."/".$vaccine_stock['sputnik'];
                                    ?>
                                </h3>
                                <p class="vax-text"> Sputnik</p>
                                
                                <p class="vax-approved">Approved in 74 countries</p>
                                <p class="vax-trial">25 trials in 8 countries</p>
                            </div>
                           
                        </div>
                    </div>
                   
                  
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                       echo $vaccine_administered['astrazeneca']."/". $vaccine_stock['astrazeneca'];
                                    ?>
                                </h3>
                                <p class="vax-text">AstraZeneca</p>
                                <p class="vax-approved">Approved in 149 countries</p>
                                <p class="vax-trial">72 trials in 33 countries</p>

                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                       echo $vaccine_administered['johnson']."/". $vaccine_stock['johnson'];
                                    ?>
                                </h3>
                                <p class="vax-text">Janssen</p>
                                <p class="vax-approved">Approved in 113 countries</p>
                                <p class="vax-trial">26 trials in 25 countries</p>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                        echo $vaccine_administered['moderna']."/". $vaccine_stock['moderna'];
                                    ?>
                                </h3>
                                <p class="vax-text">Moderna</p>
                                <p class="vax-approved">Approved in 88 countries</p>
                                <p class="vax-trial">70 trials in 24 countries</p>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                        echo $vaccine_administered['pfizer']."/". $vaccine_stock['pfizer'];
                                    ?>
                                </h3>
                                <p class="vax-text">Pfizer</p>
                                <p class="vax-approved">Approved in 74 countries</p>
                                <p class="vax-trial">25 trials in 8 countries</p>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                        echo $vaccine_administered['sinovac']."/".$vaccine_stock['sinovac'];
                                    ?>
                                </h3>
                                <p class="vax-text">Sinovac</p>
                                <p class="vax-approved">Approved in 56 countries</p>
                                <p class="vax-trial">42 trials in 10 countries</p>
                            </div>
                           
                        </div>
                    </div>
                   
                </div>
            <div class="container-fluid px-4">
            <div class="row my-5">
                    </h3>      
                    <div class="col">
                    <button type="button" class="btn btn-primary" id="modal1">
                     Additional Stock
                     <i class="fa-sharp fa-solid fa-prescription-bottle me-2"></i>
                    </button> 
                        <table class="table bg-white rounded shadow-sm  table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Vaccine Brand</th>
                            <th>Stock Quantity</th>
                            <th>Date Recieved</th> 
                        </tr>
                    </thead>  
                            <?php
                            $query = "SELECT * FROM  vaccine_stocks";
                            $result = $mysqli->query($query);
                            $index=0;
                            while ($data = $result->fetch_assoc()) {
                                echo "<td>";
                                echo ++$index;
                            echo "</td>";
                            echo "<td>";
                                echo "$data[vaccine_brand]";
                            echo "</td>";
                            echo "<td>";
                                echo "$data[stock_quantity]";
                            echo "</td>";
                            echo "<td>";
                                echo "$data[date_recieved]";
                            echo "</td>";
                            
                        echo "</tr>";           
                            }
                            ?>   
                </table>
                </div>
                </div>  
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        $("#modal1").click(function(){
          $("#updateModal12").modal("show");

        });


        $("#submit").click(function(){
         var name = document.getElementById("name");
         var stock = document.getElementById("qty").value;
         var elementValue = name.options[name.selectedIndex].value;
        //  console.log(elementValue);

        $.ajax({
            url:"addqty.php",
            type:"Get",
            data : {
                Name:elementValue,
                Stock:stock

            }

        }).done(function(data){
        let result = JSON.parse(data);
        if(result.res == "success"){
            swal("Added Successfully", "", "success").then(function(){
            location.reload();
        });
        }
        else{
            alert("ERROR");
        }

        })

        });


        
// var dob = '19800810';
// var year = Number(dob.substr(0, 4));
// var month = Number(dob.substr(4, 2)) - 1;
// var day = Number(dob.substr(6, 2));
// var today = new Date();
// var age = today.getFullYear() - year;
// if (today.getMonth() < month || (today.getMonth() == month && today.getDate() < day)) {
//   age--;
// }
// console.log(age);


        
        
    </script>
</body>

</html>
<?php } else {
    
    header('Location: login.php');
}
?>
