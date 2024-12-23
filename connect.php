<?php
$mysqlhostname="localhost";
$mysqlusername="root";
$mysqlpassword="";
$mysqldatabase="projectdatabase";
$con=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$mysqldatabase);
if($con->connect_error){
    die("conection failed".$con->connect_error);
  } 
?>