<?php
session_start();
include "../connect.php";
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
        $sql2="select * from $adminname.donar where username='$username' and password='$password'";
        $res2=$con2->query($sql2); 
        if($res2){
            $row2=$res2->fetch_assoc();
            $dateandtime=$row2["lastdonationdate"];
            $dateandtime=new DateTime($dateandtime);
            $registertime =$row2["registerdate"];
            $registertime=new DateTime($registertime);
            $lasttime= clone $dateandtime;
            $currenttime=new DateTime();
            $days=$currenttime->diff($dateandtime);
            $days=$days->days;
            $currenttime=new DateTime();
            if(($lasttime==$registertime) or $days>90){
                $bloodgroup=$row2["bloodgroup"];
                $state=$row2["state"];
                $district=$row2["district"];
                $mandal=$row2["mandal"];
                $sql3="select id,name from $adminname.hospital where state='$state' and district='$district' and mandal='$mandal'";
                $res3=$con2->query($sql3);
                if($res3){
                    if($res3->num_rows>0){
                        $requirearr=array();
                        while($row3=$res3->fetch_assoc()){
                            $database2=$row3["name"];
                            $con3=new mysqli("localhost","root","",$database2);
                            if($con3->connect_error){
                               die("conection failed".$con3->connect_error);
                            }else{
                                $sql4="select min_bloodunits_required from hosp_blood_details where hid='{$row3["id"]}' and bloodgroup='$bloodgroup'";
                                $res4=$con3->query($sql4);
                                if($res4){
                                    $row4=$res4->fetch_assoc();
                                    $requirearr[$row3["id"]]=$row4["min_bloodunits_required"];
                                }else{
                                    echo "Error: " . $con3->error;
                                }
                            } 
                        }
                        arsort($requirearr);
                        $id=key($requirearr);
                        $require=current($requirearr);
                        $sql5="select name from $adminname.hospital where id='$id'";
                        $res5=$con2->query($sql5);
                        if($res5){
                            $row5=$res5->fetch_assoc();
                            $database3=$row5["name"];
                            $con4=new mysqli("localhost","root","",$database3);
                            if($con4->connect_error){
                               die("conection failed".$con4->connect_error);
                            }else{
                                 $sql7="insert into $database3.donars_info (did,name,phone,email,gender,bloodgroup,aadhaar,dateofbirth,category,state,district,mandal,dateofregister) values('{$row2["id"]}','{$row2["fullname"]}','{$row2["phone"]}','{$row2["email"]}','{$row2["gender"]}','{$row2["bloodgroup"]}','{$row2["aadhaar"]}','{$row2["dateofbirth"]}','{$row2["category"]}','{$row2["state"]}','{$row2["district"]}','{$row2["mandal"]}',NOW())";
                                 $res7=$con4->query($sql7);
                                   if($res7){
                                      $sql8="update $adminname.donar set lastdonationdate=NOW() WHERE username='$username'";
                                      $res8=$con2->query($sql8);
                                      if($res8){
                                            echo "done";
                                        }else{
                                            echo "Error: " . $con2->error;
                                        }
                                        
                                    }else{
                                        echo "Error: " . $con4->error;
                                    }
                                
                            }
                            $con4->close();
                        }else{
                            echo "Error: " . $con2->error;
                        }
                        $con3->close();
                    }else{
                        echo "no hospital in the locality "; 
                    }
                }else{
                    echo "Error: " . $con2->error;
                }
            }else{
                $lasttime=$lasttime->format("jS F Y"); 
                $diffdays=90-$days;
                $message="you are not eligible for blood donation cause your last donation done on {$lasttime} and you need to wait for {$diffdays} days for donating blood";
                echo "already done"; 
            }

        }else{
            echo "Error: " . $con2->error;
        }
    } 
    
  $con2->close();  
}else{
    echo "Error: " . $con->error; 
}
$con->close();
?>




















