<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST["login2"])){
    include "../connect.php";
    $name = $_POST['name'];
    $hid=$_POST["id"];
    $phone=$_POST["phone"];
    $email = $_POST['email'];
    $type=$_POST["type"];
    $state = $_POST['state'];
    $district= $_POST['district'];
    $mandal = $_POST['mandal'];
    $username=$_POST["username2"];
    $password=$_POST["password2"];
    $sql1="select name from admin where state='$state' and district='$district' and mandal='$mandal'";
    $res1=$con->query($sql1);
    if($res1){
        if($res1->num_rows>0){
            $rows=$res1->fetch_assoc();
            $adminname=$rows["name"];
            $con->close();
            $con2=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$adminname);
            if($con2->connect_error){
                die("conection failed".$con2->connect_error);
              } 
             else{
                $sql2="insert into $adminname.hospital(username,password,name,uniqnumb,phone,email,htype,state,district,mandal,registrationdate) values('$username','$password','$name','$hid','$phone','$email','$type','$state','$district','$mandal',NOW())";
                $res2=$con2->query($sql2);
                $sql10="update admin set no_of_hospitals=no_of_hospitals+1 ";
                $res10=$con->query($sql10);
                if($res10){
                    echo "Error: " . $con->error;
                }
                if($res3){
                header("location:account.php");
                }else{
                  echo "Error: " . $con2->error;
                }
                if ($res2) {
                    $sql3="create database $name";
                     $res3=$con2->query($sql3);
                     if($res3){
                        $con2->close();
                        $con3=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$mysqldatabase);
                       if($con->connect_error){
                            die("conection failed".$con3->connect_error);
                        }else{
                            $sql4="create table $name.donar_patient( 
                                id int(11)  auto_increment primary key,
                                did  int(11),
                                donarname varchar(200),
                                patientname varchar(200),
                                patientphone varchar(20),
                                bloodgroup varchar(50),
                                amounttodonar varchar(50),
                                amountbydonar varchar(50),
                                foreign key(did) references $adminname.donar(id))";
                            $res4=$con3->query($sql4); 
                            if ($res4) {
                                $sql5="create table $name.donars_info( 
                                    slno int(11) default 1,
                                    did  int(11),
                                    name varchar(200),
                                    phone varchar(20),
                                    email varchar(20),
                                    gender varchar(20),
                                    bloodgroup varchar(50),
                                    aadhaar varchar(20),
                                    dateofbirth date,
                                    category varchar(3),
                                    state varchar(50),
                                    district varchar(50),
                                    mandal varchar(50),
                                    dateofregister DATETIME,
                                    foreign key(did) references $adminname.donar(id))";
                                $res5=$con3->query($sql5); 
                                if ($res5) {
                                    $sql6="create table $name.patients_info( 
                                        id int(11)  auto_increment primary key,
                                        firstname varchar(200),
                                        lastname varchar(200),
                                        phone varchar(20),
                                        email varchar(50),
                                        aadhaar varchar(20),
                                        gender varchar(20),
                                        bloodgroup varchar(50),
                                        state varchar(50),
                                        district varchar(50),
                                        mandal varchar(50))"; 
                                   $res6=$con3->query($sql6); 
                                   if ($res6) {
                                    
                                    $sql7="create table $name.hosp_blood_details( 
                                        hid varchar(11) default {$rows["id"]},
                                        bloodgroup varchar(100) primary key,
                                        bloodunits_used_previous_month int(11) default 0,
                                        total_bloodunits_required int(11)  default 0,
                                        min_bloodunits_required int(11) default 0,
                                        bloodunits_remain int(11)  default 0), 
                                        foreign key(hid) references $adminname.hospital(id))"; 
                                    $res7=$con3->query($sql7); 
                                    if ($res7) {
                                        $sql8="insert into $name.hosp_blood_details(bloodgroup)
                                           values ('A+'),('A-'),('B+'),('B-'),('AB+'),('AB-'),('O+'),('O-'),('OAB+'),('OAB-')";
                                        $res8=$con3->query($sql8);
                                        if ($res8) {
                                            $sql9="create table $name.hosp_donars_info( 
                                                id int(11) auto_increment primary key,
                                                did int(11),
                                                name varchar(225),
                                                phone varchar(50),
                                                email varchar(255),
                                                aadhaar varchar(10),
                                                gender varchar(50),
                                                bloodgroup varchar(50),
                                                dateofbirth date,
                                                category varchar(3),
                                                state varchar(255),
                                                district varchar(255),
                                                mandal varchar(255),
                                                datetime datetime,
                                                foreign key(did) references $adminname.donar(id))";
                                            $res9=$con3->query($sql9);
                                            if ($res9) {
                                                if($con || $con2 || $con3){
                                                    $con->close();
                                                    $con2->close();
                                                    $con3->close();
                                                }
                                                session_start();
                                                $_SESSION["username"]=$username;
                                                $_SESSION["password"]=$password;
                                                $_SESSION["state"]=$state;
                                                $_SESSION["district"]=$district;
                                                $_SESSION["mandal"]=$mandal;
                                                header("location:account.php");
                                                exit();
                                          } else {
                                              // Query failed
                                              echo "Error: " . $con3->error;
                                          }         
                                      } else {
                                          // Query failed
                                          echo "Error: " . $con3->error;
                                      }             
                                  } else {
                                      // Query failed
                                      echo "Error: " . $con3->error;
                                  }             
                              } else {
                                  // Query failed
                                  echo "Error: " . $con3->error;
                              }             
                              } else {
                                  // Query failed
                                  echo "Error: " . $con3->error;
                              }          
                          } else {
                              // Query failed
                              echo "Error: " . $con3->error;
                          }             
                        } 
                     } else{
                        // Query failed
                         echo "Error: " . $con2->error;
                     }
              } else {
                  // Query failed
                  echo "Error: " . $con2->error;
              }                 
             } 

    }else{
        $message="You dinn't have  corresponding admin in your locality";
        if($con || $con2){
            $con->close();
            $con->close();

        }
        header("location:home.php?fmessage=$message");
        exit();
    }
}else{
    echo "Error: " . $con->error;
}
}
}
?>
