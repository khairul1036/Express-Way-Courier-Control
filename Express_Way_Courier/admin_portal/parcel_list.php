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

// delete parcel then add delete table
if(isset($_GET['id'])){
  $id=$_GET['id'];
  $sql="Select * from parcels";
  $result=mysqli_query($con,$sql);

  if(!$result){
    die("Not connect." . mysqli_error($con));
  }
  else{
    $sql = "Select * from parcels where id='$id'";
    $rs_result=mysqli_query($con,$sql);
    $result1 = mysqli_fetch_assoc($rs_result);

    $tracking_number=$result1['tracking_number'];
    $sender_name=$result1['sender_name'];
    $sender_address=$result1['sender_address'];
    $sender_contact=$result1['sender_contact'];
    $receiver_name=$result1['receiver_name'];
    $receiver_address=$result1['receiver_address'];
    $receiver_contact=$result1['receiver_contact'];
    $from_branch_id=$result1['from_branch_id'];
    $to_branch_id=$result1['to_branch_id'];
    $weight=$result1['weight'];
    $price=$result1['price'];
    $status=$result1['status'];

    $query = "INSERT INTO delete_parcels(tracking_number, sender_name, sender_address, sender_contact, receiver_name, receiver_address, receiver_contact, from_branch_id, to_branch_id, weight, price, status) VALUES( '$tracking_number', '$sender_name', '$sender_address', '$sender_contact', '$receiver_name', '$receiver_address', '$receiver_contact', '$from_branch_id', '$to_branch_id','$parcel_weight','$parcel_price', '$status')";
    $result = mysqli_query($con,$query);

    $delete= "DELETE FROM parcels WHERE id='$id'";

    if(mysqli_query($con,$delete)){
      header("Location: parcel_list.php?echo 'delete Successful'");
      exit();
    }
    else{
      echo "Error deleting parcel: " . mysqli_error($con);
    }
  }
}
// delete parcel then add delete table

// Status update
if(isset($_GET['sid']) && isset($_GET['stid'])){
  $status_id=$_GET['stid'];
  $sid=$_GET['sid'];

  // echo $status_id;
  // echo $sid;

  $query = "UPDATE parcels SET status='$status_id' WHERE id='$sid'";
  $result = mysqli_query($con,$query);

  if($result){
    header("Location: parcel_list.php?echo 'update Successful'");
    exit();
  }
  else{
    echo "Error update status parcel: " . mysqli_error($con);
  }

}
// Status update

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Parcel List</title>
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
  <a href="requested_staff.php"><i class="fa fa-reply" aria-hidden="true"></i>Requested Staff</a>
  <a href="add_parcel_info.php"><i class="fa fa-cubes" aria-hidden="true"></i>New Parcel</a>
  <a href="parcel_list.php"  class="active"><i class="fa fa-cubes" aria-hidden="true"></i>All Parcel List</a>
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
          <p class="text">Parcel List</p>
      </div>
      <div class="horizontal-line"></div>
    <?php
    if(isset($_SESSION['contact'])){
      $query = mysqli_query($con,"select * from admin_users where contact='$contact'");
      $row =mysqli_fetch_array($query);
      $id=$row['id'];
      // echo "$id";
    
    $rs_result3=mysqli_query($con,"Select * from parcels");

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
    $sql="Select * from parcels limit ".$startinglimit.','.$numberPages;
    $rs_result=mysqli_query($con,$sql);
    }
    ?>


      <table class="table1">
        <th>
          <tr class="table-head">
            <td>SI.No</td>
            <td>Tracking Number</td>
            <td>Sender Name</td>
            <td>Receiver Name</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </th>


        <?php
        $num=mysqli_num_rows($rs_result);
        if($num>0){
          while($result = mysqli_fetch_assoc($rs_result)) {
             $sid= $result['id'];
          ?>
            <tr class="serial_number">
              <td></td>
              <td><?php echo $result['tracking_number'] ?></td>
              <td><?php echo $result['sender_name'] ?></td>
              <td><?php echo $result['receiver_name'] ?></td>
              
              <td>
                    <?php
                        $result4 = mysqli_fetch_assoc($rs_result3);
                        $status=$result4['status'];
                        // echo $status;
                        
                        if($status){
                        $query1 = mysqli_query($con,"select * from status where sid='$status'");
                        $row1 =mysqli_fetch_assoc($query1);

                        $status1=$row1['status'];
                        echo $status1;
                        }
                    ?>
              </td>

              <td>
                <!-- <form action="parcel_list.php" method="get"> -->

                <select name="status_id" required style="width: 30px; height: 30px; border-radius: 5px;">
                      <option></option>
                          <?php
                              include('dbconnection.php');
                              $status = mysqli_query($con, "Select * from status");
                              while($status_id = mysqli_fetch_array($status)) {
                          ?>
                          <option value="<?php echo $status_id['sid']?>">
                                  <?php
                                   $_SESSION['stid']=$status_id['sid'];
                                      //  echo $stid;
                                      echo $status_id['status'];
                                  ?></option>
                            <?php } ?>
                    </select> 
                    <a style="text-decoration: none;" href="parcel_list.php? sid= <?php echo $sid?> & stid=<?php echo $_SESSION['stid']?>"><button class="check-btn"><i class="fa fa-check"></i></button></a>
                    <!-- </form> --> 
                  <a style="text-decoration: none;" href="parcel_details.php? id= <?php echo $result['id'] ?>"><button class="eye-btn"><i class="fa fa-eye"></i></button></a>
                  <a style="text-decoration: none;" class="del-btn" href="parcel_list.php? id= <?php echo $result['id'] ?>"><i class="fa fa-trash"></i></a>
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
              echo '<a class="pagination-btn ' . $activeClass . '" href="parcel_list.php?page=' . $i . '">' . $i . '</a>';
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
