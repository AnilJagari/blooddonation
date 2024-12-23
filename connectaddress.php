<?php
$mysqlhostname="localhost";
$mysqlusername="root";
$mysqlpassword="";
$mysqldatabase="address";
$con=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$mysqldatabase);
if($con->connect_error){
    die("conection failed".$con->connect_error);
  } 
?>