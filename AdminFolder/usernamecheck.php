<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    include "../connect.php";
    $username=$_POST["username"];
    $sql1="select username from admin where username='$username'";
    $res1=$con->query($sql1);
    if ($res1) {
        if($res1->num_rows>0){
            echo "exist";
        }
        else{
            echo "not exist"; 
        }    
       
  } else {
      // Query failed
      echo "Error: " . $con2->error;
  } 
  $con->close();  
}

?>   