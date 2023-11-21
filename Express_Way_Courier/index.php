<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=A, initial-scale=1.0">
    <title>ExpressWay Courier Control</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body{
          align-items: 0;
          justify-content: 0;
          min-height: 100vh;
          overflow: hidden;
          background: #d3d3d3d3;
        }
        .head{
          width: 100%;
          height: 50px;
          top: 0;
          left: 0;
          background-color: #28A745;
          padding-top: 0px;  
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .head .head-text{
          color: #ffffff;
          padding-top: 8px;
          text-align: center;
          font-size: 30px;
        }
        .container{
          display: flex;
          justify-content: center;
          margin-top: 200px;
        }
        .sub-container{
          width: 400px;
          height: 200px;
          margin: 10px;
          color: #fff;
          text-decoration: none;
          text-align: center;
          line-height: 30px;
          font-size: 30px;
          border-radius: 5px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .box1{
          background-color: #F7A35C;
        }
        .box2{
          background-color: #8085E9;
        }
        .box3{
          background-color: #EF5350;
        }
        .fa{
          font-size: 150px;
          color: #f1f1f1;
        }

    </style>
</head>
<body>
    <!-- header -->
<div class="head">
  <div class="head-text">
    <span><b>ExpressWay Courier Control</b></span>
  </div>
</div>
<!-- header -->
<div class="container">
    <a href="admin_portal/index.php" class="sub-container box1"><i class="fa fa-user" aria-hidden="true"></i><br>Admin</a>
    <a href="agent_portal/index.php" class="sub-container box2"><i class="fa fa-users" aria-hidden="true"></i><br>Agent</a>
    <a href="rider_portal/index.php" class="sub-container box3"><i class="fa fa-motorcycle" aria-hidden="true"></i><br>Rider</a>
</div>

</body>
</html>

