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
  
    // echo "$id <br>";
    // echo "$contact";
    // echo $first_name;
    // echo "$last_name";
  
}


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['from_branch_id'])){

    $sender_name = $_POST['sender_name'];
    $sender_address = $_POST['sender_address'];
    $sender_contact = $_POST['sender_contact'];

    $receiver_name = $_POST['receiver_name'];
    $receiver_address = $_POST['receiver_address'];
    $receiver_contact = $_POST['receiver_contact'];

    $from_branch_id = $_SESSION['from_branch_id'];
    $to_branch_id = $_POST['to_branch_id'];

    $parcel_weight = $_POST['parcel_weight'];
    $parcel_price = $_POST['parcel_price'];
    $status = 1;

    $tracking_number = rand(000000000000,999999999999);

    $sender_query = "INSERT INTO parcels(tracking_number, sender_name, sender_address, sender_contact, receiver_name, receiver_address, receiver_contact, from_branch_id, to_branch_id, weight, price, status) VALUES( '$tracking_number', '$sender_name', '$sender_address', '$sender_contact', '$receiver_name', '$receiver_address', '$receiver_contact', '$from_branch_id', '$to_branch_id','$parcel_weight','$parcel_price','$status')";

    $result = mysqli_query($con,$sender_query);

    if(!$result){
        die("Not connect." . mysqli_error($con));
    }
}    

?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>New Parcel</title>
<link rel="stylesheet" href="css/header_sidebar_design.css">
<link rel="stylesheet" href="css/addparceldesign.css">
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
  <a href="add_parcel_info.php"  class="active"><i class="fa fa-cubes" aria-hidden="true"></i>New Parcel</a>
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
        <p class="text">New Parcel</p>
    </div>
    <div class="horizontal-line"></div>
    <form action="add_parcel_info.php" method="post">
        <div class="grid-container3">
            <div class="box">
                <p class="head">Sender Information</p>
                <label class="label" for="sname">Name:</label><br>
                <input type="text" id="sname" name="sender_name" required><br>
                <label class="label" for="saddress">Address:</label><br>
                <input type="text" id="saddress" name="sender_address" required><br>
                <label class="label" for="snumber">Contact Number:</label><br>
                <input type="tel" id="snumber" name="sender_contact" pattern="\d{11}" placeholder="11 digit contact number" required><br>
                <label class="label" for="branch">Your branch:</label><br>
                <p class="from_branch_id" name="from_branch_id" id="branch" required>
                <?php
                    $id = $_SESSION['id'];
                    $contact = $_SESSION['contact'];
                  
                    $query = mysqli_query($con,"select * from agent_users where contact='$contact' and id='$id'");
                    $row =mysqli_fetch_assoc($query);
                    // $from_branch_id = $row['id'];
                    $_SESSION['from_branch_id'] = $row['id'];
                    $contact = $row['contact'];
                    $state_address=$row['state_address'];
                    $district=$row['district'];
                    
                    // echo $_SESSION['from_branch_id'];
                    // echo "$contact";
                    echo $state_address;
                    echo ",  $district";
                    
                  
                
                ?>
                </p>
            </div>
            <div class="box">
                <p class="head">Receiver Information</p>
                <label class="label" for="rname">Name</label><br>
                <input type="text" id="rname" name="receiver_name" required><br>
                <label class="label" for="raddress">Address</label><br>
                <input type="text" id="raddress" name="receiver_address" required><br>
                <label class="label" for="rnumber">Contact Number</label><br>
                <input type="tel" id="rnumber" name="receiver_contact" pattern="\d{11}" placeholder="11 digit contact number" required><br>
                <label class="label" for="">Select a branch</label><br>
                <select name="to_branch_id" required>
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
        </div>
        <div class="box1"><br>
            <!-- <h2>Parcel Details</h2> -->
            <label class="label" for="parcelWeight">Packet Weight (gm):</label>
            <input type="number" id="parcelWeight" name="parcel_weight" min="100" step="100" placeholder="100" required/>
            <label class="label" for="price">Parcel Price (tk):</label>
            <input type="number" id="price" name="parcel_price" min="50" step="50" placeholder="50" required/>
        </div>
        <div class="button">
        <br><br><button type="submit">Submit</button>
        </div>
    </form>
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