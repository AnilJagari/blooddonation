<?php
if(isset($_POST["login2"])) {
    include "../connect.php";
    $name = $_POST["name"];
    $phone=$_POST["phone"];
    $email = $_POST["email"];
    $state_id = $_POST["state"];
    $district_id= $_POST['district'];
    $mandal_id= $_POST['mandal'];
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
    $username=$_POST["username2"];
    $password=$_POST["password2"];
    $sql1="select name from admin where state='$state' and  district='$district' and mandal='$mandal' ";
    $res1=$con->query($sql1);
    if($res1){
    if($res1->num_rows>0){
        $row1=$res1->fetch_assoc();
        $adminname=$row1["name"];
        $con->close();
        $message="Already an admin account $adminname existed in your locality";
        $encodemessage=urlencode($message);
        header("location:home.php?message=$encodemessage");   
    }
    else{
    $sql2="insert into admin (name,username,password,phone,email,state,district,mandal,registrationdate) values('$name','$username','$password','$phone','$email','$state','$district','$mandal',NOW())";
    $res2=$con->query($sql2);  
    if ($res2) {
        $sql3="create database $name";
        $res3=$con->query($sql3);
        if ($res3) {
            $con2=new mysqli("localhost","root","",$name);
            if($con2->connect_error){
                die("conection failed".$con2->connect_error);
              }else{
                $sql4="create table $name.donar( 
                    id int(11) auto_increment primary key,
                    username  varchar(255),
                    password  varchar(255),
                    fullname varchar(255),
                    phone varchar(100),
                    email varchar(255),
                    gender varchar(50),
                    bloodgroup varchar(100),
                    aadhaar varchar(20),
                    dateofbirth date,
                    category varchar(10),
                    state varchar(255),
                    district varchar(255),
                    mandal varchar(255),
                    registerdate DATETIME,
                    lastdonationdate DATETIME)";
                    $res4=$con2->query($sql4);
                    if ($res1) {
                        $sql5="create table $name.hospital( 
                            id int(11) auto_increment primary key,
                            username  varchar(200),
                            password  varchar(200),
                            name varchar(200),
                            uniqnumb varchar(200),
                            phone varchar(20),
                            email varchar(255),
                            htype varchar(100),
                            state varchar(255),
                            district varchar(255),
                            mandal varchar(255),
                            registrationdate DATETIME)";
                            $res5=$con2->query($sql5);
                            if ($res5) {
                                $sql6="create table $name.hospital_donar( 
                                    count int(11) auto_increment primary key,
                                    hid int(11),
                                    hname varchar(225),
                                    did int(11),
                                    dname varchar(225),
                                    hstate varchar(255),
                                    hdistrict varchar(255),
                                    hmandal varchar(255),
                                    dateofdone DATETIME)";
                                   $res6=$con2->query($sql6);
                                   if ($res6) {
                                    session_start();
                                    if($con || $con2){
                                        $con->close();
                                        $con2->close();
                                    }
                                    $_SESSION["username"]= $username;
                                    $_SESSION["password"]= $password;
                                      header("location:account.php");
                                } else {
                                    // Query failed
                                    echo "Error: " . $con2->error;
                                }                                 
                            } else {
                                // Query failed
                                echo "Error: " . $con2->error;
                            }

                    } else {
                        // Query failed
                        echo "Error: " . $con2->error;
                    }
              } 
        } else {
            // Query failed
            echo "Error: " . $con->error;
        }
    } else {
        // Query failed
        echo "Error: " . $con->error;
    }
    
}
    }else {
        // Query failed
        echo "Error: " . $con->error;
    }
}
?>
