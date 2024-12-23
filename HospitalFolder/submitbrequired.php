<?php
if(isset($_POST["submit"])){
    session_start();
    $required=$_POST["required"];
    $min=$_POST["min"];
    $bloodgroup=$_POST["bloodgroup"];
    include "../connect.php";
    $username=$_SESSION["username"];
    $password=$_SESSION["password"];
    $state=$_SESSION["state"];
    $district=$_SESSION["district"];
    $mandal=$_SESSION["mandal"];
    $sql1="select name from admin  where state='$state' and district='$district' and mandal='$mandal'";
    $res1=$con->query($sql1);
    if($res1){
        $row1=$res1->fetch_assoc();
        $adminname=$row1["name"];
        $con2=new mysqli("localhost","root","",$adminname);
        if($con2->connect_error){
           die("conection failed".$con2->connect_error);
        }else{
            $sql2="select name from hospital where username='$username' and password='$password'";
            $res2=$con2->query($sql2);
            if($res2){
              $row=$res2->fetch_assoc();
              $name=$row["name"];
              $con3=new mysqli("localhost","root","",$name);
              if($con3->connect_error){
                die("conection failed".$con3->connect_error);
              }else{
                $sql3="update $name.hosp_blood_details set total_bloodunits_required='$required',min_bloodunits_required='$min' where bloodgroup='$bloodgroup'";
                $res3=$con3->query($sql3);
                if($res3){
                    header("location:blooddetails.php");
                }else{
                    echo "Error: " . $con3->error;
                }
              }
              $con3->close();
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