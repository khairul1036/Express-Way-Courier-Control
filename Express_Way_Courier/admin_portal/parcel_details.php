<?php
session_start();

$checkSession=$_SESSION['contact'];
if($checkSession == true){

}else{
    header("Location: index.php");
}
include('dbconnection.php');

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

    // echo $from_branch_id;
    // echo "<br>$to_branch_id";

    $branch = mysqli_query($con, "Select * from agent_users where id='$from_branch_id'");
    $branch_data = mysqli_fetch_assoc($branch);
    $from_branch = $branch_data['state_address'];
    // echo $from_branch;

    $branch = mysqli_query($con, "Select * from agent_users where id='$to_branch_id'");
    $branch_data = mysqli_fetch_assoc($branch);
    $to_branch = $branch_data['state_address'];
    // echo "<br>$to_branch";

  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parcel Details</title>
  
  <link rel="stylesheet" href="css/parcel_details.css">
</head>
<body>

<!-- header -->
<div class="grid-container">
  <div class="btn">
    <button class="openbtn" onclick="toggleNav()" style="display: none;">☰</button>
  </div>
  <div class="head-text"  style="height: 30px;">
    <span><b>ExpressWay Courier Control</b></span>
  </div>
  <div></div>
</div><br>
<!-- header -->
<div class="container">

<div class="text">
    <p>Parcel Details</p>
  </div>
  <div class="horizontal-line"></div>
  <div class="track-box">
    <p>Tracking Number:</p>
    <h3><?php echo $tracking_number;?></h3>
  </div>
  <div class="grid-container2">
      <div class="box"><p style="text-decoration: underline;">Sender Information</p>
      <div>
        <p>Name: </p>
        <p class="info"><?php echo $sender_name ;?></p>
        <p>Address: </p>
        <p class="info"><?php echo $sender_address ;?></p>
        <p>Contact:</p>
        <p class="info"><?php echo $sender_contact ;?></p>
      </div>

      </div>
      <div class="box"><p style="text-decoration: underline;">Recipient Information</p>
        <p>Name: </p>
        <p class="info"><?php echo $receiver_name ;?></p>
        <p>Address: </p>
        <p class="info"><?php echo $receiver_address ;?></p>
        <p>Contact:</p>
        <p class="info"><?php echo $receiver_contact ;?></p>
      </div>
  </div>
  <div class="box1"><p style="text-decoration: underline;">Parcel Information</p>
        <p>Weight: </p>
        <p class="info"><?php echo "$weight (gm)";?></p>
        <p>Price: </p>
        <p class="info"><?php echo "$price (TK)";?></p>
        <p>Branch Accepted the Parcel:</p>
        <p class="info"><?php echo $from_branch;?></p>
        <p>Nearest Branch to Recipient for Pickup:</p>
        <p class="info"><?php echo $to_branch;?></p>
  </div>
  <div class="horizontal-line"></div>
  <div class="button-container">
  <a href="parcel_list.php"><button class="cls-btn">Close</button></a>
  <?php echo '<a href="download.php?id='.$result1['id'].'"><button class="print-btn">Print</button></a>'; ?>
  </div>
</div>

  
</body>
</html>