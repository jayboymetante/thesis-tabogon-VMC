
<?php
require 'core.php ';
require 'connect.php';

if (loggedin()) {

    //echo   'You\'re Log in, ' . $_SESSION['username'] . ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
            <a href="admin-dashboard.php" class="list-group-item list-group-item-action bg-transparent  second-text fw-bold"><i
                class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="personal-info.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                        class="fas fa-users ">
                    </i>Personal Info</a>
                    <a href="vaccine_stock.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                class="fa-sharp fa-solid fa-prescription-bottle me-2"></i>Vaccine Stock</a>
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-paperclip me-2"></i>Reports</a>
                        <a href="#" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
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
                    <h2 class="fs-2 m-0">Vaccine Data List</h2>
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
            <div class="row my-5">
                    <h3 class="fs-4 mb-3">
                        <?php
                                $query = "SELECT * FROM  user_info  WHERE user_info_id='" . $_GET["user_info_id"] . "'";
                                $result = $mysqli->query($query);
                                while ($data = $result->fetch_assoc()) {
                                    echo "$data[first_name]  "."$data[middle_name] "."$data[last_name]";
                                    echo ' <a href="vaccine_data.php?user_info_id='.$data["user_info_id"].'"><button class="btn btn-primary">Add Vaccine Data</button></a>';
                                }
                        ?>
                    </h3>      
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                    <thead>
                        <tr>
                            <th>Number Of Dosage</th>
                            <th>Vaccine Administered</th>
                            <th>Date Administered</th>
                            <th>Vaccinator</th>
                            <th>Brgy</th>
                            <th>Side Effects</th>
                           
                        </tr>
                    </thead>  
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
                            echo "$data[vaccinator]";
                            echo "</td>"; 
                            echo "<td>";
                            echo "$data[brgy]";
                            echo "</td>";
                            echo "<td>";
                            echo "$data[side_effects]";
                            echo "</td>";
                           
                            echo "<td>";
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
        
    </script>
</body>

</html>
<?php } else {
    
   header('Location: admin-login.php');
}
?>
