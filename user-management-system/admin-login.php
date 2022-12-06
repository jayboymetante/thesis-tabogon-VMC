<?php
if (!isset($_SESSION)) { session_start(); }	
require 'connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['username']) && isset($_POST['password'])){

        $username = $_POST['username'];
        $password = ($_POST['password']);

        $password_hash = ($password);
        if(!empty($username) && !empty($password)){
            $query = "SELECT * FROM `users` WHERE  `username` = '".$mysqli->real_escape_string($username)."' and `password` = '".$mysqli->real_escape_string($password_hash)."' ";
            if($result = $mysqli->query($query)){
                
                $query_num_rows = $result->num_rows;
                

                if($query_num_rows == 0){
                  header("Location: admin-login.php?error=Incorect User name or password");
                 }else if ($query_num_rows == 1){
                    $result=$result->fetch_assoc();
                    $user_id = $result["user_id"];
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username']=$result['username'];
                    header('Location: admin-dashboard.php');
                }
            }{
                echo "Couldn't find your user account.";
            }
        }else {
            echo 'Supply username and password!';
        
        }
    }
}
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
  <img src="img/Tabogon.png" alt="tabogon-logo" class="center_img">

    <div class="container">
      <div class="wrapper">
        <div class="title"><span>Sign in to start your session</span></div>
        <?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
       	<?php } ?>
        <form action="/user-management-system/admin-login.php" method="POST" >
          <div class="row">
            <i class="fas fa-user"></i>
            <input type="username" name="username" placeholder="Email or Phone" required>
          </div>
          <div class="row">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="row button">
            <input type="submit" value="Sign in">
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
