<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
session_start();
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$state_id=$_POST["state"];
$district_id=$_POST["district"];
$mandal_id=$_POST["mandal"];
$connew=new mysqli("localhost","root","","address");
    if($connew->connect_error){
        die("conection failed".$connew->connect_error);
      }else{  
        $sqlnew1="select name from state where id='$state_id'";
        $resnew1=$connew->query($sqlnew1);
        if($resnew1==true and $resnew1->num_rows==1){
            $rownew1=$resnew1->fetch_assoc();
            $state=$rownew1["name"];
            $sqlnew2="select name from district where id='$district_id'";
            $resnew2=$connew->query($sqlnew2);
            if($resnew2==true and $resnew2->num_rows==1){
                $rownew2=$resnew2->fetch_assoc();
                $district=$rownew2["name"];
                $sqlnew3="select name from mandal where id='$mandal_id'";
                $resnew3=$connew->query($sqlnew3);
                if($resnew3==true and $resnew3->num_rows==1){
                    $rownew3=$resnew3->fetch_assoc();
                    $mandal=$rownew3["name"];  
                }else{
                    echo "Error: " . $connew->error;
                }
            }else{
                echo "Error: " . $connew->error; 
            }
        }else{
            echo "Error: " . $connew->error;
        }
      } 
    if($connew){
        $connew->close();
    }
$sql1="update admin set phone='$phone',email='$email',state='$state',district='$district',mandal='$mandal' where username='$username' and password='$password'";
$res1=$con->query($sql1);
if($res1){
    echo "updated successfully";
}else{
    echo "Error: " . $con->error;
}
$con->close();
}  
?>   