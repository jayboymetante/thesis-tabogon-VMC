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
                echo 'Registered SuccessFully';
                exit();
            }
        }else{
            $errors['db-error'] = "Failed while inserting data into database!";
        }
      }
    
  }
  





 
?>