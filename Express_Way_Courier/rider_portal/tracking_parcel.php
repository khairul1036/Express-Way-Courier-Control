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
<title>Tracking Parcel</title>
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
  <a href="rider_dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
  <a href="parcel_list.php"><i class="fa fa-cubes" aria-hidden="true"></i>Parcel List</a>
  <a href="total_delivered.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Delivered</a>
  <a href="accept_from_agent.php"><i class="fa fa-street-view" aria-hidden="true"></i>Accept From Agent</a>
  <a href="tracking_parcel.php"  class="active"><i class="fa fa-search" aria-hidden="true"></i>Traking</a>
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
            <form action="tracking_parcel.php" method="post">
                <input class="search-box" type="text" name="search" placeholder="tracking number">
                <button class="" type="search">Search</button>
            </form>
        </div><br>

      <table class="table1">
        <th>
          <tr class="table-head">
            <td>Tracking Number</td>
            <td>Sender Name</td>
            <td>Receiver Name</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </th>
        <tr>
        <?php
            include('dbconnection.php');

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $search = $_POST['search'];
                $sql = "Select * from parcels where tracking_number='$search'";
                $result = mysqli_query($con,$sql);
                if(mysqli_num_rows($result)>0){
                    $row = mysqli_fetch_assoc($result);
                    $status=$row['status'];

                    $query1 = mysqli_query($con,"select * from status where sid='$status'");
                    $row1 =mysqli_fetch_assoc($query1);
                    $status=$row1['status'];
                    // echo $status1;

                    echo '
                    <tr>
                    <td>'.$row['tracking_number'].'</td>
                    <td>'.$row['sender_name'].'</td>
                    <td>'.$row['receiver_name'].'</td>
                    <td>'.$status.'</td>
                    <td>
                        <a href="parcel_details.php?id='.$row['id'].'">  
                            <button class="eye-btn"><i class="fa fa-eye"></i></button>
                        </a>
                    </td> 
                    </tr>';
                }
                else{
                    echo '<h2>Parcel not found!</h2>';
                }

            }
          
        ?>
        </tr>
      </table>
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
