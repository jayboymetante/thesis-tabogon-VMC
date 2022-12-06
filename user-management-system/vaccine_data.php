<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if(isset($_POST['user_info_id']) 
      && isset($_POST['vaccine_administered'])
      && isset($_POST['date_administered'])
      && isset($_POST['side_effects'])){

        //$sql = "Update vaccine_stocks SET stock_quantity = SET stock_quantity- $stock_quantity WHERE vaccine_id = $vaccine_id";
       $sql2="SELECT vaccine_data.*,vaccine_stocks.* FROM vaccine_data INNER JOIN vaccine_stocks ON vaccine_data.vaccine_administered=vaccine_stocks.vaccine_brand  WHERE user_info_id ='".$_POST['user_info_id']."' AND vaccine_administered ='".$_POST['vaccine_administered']."'  ";
       $res2 = $mysqli->query($sql2);
       $data = $res2->fetch_assoc();
       $stock = $data['stock_quantity'];
       if($res2){
            $newstock= $stock-1;
        $sql1="UPDATE vaccine_stocks SET stock_quantity='".$newstock."' WHERE vaccine_brand = '".$_POST['vaccine_administered']."'";
        $res1 = $mysqli->query($sql1);

       }
       
       
       $sql = "INSERT INTO vaccine_data (user_info_id,vaccine_administered,date_administered,vaccinator,brgy,side_effects) 
        VALUES('".$mysqli->real_escape_string($_POST['user_info_id'])."', '"
                 .$mysqli->real_escape_string($_POST['vaccine_administered'])."','"
                 .$mysqli->real_escape_string($_POST['date_administered'])."','"
                 .$mysqli->real_escape_string($_POST['vaccinator'])."','"
                 .$mysqli->real_escape_string($_POST['brgy'])."','"
                 .$mysqli->real_escape_string($_POST['side_effects'])."')";
                 

        if ($mysqli->query($sql) === TRUE) {
        echo "New record created successfully";
        header("Location: vaccine_data_list.php?user_info_id=".$_POST['user_info_id']."");
        } 
        else{
         die("failed: " . $mysqli->error);
        }
        
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
    <link rel="stylesheet" href="index_style.css" />
    <title>Admin Dashboard</title>
</head>
<style>
   
</style>
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
                    <h2 class="fs-2 m-0">Vaccine Data</h2>
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
                <form action"vaccine_data.php" method="post">
                    <div class="container">
                        <div class="row">
                        <h3 class="fs-4 mb-3">
                        <?php
                                $query = "SELECT * FROM  user_info  WHERE user_info_id='" . $_GET["user_info_id"] . "'";
                                $result = $mysqli->query($query);
                                while ($data = $result->fetch_assoc()) {
                                    echo "$data[first_name]  "."$data[middle_name] "."$data[last_name]    ";
                                   
                                }
                        ?>
                         <?php
                                $query = "SELECT * FROM  vaccine_data  WHERE user_info_id='" . $_GET["user_info_id"] . "'";
                                $result = $mysqli->query($query);
                                while ($data = $result->fetch_assoc()) {
                                    //$data[vaccine_administered];
                                     $vaccine_administered = $data['vaccine_administered'];
                                    //echo ' <a href="vaccine_data.php?user_info_id='.$data["user_info_id"].'"><button class="btn btn-primary">Add Vaccine Data</button></a>';
                                
                               
                                }
                                print"/ Vaccine Taken: {$vaccine_administered}";
                        ?>
                    </h3>      
                            <div class="col-sm-3">
                                
                                <hr class="mb-3">
                                        <input type="hidden" name="user_info_id" value="<?php echo $_GET["user_info_id"]; ?>"> 
                                        <label for="vaccine_administered"><b>Vaccine Brand</b></label>
                                        <select class="form-control" name="vaccine_administered" id="vaccine_administered">
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

                                        <label for="date_administered"><b>Date Administered</b></label>
                                        <input class="form-control" id="date_administered" type="text" value="<?php echo date('m/d/y');?>" name="date_administered"  readonly="readonly" >


                                        <label for="vaccine_administered"><b>Vaccinator</b></label>
                                        <select class="form-control" name="vaccinator" id="vaccinator">
                                        <?php
                                                $sql = "SELECT * FROM workforce";
                                                $all_stocks= mysqli_query($mysqli ,$sql);
                                                    while ($vaccinator = mysqli_fetch_array(
                                                            $all_stocks,MYSQLI_ASSOC)):;
                                         ?>
                                           <option value="<?php echo $vaccinator["firstname"];
                                                        ?>">
                                                    <?php echo $vaccinator["firstname"];
                                                    ?>
                                            </option>
                                            <?php
                                                endwhile;
                                            ?>
                                        </select>

                                        <div class="form-group">
                                        <label for="vaccine_administered"><b>Brangay</b></label>
                                            <select class="form-control" required name="brgy">
                                                <option selected>Choose Baranggay</option>
                                                <option value="Alang-alang">Alang-alang</option>
                                                <option value="Caduawan">Caduawan</option>
                                                <option value="Camoboan">Camoboan</option>
                                                <option value="Canaocanao">Canaocanao</option>
                                                <option value="Combado">Combado</option>
                                                <option value="Daantabogon">Daantabogon</option>
                                                <option value="Ilihan">Ilihan</option>
                                                <option value="Kal-anan">Kal-anan</option>
                                            </select>
                                        </div>

                                        <label for="number_of_dosage"><b>Side Effects</b></label>
                                        <textarea id="side_effects" name="side_effects" rows="4" cols="50">
                                        </textarea>
                                <input class="btn btn-primary" type="submit" id="submitted" name="create" value="ADD">
                            </div>
                        </div>
                    </div> 
                </form> 
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

