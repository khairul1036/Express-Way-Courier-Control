<?php
session_start();

$checkSession=$_SESSION['contact'];
if($checkSession == true){

}else{
    header("Location: index.php");
}
include('dbconnection.php');

//accept the request then insert agent_users table and sent Set password sms
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="Select * from requested_staff_users";
    $result=mysqli_query($con,$sql);
  
    if(!$result){
      die("Not connect." . mysqli_error($con));
    }
    else{
      $sql = "Select * from requested_staff_users where id='$id'";
      $rs_result=mysqli_query($con,$sql);
      $result1 = mysqli_fetch_assoc($rs_result);
  
      $first_name=$result1['first_name'];
      $last_name=$result1['last_name'];
      $state_address=$result1['state_address'];
      $post_office=$result1['post_office'];
      $zip_code=$result1['zip_code'];
      $district=$result1['district'];
      $city=$result1['city'];
      $contact=$result1['contact'];
      $allocation_branch=$result1['allocation_branch'];
      $image = 'user.png';
      //  echo $contact;
  
      $query = "INSERT INTO staff_users(first_name, last_name, state_address, post_office, zip_code, district, city, contact, allocation_branch, image) 
                VALUES( '$first_name', '$last_name', '$state_address', '$post_office', '$zip_code', '$district', '$city', '$contact', '$allocation_branch', '$image')";
      $result = mysqli_query($con,$query);
  
      $delete= "DELETE FROM requested_staff_users WHERE id='$id'";
  
      if(mysqli_query($con,$delete)){

        // Set password page link Sent sms 

        $to = $contact;
        $token = "999523422816942813488d3bdae5d05581df29b5e7b01df0dabd";
        $message = "Your OTP code is 6541. Do not share anyone.";
        
        $url = "http://api.greenweb.com.bd/api.php?json";
        
        
        $data= array(
        'to'=>"$to",
        'message'=>"$message",
        'token'=>"$token"
        ); 
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        
        //Result
        // echo $smsresult;
        
        // //Error Display
        // echo curl_error($ch);

        // Set password page link Sent sms 

        header("Location: staff_list.php?echo 'staff Add Successful'");
        exit();
      }
      else{
        echo "Error adding staff: " . mysqli_error($con);
      }

    }
  }
//accept the request then insert agent_users table and sent Set password sms

?>