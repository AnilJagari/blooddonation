<?php
session_start();
include "../connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$state=$_SESSION["state"];
$district=$_SESSION["district"];
$mandal=$_SESSION["mandal"];
$sql1="select name from admin where state='$state' and district='$district' and mandal='$mandal'";
$res1=$con->query($sql1);
if($res1){
  $row1=$res1->fetch_assoc();
  $adminname=$row1["name"];
  $con2=new mysqli("localhost","root","",$adminname);
  if($con2->connect_error){
     die("conection failed".$con2->connect_error);
  }else{
    $sql2="delete from hospital where username='$username' and password='$password'";
    $res2=$con2->query($sql2);
    if($res2){
        session_destroy();
        header("location:../home.php");
    }else{
        echo "<b>Your Account Doesn't Delete Cause Your Hospital Have Donars. So Meet The Admin</b>"; 
    }
    
  }
  $con2->close();
}else{
    echo "Error: " . $con->error;
}
$con->close();
?>




