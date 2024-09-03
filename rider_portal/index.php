<?php
session_start();
include('dbconnection.php');

 if($_SERVER["REQUEST_METHOD"] == "POST"){
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    if(empty($contact)){
		header("Location: index.php?error=Contact number is required");
		exit();

	}else if(empty($password)){
		header("Location: index.php?error=Password is required");
		exit();
    }
    else{
		// $password = md5($password);
		
		$sql = "SELECT * FROM staff_users WHERE contact='$contact' AND password='$password'";

		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
			if($row['contact'] === $contact && $row['password'] === $password){
				$_SESSION['id'] = $row['id'];
        $_SESSION['contact'] = $row['contact'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
				header("Location: rider_dashboard.php");
				exit();
			}else{
        header("Location: index.php?error=Invalid Contact number or Password!");
        exit();
			}
		}
		else{
			header("Location: index.php?error=Invalid Contact number or Password!");
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
      <header>Rider Login</header>

      <div class="form-outer">
        <form action="index.php" method="post">
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
                <button class="submit" type="submit">login</button>
                </div>
                <p>Not a member?<a href="register.php" class="ca">Sign Up</a></p> <!-- register page -->
            </div>
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
