<?php
require 'core.php ';
require 'connect.php';


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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                <a href="admin-dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="personal-info.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold "><i
                        class="fas fa-users ">
                    </i>Personal Info</a>
                    <a href="workforce-list.php" class="list-group-item list-group-item-action bg-transparent active  second-text fw-bold "><i
                        class="fa-solid fa-user ">
                    </i>Workforce</a>
                        <a href="vaccine_stock.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                class="fa-sharp fa-solid fa-prescription-bottle me-2"></i>Vaccine Stock</a>
                <a href="reports.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
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
                    <h2 class="fs-2 m-0">Workforce List</h2>
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
                <div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="completefirstname">First Name</label>
                            <input type="email" class="form-control" id="completefirstname" >
                        </div>
                        <div class="form-group">
                            <label for="completelastname">Last Name</label>
                            <input type="email" class="form-control" id="completelastname" >
                        </div>
                        <div class="form-group">
                            <label for="completeposition">Position</label>
                            <select  id="completeposition" class="form-control">
                             <option>---</option>
                             <option>Nurse</option>
                             <option>Healthcare</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="completeusername">Username</label>
                            <input type="email" class="form-control" id="completeusername" >
                        </div>
                        <div class="form-group">
                            <label for="completepassword">Password</label>
                            <input type="email" class="form-control" id="completepassword" >
                        </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" onclick="addWorkforce()" class="btn btn-primary">Save </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                </div>
                </div>
            <div class="container-fluid px-4">
                <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#completeModal">
                    Add Workforce <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                    <div class="col">
                    <table class="table bg-white rounded shadow-sm  table-hover">
                        <thead>
                         <tr>
                            <th></th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Position</th>
                            <th>Username</th>
                            <th>Password</th>
                        </thead>
                        <?php
                            $query = " SELECT * FROM workforce";
                            $result = $mysqli->query($query);
                            $index=0;
                            while ($data = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<td>";
                                    echo ++$index;
                                    echo "</td>";
                                    echo "<td>";
                                        echo "$data[firstname]";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "$data[lastname]";
                                    echo "</td>";
                                    echo "<td>";
                                     echo "$data[position]";
                                     echo "</td>";
                                     echo "<td>";
                                     echo "$data[username]";
                                     echo "</td>";
                                     echo "<td>";
                                     echo "$data[password]";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
    <script>
        function addWorkforce(){
            var firstnameAdd=$('#completefirstname').val()
            var lastnameAdd=$('#completelastname').val()
            var positionAdd=$('#completeposition').val()
            var usernameAdd=$('#completeusername').val()
            var passAdd=$('#completepassword').val()
           
           
           
            $.ajax({
                url:"workforce-insert.php",
                type:'post',
                data:{
                    firstnameSend:firstnameAdd,
                    lastnameSend:lastnameAdd,
                    positionSend:positionAdd,
                    usernameSend:usernameAdd,
                    passSend:passAdd,
                   
                },
                success:function(data,status){
                    swal("New Workforce Added Successfully", "", "success").then(function(){
                        location.reload();
                    });
                }
            });
        }
    </script>
</body>
</html>
