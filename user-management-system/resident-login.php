<?php require_once "datacontroller.php"; ?>
<?php


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  </head>
  <body>
  <img src="img/signinlogo.png" alt="signin-logo" class="sign-logo">
    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Sign in to start your session</span></div>
        <?php
                        if(count($errors) > 0){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                foreach($errors as $showerror){
                                    echo $showerror;
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
       
        <form action="/user-management-system/resident-login.php" method="POST" >
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="username" name="email" placeholder="Email or Phone" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="row button">
            <input type="submit" name="login" value="Sign in">
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
