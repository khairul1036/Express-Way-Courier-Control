<?php

require('dbconnection.php');

 if($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $state_address = $_POST['state_address'];
    $post_office = $_POST['post_office'];
    $zip_code = $_POST['zip_code'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $select_branch_id = $_POST['select_branch_id'];
    $contact = $_POST['contact'];
    $image = 'user.png';

    $user_data = 'first_name=' . $first_name .
             '&last_name=' . $last_name .
             '&state_address=' . $state_address .
             '&post_office=' . $post_office .
             '&zip_code=' . $zip_code .
             '&district=' . $district .
             '&city=' . $city .
             '&select_branch_id=' . $select_branch_id .
             '&contact=' . $contact;

    if(empty($first_name)){
        header("Location: register.php?error=Fisrt name is required&$user_data");
        exit();
    }
    else if(empty($last_name)){
        header("Location: register.php?error=Last name is required&$user_data");
        exit();
    }
    else if(empty($state_address)){
        header("Location: register.php?error=State Address is required&$user_data");
        exit();
    }
    else if(empty($post_office)){
        header("Location: register.php?error=Post Office is required&$user_data");
        exit();
    }
    else if(empty($zip_code)){
        header("Location: register.php?error=Postal/Zip-code is required&$user_data");
        exit();
    }
    else if(empty($district)){
        header("Location: register.php?error=District is required&$user_data");
        exit();
    }
    else if(empty($city)){
        header("Location: register.php?error=City is required&$user_data");
        exit();
    }
    else if(empty($select_branch_id)){
      header("Location: register.php?error=Select branch is required&$user_data");
      exit();
  }
    else if(empty($contact)){
        header("Location: register.php?error=Contact number is required&$user_data");
        exit();
    }
    else{
        $sql = "SELECT * FROM staff_users WHERE contact='$contact' ";

		$result = mysqli_query($con, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: register.php?error=The contact number is taken try another&$user_data");
			exit();

		}else{
			$sql2 = "INSERT INTO requested_staff_users(first_name, last_name, state_address, post_office, zip_code, district, city, contact, allocation_branch, image) 
                     VALUES('$first_name', '$last_name', '$state_address', '$post_office', '$zip_code', '$district', '$city', '$contact','$select_branch_id','$image')";
			$result2 = mysqli_query($con, $sql2);
			if ($result2) {
				header("Location: view.php?success=Your request is processing");
			exit();
			}else{
				header("Location: register.php?error=unknown error occurred&$user_data");
			exit();
			}

		}
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/registerdesign.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>
    <div class="container">
      <header>Rider Application Form</header>
      <div class="progress-bar">
        <div class="step">
          <p>Name</p>
          <div class="bullet">
            <span>1</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Address</p>
          <div class="bullet">
            <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Branch</p>
          <div class="bullet">
            <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>Submit</p>
          <div class="bullet">
            <span>4</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
      </div>

      <div class="form-outer">
        <form action="register.php" method="post">
          <div class="page slide-page">
            <div class="title">Basic Info:</div>
            <div class="field">
              <div class="label">First Name</div>
              <input type="text" name="first_name" placeholder="Khairul" required>
            </div>
            <div class="field">
              <div class="label">Last Name</div>
              <input type="text" name="last_name" placeholder="Islam" required>
            </div>
            <div class="field">
              <button class="firstNext" type="submit">Next</button>
            </div>
            <p>Already have an account?<a href="index.php" class="ca">Login</a></p> <!-- Back Login page -->
          </div>

          <div class="page">
            <div class="title">Address Info:</div>
            <div class="field">
              <div class="label">State address</div>
              <input type="text" name="state_address" placeholder="Shewrapara, Begum Rokeya Sarani, Mirpur" required>
            </div>
            <div class="grid-container">
              <div class="field1">
                <div class="label1">Post Office</div>
                <input type="text" name="post_office" placeholder="Mirpur" required>
              </div>
              <div class="field1">
                <div class="label1">Pastal/Zip Code</div>
                <input type="text" name="zip_code" placeholder="1216" required>
              </div>
              <div class="field1">
                <div class="label1">District</div>
                <input type="text" name="district" placeholder="Dhaka" required>
              </div>
              <div class="field1">
                <div class="label1">City</div>
                <input type="text" name="city" placeholder="Dhaka" required>
              </div>
              <div class="field btns">
                <button class="prev-1 prev">Previous</button>
                <button class="next-1 next" type="submit">Next</button>
              </div>
            </div>
          </div>

          <div class="page">
            <div class="title">Banch Info:</div>
            <div class="field">
              <div class="label">Select your working banch</div>
              <select name="select_branch_id" required>
                  <option style="color: red;">Please select here</option>
                      <?php
                          include('dbconnection.php');
                          $branch = mysqli_query($con, "Select * from agent_users");
                          while($branch_id = mysqli_fetch_array($branch)) {
                      ?>
                      <option value="<?php echo $branch_id['id']?>">
                              <?php 
                              $coma = ',  ';
                                  echo $branch_id['state_address'];
                                  echo $coma;
                                  echo $branch_id['district'];
                              ?></option>
                      <?php } ?>
              </select>
            </div>
            <div class="field btns">
              <button class="prev-2 prev">Previous</button>
              <button class="next-2 next" type="submit">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">Contact Number:</div>
            <div class="field">
              <div class="label">Number</div>
              <input type="tel" name="contact" pattern="\d{11}" placeholder="015xxxxxxxx" required>
            </div>
            <div class="field btns">
              <button class="prev-3 prev">Previous</button>
              <button class="submit" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <script src="script.js"></script>

  </body>
</html>
