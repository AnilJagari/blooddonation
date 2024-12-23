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
$row1=$res1->fetch_assoc();
$adminname=$row1["name"];
$con2=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$adminname);
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $phone=$_POST["phone"];
    $email=$_POST["email"];
    $date=$_POST["date"];
    $month=$_POST["month"];
    $year=$_POST["year"];
    $dob=$year."-".$month."-".$date;
    include "filterdonars";
    $category=agecategory($dob);
    $aadhaar=$_POST["aadhaar"];
    $gender=$_POST["gender"];
    $bloodgroup=$_POST["bloodgroup"];
    $state=$_POST["state"];
    $district=$_POST["district"];
    $mandal=$_POST["mandal"];
    $password=$_POST["password"];
    $sql2="update $adminname.donar set username='$username',firstname='$firstname',lastname='$lastname',phone='$phone',email='$email',dateofbirth='$dob',aadhaar='$aadhaar',gender='$gender',bloodgroup='$bloodgroup',state='$state',district='$district',mandal='$mandal',category='$category' where username='$username' and password='$password'";
    $res2=$con2->query($sql2);
    if($res1==true && $res2==true){
       echo "updated successfully";
    } 
    else{
        echo "not updated";
    }

}
?>   