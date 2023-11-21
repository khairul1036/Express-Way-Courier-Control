<?php
// session_start();

// $checkSession=$_SESSION['contact'];
// if($checkSession == true){

// }else{
//     header("Location: index.php");
// }

include('dbconnection.php');

 if($_SERVER["REQUEST_METHOD"] == "POST"){
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    $user_data = 'contact=' . $contact .
                 '&password=' . $password .
                 '&re_password=' . $re_password;

    if(empty($password)){
        header("Location: setpassword.php?error=Password is required&$user_data");
        exit();

    }else if(empty($re_password)){
        header("Location: setpassword.php?error=Re-Password is required&$user_data");
        exit();

    }else if($password !== $re_password){
        header("Location: setpassword.php?error=The confirmation password does not match&$user_data");
        exit();
    }
    else{
		//  $password = md5($password);

		$sql = "SELECT * FROM staff_users WHERE contact='$contact' ";
		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
            $sql2 = "UPDATE staff_users SET password = '$password' WHERE contact = $contact";
            $result2 = mysqli_query($con, $sql2);

			if ($result2) {
				header("Location: index.php?success=Your password set successfully");
                // echo "Your password set successfully";
			exit();
			}else{
				header("error=unknown error occurred&$user_data");
                // echo "unknown error occurred";
			exit();
            }
		}
        else{
			header("Location: setpassword.php?error=Cann't find this number try another&$user_data");
			// echo "Cann't find this number try another";
            exit();
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/registerdesign.css">
  </head>
  <body>
    <div class="container">
      <header>Set Your Password</header>

      <div class="form-outer">
        <form action="setpassword.php" method="post">
          <div class="page slide-page">

                <div class="field">
                <div class="label">Phone Number</div>
                <input type="tel" name="contact" pattern="\d{11}" placeholder="015xxxxxxxx" required>
                </div>

                <div class="field">
                <div class="label">Password</div>
                <input type="password" name="password" placeholder="password" required>
                </div>

                <div class="field">
                <div class="label">Re-Password</div>
                <input type="password" name="re_password" placeholder="re-password" required>
                </div>
                
                <div class="field">
                <button class="submit" type="submit">set</button>
                </div>
                <p>Not a member?<a href="register.php" class="ca">Sign Up</a></p> <!-- register page -->
            </div>
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
