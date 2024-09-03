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
  <title>Download</title>

  <style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
  </style>

  <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        *{
        margin: 0;
        padding: 0;
        outline: none;
        font-family: 'Poppins', sans-serif;
        }
        body{
        align-items: 0;
        justify-content: 0;
        min-height: 100vh;
        overflow: hidden;
        }
        .grid-container{
        display: grid;
        grid-template-columns: repeat(2, 1fr); 
        /* gap: 1px; */
        width: 100%;
        height: 4%; 
        /* border: 1px solid #000; */
        margin-bottom: 5px;
        
        }
        .head{
            margin-top: 30px;
        }
        .head h2{
            text-align: center;
        }
        .head p{
            font-size: 12px;
            text-align: center;
        }
        .head .date{
            text-align: left;
            margin-left: 20px;
            margin-top: 45px;
        }
        .box{
            color: #111111;
            font-weight: 600;
            border: 1px solid #e7e7e7;
            margin-top: 15px;
            padding-top: 15px;
            padding-left: 20px;
            padding-bottom: 13px;
            border-radius: 1px;
        }
        .p{
            font-size: 20px;
            text-decoration: underline;
        }
        .text{
            font-weight: 100;
        }
        .box1{
            color: #111111;
            font-weight: 600;
            /* border: 1px solid #e7e7e7; */
            
            padding-top: 15px;
            padding-left: 20px;
            padding-bottom: 13px;
            border-radius: 1px;
            margin-bottom: 15px;
        }
        .track-box{
            /* display: inline; */
            color: #000000;
            font-size: 15px;
            font-weight: 400;
            padding-top: 15px;
            padding-left: 20px;
            padding-bottom: 5px;
        }
        .track-box1{
            /* display: inline; */
            color: #000000;
            font-size: 20px;
            font-weight: 600;
            /* padding-top: 15px; */
            padding-left: 20px;
            padding-bottom: 20px;
        }
        p.inline {
            display: inline-block;
        }
        span { 
            font-size: 13px;
        }
        .signature{
            text-decoration: underline;
            text-align: right;
            margin-top: 70px;
            margin-right: 80px;
        }



  </style>
</head>
<body onload="window.print();">

    <div class="head">
        <h2>ExpressWay Courier Control</h2>
        <p>Head Office: 12/13 road, Dhaka, Bangladesh</p>
        <p class="date" id="datetime"></p>
    </div>

    <div class="grid-container">
        <div>
            <p class="track-box">Tracking Number: <h3 class="track-box1"><?php echo $tracking_number;?></h3></p>
        </div>
        <div class="box1" style="margin-left: 40%; margin-top:-50px;">
            <?php 
                include("barcode128.php");
                echo "<p class='inline'>".bar128($result1['tracking_number'])."</p>";
            ?>
        </div>
    </div>

    <div class="grid-container" style="margin-top:-50px;"> 
        <div class="box">
            <p class="p">Sender Information</p>
            <p class="text">Name: <?php echo $sender_name ;?></p>
            <p class="text">Address: <?php echo $sender_address ;?></p>
            <p class="text">Contact: <?php echo $sender_contact ;?></p>
        </div>

        <div class="box">
            <p class="p">Recipient Information</p>
            <p class="text">Name: <?php echo $receiver_name ;?></p>
            <p class="text">Address: <?php echo $receiver_address ;?></p>
            <p class="text">Contact: <?php echo $receiver_contact ;?></p>
        </div>
    </div>

    <div class="grid-container">
        <div class="box1">
            <p class="p">Parcel Information</p>
            <p class="text">Weight: <?php echo "$weight (gm)";?></p>
            <p>Branch Accepted the Parcel: <p class="text"><?php echo $from_branch;?></p></p>
        </div>
        <div class="box1">
            <p class="p" style="margin-top:31px;"></p>
            <p class="text">Price: <?php echo "$price (TK)";?></p>
            <p>Nearest Branch to Recipient for Pickup: <p  class="text"><?php echo $to_branch;?></p></p>
        </div> 
    </div>
    <div class="signature">
        <p>signature</p>
    </div>

    <script>
        // Function to update the date and time
        function updateDateTime() {
            const datetimeElement = document.getElementById('datetime');
            const currentDatetime = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric',};
            const formattedDatetime = currentDatetime.toLocaleDateString('en-US', options);
            datetimeElement.textContent = formattedDatetime;
        }

        // Call the function to update the date and time
        updateDateTime();

        // Update the date and time every second
        setInterval(updateDateTime, 1000);
    </script>



 
</body>
</html>