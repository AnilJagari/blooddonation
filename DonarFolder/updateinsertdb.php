<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
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
        $firstname=$_POST["firstname"];
        $lastname=$_POST["lastname"];
        $name=$lastname." ".$firstname;
        $phone=$_POST["phone"];
        $email=$_POST["email"];
        $date=$_POST["date"];
        $month=$_POST["month"];
        $year=$_POST["year"];
        $dob=$year."-".$month."-".$date;
        include "filterdonars.php";
        $category=agecategory($dob);
        $aadhaar=$_POST["aadhaar"];
        $gender=$_POST["gender"];
        $bloodgroup=$_POST["bloodgroup"];
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
        $sql2="update $adminname.donar set fullname='$name',phone='$phone',email='$email',dateofbirth='$dob',aadhaar='$aadhaar',gender='$gender',bloodgroup='$bloodgroup',state='$state',district='$district',mandal='$mandal',category='$category' where username='$username' and password='$password'";
        $res2=$con2->query($sql2);
        if($res2){
           echo "updated successfully";
        }else{
            echo "Error: " . $con2->error; 
        }
      }
      $con2->close();
}else{
    echo "Error: " . $con->error;
}
$con->close();
}
?>   