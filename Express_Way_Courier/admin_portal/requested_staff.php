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
  
    $query = mysqli_query($con,"select * from admin_users where contact='$contact' and id='$id'");
    $row =mysqli_fetch_array($query);
    $id = $row['id'];
    $contact = $row['contact'];
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
    $image=$row['image'];
  
    // echo "$id <br>";
    // echo "$contact";
    // echo $first_name;
    // echo "$last_name";
  
}


?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Requested Staff</title>
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
            $query = mysqli_query($con,"select * from admin_users where contact='$contact'");
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
  <a href="admin_dashboard.php"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a>
  <a href="branch_list.php"><i class="fa fa-building" aria-hidden="true"></i>Branch List</a>
  <a href="requested_branch.php"><i class="fa fa-reply" aria-hidden="true"></i>Requested Branch</a>
  <a href="staff_list.php"><i class="fa fa-users" aria-hidden="true"></i>Staff List</a>
  <a href="requested_staff.php" class="active"><i class="fa fa-reply" aria-hidden="true"></i>Requested Staff</a>
  <a href="add_parcel_info.php"><i class="fa fa-cubes" aria-hidden="true"></i>New Parcel</a>
  <a href="parcel_list.php"><i class="fa fa-cubes" aria-hidden="true"></i>All Parcel List</a>
  <a href="total_shipped.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Shipped</a>
  <a href="total_transit.php"><i class="fa fa-cubes" aria-hidden="true"></i>In-Transit</a>
  <a href="total_delivered.php"><i class="fa fa-cubes" aria-hidden="true"></i>Total Delivered</a>
  <a href="unsuccessfull_delivery.php"><i class="fa fa-cubes" aria-hidden="true"></i>Unsuccessfull</a>
  <a href="accept_from_driver.php"><i class="fa fa-motorcycle" aria-hidden="true"></i>Accept From Driver</a>
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
          <p class="text">Requested Staff List</p>
      </div>
      <div class="horizontal-line"></div>
    <?php
    if(isset($_SESSION['contact'])){
      $query = mysqli_query($con,"select * from admin_users where contact='$contact'");
      $row =mysqli_fetch_array($query);
      $id=$row['id'];
      // echo "$id";
    
    $rs_result3=mysqli_query($con,"Select * from requested_staff_users");

    $num=mysqli_num_rows($rs_result3);
    $numberPages=9;
    $totalPages=ceil($num/$numberPages);

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    if(isset($_GET['page'])){
      $page=$_GET['page'];
      // echo $page;
    }else{
      $page=1;
    }

    $startinglimit=($page-1)*$numberPages;
    $sql="Select * from requested_staff_users limit ".$startinglimit.','.$numberPages;
    $rs_result=mysqli_query($con,$sql);
    }
    ?>


      <table class="table1">
        <th>
          <tr class="table-head">
            <td>SI.No</td>
            <td>Name</td>
            <td>Address</td>
            <td>Allocation Branch</td>
            <td>contact</td>
            <td>Issue Date</td>
            <td>Action</td>
          </tr>
        </th>


        <?php
        $num=mysqli_num_rows($rs_result);
        if($num>0){
          while($result = mysqli_fetch_assoc($rs_result)) {
          ?>
            <tr class="serial_number">
              <td></td>
              <td><?php echo $result['first_name'], " " ,$result['last_name']?></td>
              <td><?php echo $result['state_address'] ?></td>
              <td><?php 
                $bid=$result['allocation_branch'];
                $query = mysqli_query($con,"select * from agent_users where id='$bid'");
                $row =mysqli_fetch_array($query);
                echo $row['state_address']; ?>
              </td>
              <td><?php echo $result['contact'] ?></td>
              <td><?php echo $result['date'] ?></td>
              <td>
                <a style="text-decoration: none;" class="check-btn" href="accept_requested_staff.php?id= <?php echo $result['id'] ?>"><i class="fa fa-check-square"></i></a>
                <a style="text-decoration: none;" class="del-btn" href="delete_requested_staff.php? id= <?php echo $result['id'] ?>"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
        <?php
          }
        }
        ?>

      </table>
    <?php
          for ($i = 1; $i <= $totalPages; $i++) {
              $activeClass = ($i == $currentPage) ? 'active-btn' : '';
              echo '<a class="pagination-btn ' . $activeClass . '" href="requested_branch.php?page=' . $i . '">' . $i . '</a>';
          }
    ?>
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
