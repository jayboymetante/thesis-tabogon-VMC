<?php
require 'core.php ';
require 'connect.php';

if (loggedin()) {

    //echo   'You\'re Log in, ' . $_SESSION['username'] . '';
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
        'astrazenca'=> 0,
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://kit.fontawesome.com/c75e69fab4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
            class="fas fa-user-secret me-2"></i>DR. STRANGE</div>
            <div class="list-group list-group-flush my-3">
                <a href="admin-dashboard.php" class="list-group-item list-group-item-action bg-transparent active second-text fw-bold"><i
                class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="personal-info.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                        class="fas fa-users ">
                    </i>Personal Info</a>
                    <a href="workforce-list.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                        class="fa-solid fa-user ">
                    </i>Workforce</a>
                        <a href="vaccine_stock.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                class="fa-sharp fa-solid fa-prescription-bottle me-2"></i>Vaccine Stock</a>
                <a href="reports.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-paperclip me-2"></i>Reports</a>
              
             
               
                <a href="tabogon-map.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-map-marker-alt me-2"></i>Map</a>
                        <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">Log out</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
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
                                    <?php echo $number_of_user; ?> 
                                </h3>
                                    <p class="fs-5">Registered</p>
                            </div>
                            <i class="fa-solid fa-syringe fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                       echo $number_of_vaccinated;
                                    ?>
                                </h3>
                                <p class="fs-5">Vaccinated</p>
                            </div>
                            <i class="fa-sharp fa-solid fa-shield-virus fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                       echo $number_of_unvaccinated;
                                    ?>
                                </h3>
                                <p class="fs-5">Unvaccinated</p>
                            </div>
                            <i class="fa-sharp fa-solid fa-virus-covid fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">
                                <?php
                                      echo $number_of_dosage_administered."/". $stock_quantity;
                                    ?>
                                </h3>
                                <p class="fs-8"> Used and Total Vaccine</p>
                            </div>
                            <i class=" fa-sharp fa-solid fa-prescription-bottle fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                   
                </div>
                <div class="row my-5">
                                <form action="/user-management-system/admin-dashboard.php" method="POST">
                                    <input type="text" name="search_data" value="<?php echo $search_data ?>" class="input" placeholder="search...">
                                    <button type="submit">
                                        Search
                                    </button>
                                    <button >
                                        <a href="/user-management-system/admin-dashboard.php">Clear</a>
                                    </button>
                                    <br>
                                    
                                </form> 
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                        <thead>
                         <tr>
                            <th></th>
                            <th>Vaccine Data</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Contact</th>
                            <th>Number of dosage</th>
                        </thead>
                        <?php
            $query = "SELECT user_info.*,COUNT(vaccine_data.vaccine_data_id) As number_of_dosage FROM user_info LEFT JOIN vaccine_data ON user_info.user_info_id = vaccine_data.user_info_id WHERE  CONCAT(user_info.first_name, ' ', user_info.middle_name, ' ', user_info.last_name   ) LIKE '%$search_data%' group by user_info.user_info_id  ";
            $result = $mysqli->query($query);
            $index=0;
            while ($data = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>";
                    echo ++$index;
                    echo "</td>";
                    echo "<td>";
                    echo ' <a href="vaccine_data_list.php?user_info_id='.$data["user_info_id"].'"><button class="btn btn-primary">Vaccine Data</button>';
                    echo "</td>";
                    echo "<td>";
                        echo "$data[first_name]";
                    echo "</td>";
                    echo "<td>";
                        echo "$data[middle_name]";
                    echo "</td>";
                    echo "<td>";
                        echo "$data[last_name]";
                    echo "</td>";
                    echo "<td>";
                        echo "$data[mobile_number]";
                    echo "</td>";
                  
                    echo "<td>";
                       echo "$data[number_of_dosage]";
                    echo "</td>";
                    echo "<td>";
                    echo "</td>";
                echo "</tr>";
            }
            ?>   
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
        
    </script>
</body>
</html>
<?php } else {
    header('Location: admin-login.php');
}
?>
