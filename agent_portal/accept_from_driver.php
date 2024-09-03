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
  
    $query = mysqli_query($con,"select * from agent_users where contact='$contact' and id='$id'");
    $row =mysqli_fetch_array($query);
    $id = $row['id'];
    $contact = $row['contact'];
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
    $image=$row['image'];
  
    // echo "$id";
    // echo "$contact";
    // echo $first_name;
    // echo "$last_name";
  
}


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Accept From Driver</title>
<link rel="stylesheet" href="css/header_sidebar_design.css">
<link rel="stylesheet" href="css/table.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<!-- sidebar -->
<div id="mySidebar" class="sidebar">
  <img src="user_img/<?php echo "$image";?>" alt="Avatar" class="avatar"> 
  <p><?php 
          if(isset($_SESSION['contact'])){
            $query = mysqli_query($con,"select * from agent_users where contact='$contact'");
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
  <a href="agent_dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
  <a href="add_parcel_info.php"><i class="fa fa-cubes" aria-hidden="true"></i>New Parcel</a>
  <a href="parcel_list.php"><i class="fa fa-cubes" aria-hidden="true"></i>All Parcel List</a>
  <a href="total_shipped.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Shipped</a>
  <a href="total_transit.php"><i class="fa fa-cubes" aria-hidden="true"></i>In-Transit</a>
  <a href="total_delivered.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Delivered</a>
  <a href="unsuccessfull_delivery.php"><i class="fa fa-cubes" aria-hidden="true"></i>Unsuccessfull</a>
  <a href="accept_from_driver.php" class="active"><i class="fa fa-motorcycle" aria-hidden="true"></i>Accept From Driver</a>
  <a href="tracking_parcel.php"><i class="fa fa-search" aria-hidden="true"></i>Traking</a>
  <a href="delete_parcel.php"><i class="fa fa-trash" aria-hidden="true"></i>Delete Parcel</a>
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
</div><br>
<!-- header -->

    <div class="container">
        <div>
            <p class="text">Please tab and scan parcels QR code</p>
        </div>
        <div class="horizontal-line"></div>
        <div>
            <img class="qr-box" src="user_img/qr.png" alt="avatar">
        </div>
        <div>
        <button class="scan-btn">Scan Now</button>
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
