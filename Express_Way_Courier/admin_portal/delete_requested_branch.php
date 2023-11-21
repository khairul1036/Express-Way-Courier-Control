<?php
session_start();

$checkSession=$_SESSION['contact'];
if($checkSession == true){

}else{
    header("Location: index.php");
}
include('dbconnection.php');

// delete the requested branch
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="Select * from requested_agent_users";
    $result=mysqli_query($con,$sql);
  
    if(!$result){
      die("Not connect." . mysqli_error($con));
    }
    else{
      $delete= "DELETE FROM requested_agent_users WHERE id='$id'";
  
      if(mysqli_query($con,$delete)){
        header("Location: branch_list.php?echo 'delete Successful'");
        exit();
      }
      else{
        echo "Error deleting branch: " . mysqli_error($con);
      }
    }
  }
// delete the requested branch

?>