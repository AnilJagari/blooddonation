<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    include "../connect.php";
    $username=$_POST["username"];
    $flage = false;
    $sql1="select name from admin";
    $res1=$con->query($sql1);
    if ($res1) {
        if($res1->num_rows>0){
            while($row=$res1->fetch_assoc()){
                $adminname=$row["name"];
                $con2=new mysqli("localhost","root","",$adminname);
                if($con2->connect_error){
                    die("conection failed".$con2->connect_error);
                    } else{
                         $sql2="select username from $adminname.donar where username='$username'";
                         $res2=$con2->query($sql2);
                         if ($res2) {
                             if($res2->num_rows>0){
                                 echo "exist";
                                 $flage =true;
                                 break;
                             }
                                
                             }
                             else {
                                // Query failed
                                 echo "Error: " . $con2->error;
                                }            
                         }
                         if($con2){
                            $con2->close();  
                          }
             }
             
             if(!$flage){
                     echo "not exist";
             }
        }else{
            echo "not exist";
        }
    
  }
  else {
      // Query failed
      echo "Error: " . $con->error;
  } 
  if($con){
    $con->close();
  }
 
 
}


?>   