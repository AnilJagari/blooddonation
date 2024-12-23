<?php
session_start();
include "../connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$sql1="select name from admin where username='$username' and password='$password'";
$res1=$con->query($sql1);
if($res1){
  $row1=$res1->fetch_assoc();
  $adminname=$row1["name"];
  $con2=new mysqli("localhost","root","",$adminname);
  if($con2->connect_error){
     die("conection failed".$con2->connect_error);
  }else{
    $sql2="select * from hospital";
    $res2=$con2->query($sql2);
    if($res2){
         if($res2->num_rows==0){
            $sql3="delete from admin where username='$username' and password='$password'";
            $res3=$con2->query($sql2);
            if($res3){
                session_destroy();
                header("location:../home.php");
            }else{
                echo "Error: " . $con2->error; 
            }

         }
        else{
            echo "<b>Your Account Doesn't Delete Cause Your Account Have Hospital</b>"; 
        }

    }else{
        echo "Error: " . $con2->error;
    }
   
    
  }
  $con2->close();
}else{
    echo "Error: " . $con->error;
}
$con->close();
?>




