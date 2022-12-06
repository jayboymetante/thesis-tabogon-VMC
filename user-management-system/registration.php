<?php
  session_start();
  require "connect.php";
  $email = "";
  $name = "";
  $errors = array();
  
  //if user signup button
  if(isset($_POST['signup'])){
  
      $first_name = mysqli_real_escape_string($mysqli, $_POST['first_name']);
      $middle_name = mysqli_real_escape_string($mysqli, $_POST['middle_name']);
      $last_name = mysqli_real_escape_string($mysqli, $_POST['last_name']);
      $suffix= mysqli_real_escape_string($mysqli, $_POST['suffix']);
      $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
      $birth_date = mysqli_real_escape_string($mysqli, $_POST['birth_date']);
      $age = mysqli_real_escape_string($mysqli, $_POST['age']);
      $citizenship = mysqli_real_escape_string($mysqli, $_POST['citizenship']);
      $civil_status = mysqli_real_escape_string($mysqli, $_POST['civil_status']);
      $mobile_number = mysqli_real_escape_string($mysqli, $_POST['mobile_number']);
      $height = mysqli_real_escape_string($mysqli, $_POST['height']);
      $weight = mysqli_real_escape_string($mysqli, $_POST['weight']);
      $comorbidities = mysqli_real_escape_string($mysqli, $_POST['comorbidities']);
  
  
      $email = mysqli_real_escape_string($mysqli, $_POST['email']);
      $password = mysqli_real_escape_string($mysqli, $_POST['password']);
     // $cpassword = mysqli_real_escape_string($mysqli, $_POST['cpassword']);
     
      $email_check = "SELECT * FROM user_info WHERE email = '$email'";
      $res = mysqli_query($mysqli, $email_check);
      if(mysqli_num_rows($res) > 0){
          $errors['email'] = "It Looks like you have already registered";
      }
      if(count($errors) === 0){
          $encpass = password_hash($password, PASSWORD_BCRYPT);
          $code = rand(999999, 111111);
          $status = "notverified";
          $sql = "INSERT INTO user_info ( first_name, middle_name, last_name, suffix, gender, birth_date, age, citizenship, civil_status, mobile_number , height, weight,comorbidities,email, password, code, status)
                          values('$first_name','$middle_name', '$last_name', '$suffix', '$gender', ' $birth_date', '$age', '$citizenship ', '$civil_status', '$mobile_number',  '$height','$weight', '$comorbidities','$email', '$encpass', '$code', '$status')";
          $data_check = mysqli_query($mysqli, $sql);
          if($data_check){
            $subject = "Email Verification Code";
            $message = "Your verification code is $code";
            $sender = "From: jboymetante123@gmail.com";
            if(mail($email, $subject, $message, $sender)){
              //  $info = "We've sent a verification code to your email - $email";
             //  $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                echo '<script>alert("Successfully Registered")</script>';
                
            }
        }else{
            $errors['db-error'] = "Failed while inserting data into database!";
        }
      }
    
  }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <link rel="stylesheet" href="style.css">
    <link  href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css"  rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="common/bootstrap/css/bootstrap.css" />
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/c75e69fab4.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <script type="text/javascript" src='../files/bower_components/sweetalert/js/sweetalert2.all.min.js'> </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="">
        <img src="img/Tabogon.png" class="mr-2" alt="" height="30">
        Tabogon  </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="registration.php"><i class="fas fa-syringe"></i> Register</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="map.php" target="_blank"><i ><ion-icon name="map-outline" style='color:white'></ion-icon></i></i> Map</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownEmergency" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-phone"></i> Emergency Hotline
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownEmergency">
                    <a class="dropdown-item" href="javascript:;">0969-220-2999</a>
                    <a class="dropdown-item" href="javascript:;">0928-934-7148</a>
                    <a class="dropdown-item" href="javascript:;">0928-826-7084</a>
                    <a class="dropdown-item" href="javascript:;">411-0155</a>
                    <a class="dropdown-item" href="javascript:;">255-7960</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown portal-hide">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSignIn" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownSignIn">
                        <a class="dropdown-item" href="admin-login.php">Admin</a>
                        <a class="dropdown-item" href="workforce-login.php">Workforce</a>
                        <a class="dropdown-item" href="resident-login.php">Resident</a>
                    </div>
                </li>
        </ul>
    </div>
</nav>
<h3 class="text-center"><i class="fas fa-syringe" style='color:green'></i>VACCINE INFORMATION MANAGEMENT SYSTEM</h3>
<p class="text-center">Online Registration</p>
<div class="card">
    <div class="container">
            <form action="registration.php" method="POST" autocomplete="">
            <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                <div class="form-group">
                    <label class="label" for="exampleInputFirstName">First Name</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="text" name="first_name" placeholder="First Name/Pangalan" required value="">
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputMiddleName"> Full Middle Name</label>
                    <span  class="tip-warning">Required</span>
                    <span class="tip-info">Please avoid Middle Initial for inconsistencies</span>
                    <span class="tip-info">Leave it blank if no middle name</span>
                    <input class="form-control" type="text" name="middle_name" placeholder="Middle Name/Gitnang Pangalan" required value="">
                </div>
                
                <div class="form-group">
                    <label class="label" for="exampleInputLastName">Last Name</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="text" name="last_name" placeholder="Last Name/Apelyido" required value="">
                </div>
                <div class="form-group">
                 <label class="label" for="exampleInputSuffix">Suffix</label>
                 <span  class="tip-warning">Required</span>
                 <span class="tip-info">Choose NA for not applicable</span>
                 <select class="form-control" required name="suffix">
                    <option selected>Choose Suffix</option>
                    <option value="N/A">N/A</option>
                    <option value="JR">JR</option>
                    <option value="SR">SR</option>
                    <option value="SR">II</option>
                    <option value="II">III</option>
                    <option value="IV">IV</option>
                    <option value="V">V</option>
                    <option value="VI">VI</option>
                    <option value="VII">VII</option>
                 </select>
                </div>
                <div class="form-group">
                 <label class="label" for="exampleInputGender">Gender</label>
                 <span  class="tip-warning">Required</span>
                 <select class="form-control" required name="gender">
                    <option selected>Gender/Kasarian</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                 </select>
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInBirthday">Date of Birth</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" id="date" type="date" name="birth_date" required value="">
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputAge">Age</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="number" id="age" name="age" placeholder="Age/Edad" required value="" readonly="readonly">
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputCitizenship">Citizenship</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="text" name="citizenship" placeholder="citizenship/Pagkamamamayan" required value="">
                </div>
                <div class="form-group">
                 <label class="label" for="exampleInputCivilStatus">Civil Status</label>
                 <span  class="tip-warning">Required</span>
                 <select class="form-control" required name="civil_status">
                    <option selected>Civil Status/Katayuang sibil</option>
                    <option value="single">Single</option>
                    <option value="maried">Maried</option>
                    <option value="divorced">Divorced</option>
                 </select>
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputMobileNumber">Mobile Number</label>
                    <span  class="tip-warning">Required</span>
                    <span class="tip-info">eg. 09123456789 - please follow this format</span>
                    <input class="form-control" type="number" name="mobile_number" placeholder="Mobile number/telepono" required value="">
                </div>
               
                <div class="form-group">
                    <label class="label" for="exampleInputHeight">Height</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="text" name="height" placeholder="Height" required value="">
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputWeight">Weight</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="text" name="weight" placeholder="Weight" required value="">
                </div>
                <div class="form-group">
                 <label class="label" for="exampleInputComorbidities">Comorbidities</label>
                 <span  class="tip-warning">Required</span>
                 <select class="form-control" required name="comorbidities">
                    <option selected>Choose Comorbidities</option>
                    <option value="NONE">NONE</option>
                    <option value="Hypertension">Hypertension</option>
                    <option value="Heart Disease">Heart Disease</option>
                    <option value="Kidney Disease">Kidney Disease</option>
                    <option value="Diabetes mellitus">Diabetes mellitus</option>
                    <option value="Bronchial Asthma">Bronchial Asthma</option>
                    <option value="Immunodeficiency state">Immunodeficiency state</option>
                    <option value="Cancer">Cancer</option>
                 </select>
                </div>
                    <hr>
                   <center><p class="login-credentials" >This Is to Check You Vaccination Status</p></center>
                <div class="form-group">
                    <label class="label" for="exampleInputEmail1">Email Address</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="email" name="email" placeholder="Email Address" required value="">
                </div>
                <div class="form-group">
                    <label class="label" for="exampleInputPassword1">Password</label>
                    <span  class="tip-warning">Required</span>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                
                <div class="remove_this_ondupli">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkbox1">
                        <label class="custom-control-label" for="checkbox1">
                            I hereby certify that the above information are true and correct to the best of my knowledge. I allow the Tabogon Vaccination
                            Operation Center to collect and process my Personal Information and Sensitive Personal Information for the vaccination profiling purposes.
                            The information herein shall be treated as confidential in compliance with the
                            <a href="https://eccinternational.com/" target="_blank">
                                Data Privacy Act of 2012.</a>
                        </label>
                    </div>
                    <hr>
                </div>
                <div class="form-group">
                    <input class="form-control button" id="submit" type="submit" name="signup" value="Signup">
                </div>
            </form>
          
    </div>
</div>
<div class="bg-success p-3 foooter">
    <div class="text-center text-white">
        <small>
            Copyright © 2022 <a href="#" class="text-white" target="_blank">www.Soldiers of Furtone.com</a>
            <br>
            All Rights Reserved
        </small>
    </div>
</div>



<script >

  /* $("#submit").click(function(){
var dob = document.getElementById("date").value;
var year = Number(dob.substr(0, 4));
var month = Number(dob.substr(4, 2)) - 1;
var day = Number(dob.substr(6, 2));
var today = new Date();
var age = today.getFullYear() - year;
if (today.getMonth() < month || (today.getMonth() == month && today.getDate() < day)) {
  age--;
}
console.log(age);
// var newage = document.getElementById("age1").value;
document.getElementById("age1").setAttribute('value',age);

});*/

$(document).on('change', '#date', function() {
var birthdate = $(this).val();
calculate(birthdate);
});
   
function calculate(birthdate) {
  var start = new Date(birthdate);
  var end       = new Date();
  var age_year  = Math.floor((end - start)/31536000000);
  var age_month = Math.floor(((end - start)% 31536000000)/2628000000);
  var age_day   = Math.floor((((end - start)% 31536000000) % 2628000000)/86400000);
  $('#age').val(age_year);
}


</script>
</body>
</html>