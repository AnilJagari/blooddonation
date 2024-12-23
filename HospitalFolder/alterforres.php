<?php
session_start();
if(isset($_POST["response"])){
    include "../connect.php";
    $idsarr=$_POST["slno"];
    if ($idsarr==null){
        header("location:account.php");
    }
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
        $sql2="select id,name from hospital where username='$username' and password='$password'";
        $res2=$con2->query($sql2);
        if($res2){
            $row2=$res2->fetch_assoc();
            $hospname=$row2["name"];
            $con3=new mysqli("localhost","root","",$hospname);
            if($con3->connect_error){
               die("conection failed".$con3->connect_error);
            }else{
                foreach($idsarr as $donarid){
                    $sql4="select * from $hospname.donars_info where did='$donarid'";
                    $res4=$con3->query($sql4);
                    if($res4) {
                        $row4=$res4->fetch_assoc();
                        $sql5="insert into $hospname.hosp_donars_info(did,name,phone,email,aadhaar,gender,bloodgroup,dateofbirth,category,state,district,mandal,datetime) values('{$row4["did"]}','{$row4["name"]}','{$row4["phone"]}','{$row4["email"]}','{$row4["aadhaar"]}','{$row4["gender"]}','{$row4["bloodgroup"]}','{$row4["dateofbirth"]}','{$row4["category"]}','{$row4["state"]}','{$row4["district"]}','{$row4["mandal"]}',NOW())";
                        $bloodgroup=$row4["bloodgroup"];
                        $res5=$con3->query($sql5);
                        if($res5){
                            $sql6="update $hospname.hosp_blood_details set bloodunits_remain=bloodunits_remain+1,min_bloodunits_required=min_bloodunits_required-1 where bloodgroup='$bloodgroup'";
                            $res6=$con3->query($sql6);
                            if($res6){
                                $sql7="update $adminname.donar set lastdonationdate=NOW() where id='$donarid'";
                                $res7=$con2->query($sql7); 
                                if($res7){
                                    $sql8="insert into $adminname.hospital_donar (hid,hname,did,dname,hstate,hdistrict,hmandal,dateofdone) values('{$row2["id"]}','{$row2["name"]}','{$row4["did"]}','{$row4["name"]}','$state','$district','$mandal',NOW())";
                                    $res8=$con2->query($sql8);
                                    if($res8){
                                        $sql9="delete from $hospname.donars_info where did='$donarid'";
                                        $res9=$con3->query($sql9);
                                        if($res9){
                                            header("location:account.php");
                                        }else{
                                            echo "Error: " . $con3->error;  
                                        }
                                    }else{
                                        echo "Error: " . $con2->error;   
                                    }
                                }else{
                                    echo "Error: " . $con2->error; 
                                }
                            }else{
                                echo "Error: " . $con3->error;
                            }
                        }else{
                            echo "Error: " . $con3->error;
                        }
                    } else{
                        echo "Error: " . $con3->error;
                    }
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