<?php
session_start();

$checkSession=$_SESSION['contact'];
if($checkSession == true){

}else{
    header("Location: index.php");
}


include('dbconnection.php');

if (isset($_SESSION['id']) && isset($_SESSION['contact'])) {
  $id = $_SESSION['id'];
  $contact = $_SESSION['contact'];

  $query = mysqli_query($con,"select * from staff_users where contact='$contact' and id='$id'");
  $row =mysqli_fetch_array($query);
  $id = $row['id'];
  $contact = $row['contact'];
  $first_name=$row['first_name'];
  $last_name=$row['last_name'];
  $image=$row['image'];
  $allocation_branch=$row['allocation_branch'];
  // echo $allocation_branch;

  // echo "$id";
  // echo "$contact";
  // echo $first_name;
  // echo "$last_name";
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/header_sidebar_design.css">
  <link rel="stylesheet" href="css/dashboarddesign.css">
</head>
<body>
<!-- sidebar -->
<div id="mySidebar" class="sidebar">
  <form action="agent_dashboard.php" method="post">
    <img src="user_img/<?php echo "$image";?>" alt="Avatar" class="avatar">
    <!-- <div class="round">
      <input type="file" name="image" id="image" Accept=".jpg, .jpeg, .png">
      <i class="fa fa-camera" style="color: #fff;"></i>
    </div> -->
  </form>
  

  <!-- <p>Khairul Islam</p> -->
  <p><?php 
          if(isset($_SESSION['contact'])){
            $query = mysqli_query($con,"select * from staff_users where contact='$contact'");
            $row =mysqli_fetch_array($query);
            $contact = $row['contact'];
            $first_name=$row['first_name'];
            $last_name=$row['last_name'];
            echo "$contact";
            echo "<br>";
            echo "$first_name ", "$last_name";
          }
  ?></p>

  <div class="horizontal-line"></div>
  <div class="nav">
  <a href="rider_dashboard.php"  class="active"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
  <a href="parcel_list.php"><i class="fa fa-cubes" aria-hidden="true"></i>Parcel List</a>
  <a href="total_delivered.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Delivered</a>
  <a href="accept_from_agent.php"><i class="fa fa-street-view" aria-hidden="true"></i>Accept From Agent</a>
  <a href="tracking_parcel.php"><i class="fa fa-search" aria-hidden="true"></i>Traking</a>
  </div>
</div>
<!-- sidebar -->

<!-- header -->
<div class="grid-container">
  <div class="btn">
    <button class="openbtn" onclick="toggleNav()">☰</button>
  </div>
  <div class="head-text">
    <span><b>ExpressWay Courier Control</b></span>
  </div>
  <div><div class="div-logout"><a class="logout" href="logout.php"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Logout</a></div></div>
</div>
<!-- header -->
<div class="container">
  <div class="grid-container2">
      <div class="box">
        <div class="inside-box">
          <div class="grid-container2">
            <h2 class="total">
              <?php
                include('dbconnection.php');
                // $branch_id=$_SESSION['id'];
                $sql = "SELECT COUNT(*) AS parcel_count FROM parcels WHERE from_branch_id='$allocation_branch'"; 
                $result = mysqli_query($con, $sql);
                if ($result) {
                  $row = mysqli_fetch_assoc($result);
                  $count = $row['parcel_count'];
                  echo $count;
                } else {
                  echo "Error retrieving parcel count";
                }
              ?>
            </h2>
            <i class="fa fa-cubes" style="color: #dbdbdb; font-size: 90px; margin-top: 10px;"></i>
          </div>
          <div class="grid-container2">
            <p class="details">Total Parcels</p>
          </div>
        </div>
      </div>

      <div class="box">
          <div class="inside-box">
            <div class="grid-container2">
              <h2 class="total">
                <?php
                echo $_SESSION['id'];
                // echo 0;
                ?>
              </h2>
              <i class="fa fa-cubes" style="color: #dbdbdb; font-size: 90px; margin-top: 10px;"></i>
            </div>
            <div class="grid-container2">
              <p class="details">Total Received</p>
            </div>
          </div>
      </div>
        
      <div class="box">
        <div class="inside-box">
              <div class="grid-container2">
                <h2 class="total">
                  <?php
                    include('dbconnection.php');
                    $sql = "SELECT COUNT(*) AS parcel_count FROM parcels WHERE status=4 AND from_branch_id='$allocation_branch'"; 
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      $count = $row['parcel_count'];
                      echo $count;
                    } else {
                      echo "Error retrieving parcel count";
                    }
                 ?>
                </h2>
                <i class="fa fa-cubes" style="color: #dbdbdb; font-size: 90px; margin-top: 10px;"></i>
              </div>
              <div class="grid-container2">
                <p class="details">Total Delivered</p>
              </div>
            </div>
      </div>
        
  </div>

  <div class="grid-container2">
      <div class="box">
          <div class="inside-box">
                    <div class="grid-container2">
                      <h2 class="ctotal">Coming soon</h2>
                    </div>
          </div>
        </div>
 

      <div class="box">
          <div class="inside-box">
                    <div class="grid-container2">
                      <h2 class="ctotal">Coming soon</h2>
                    </div>
          </div>
        </div>
      

      <div class="box">
          <div class="inside-box">
                    <div class="grid-container2">
                      <h2 class="ctotal">Coming soon</h2>
                    </div>
          </div>
        </div>
      </div>
 
  
  <div class="grid-container2">
      <div class="box">
          <div class="inside-box">
                    <div class="grid-container2">
                      <h2 class="ctotal">Coming soon</h2>
                    </div>
          </div>
      </div>

      <div class="box">
        <div class="inside-box">
                  <div class="grid-container2">
                    <h2 class="ctotal">Coming soon</h2>
                  </div>
        </div>
      </div>
      <div class="box">
      <div class="inside-box">
                   <div class="grid-container2">
                    <h2 class="ctotal">Coming soon</h2>
                  </div>
        </div>
      </div>
  </div>
  
  <div class="grid-container2">
      <div class="box">
      <div class="inside-box">
                  <div class="grid-container2">
                    <h2 class="ctotal">Coming soon</h2>
                  </div>
        </div>
      </div>
      <div class="box">
      <div class="inside-box">
                  <div class="grid-container2">
                    <h2 class="ctotal">Coming soon</h2>
                  </div>
        </div>
      </div>
      <div class="box">
        <div class="inside-box">
                  <div class="grid-container2">
                    <h2 class="ctotal">Coming soon</h2>
                  </div>
        </div>
      </div>
  </div>
</div>

  







<script>
var isSidebarOpen = true;

function toggleNav() {
  var sidebar = document.getElementById("mySidebar");
  if (isSidebarOpen) {
      sidebar.style.width = "250px";
  } else {
      sidebar.style.width = "0px";
  }
  isSidebarOpen = !isSidebarOpen; 
}
toggleNav();

</script>
  
</body>
</html>