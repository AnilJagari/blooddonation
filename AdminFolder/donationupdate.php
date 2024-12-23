<?php
include "../connect.php";
date_default_timezone_set('Asia/Kolkata');
$adminname=$_SESSION["name"];
$con2=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$adminname);
$sql1="select id,name from $adminname.hospital";
$res1=$con2->query($sql1);
if($res1->num_rows>0){
    $requirearr=array();
   while($row1=$res1->fetch_assoc()){
      $hospname=$row1["name"];
      $con3=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$hospname);
      $currentDateTime = date('Y-m-d H:i:s');
      $sql2 = " SELECT id FROM $hospname.donars_info WHERE TIMESTAMPDIFF(MINUTE, event_time, '$currentDateTime') > 10";
      $res2=$con3->query($sql2);
      $row2=$res2->fetch_assoc();
      $sql3 = "delete  $hospname.donars_info WHERE TIMESTAMPDIFF(MINUTE, event_time, '$currentDateTime') > 10";
      $res3=$con3->query($sql3);

      $sql4="select min_bloodunits_required from hosp_blood_details where hid='{$row1["id"]}'";
      $res4=$con3->query($sql4);
      $row4=$res4->fetch_assoc();
      
      $requirearr[$row1["id"]]=$row4["min_bloodunits_required"];
      $con3->close();  
     }
  arsort($requirearr);
  $id=key($requirearr);
  $require=current($requirearr);
  echo $id;
  echo $require;
  exit();
  $sql5="select name from hospital where id='$id'";
  $res5=$con->query($sql5);
  $row5=$res5->fetch_assoc();
  $database3=$row5["name"];
  $con4=new mysqli("localhost","root","",$database3);
  $sql6="select slno from donars_info order by slno desc limit 1";
  $res6=$con4->query($sql6);
  if($res6->num_rows>0){
  $row6=$res6->fetch_assoc();
        $sql7="insert into donars_info (slno,did,name,phone,email,gender,bloodgroup,aadhaar,dateofbirth,category,state,district,mandal,dateofregister) values('{$row7["slno"]}'+1,'{$row1["id"]}','{$row1["fullname"]}','{$row1["phone"]}','{$row1["email"]}','{$row1["gender"]}','{$row1["bloodgroup"]}','{$row1["aadhaar"]}','{$row1["dateofbirth"]}','{$row1["category"]}','{$row1["state"]}','{$row1["district"]}','{$row1["mandal"]}',NOW())";
    }
  else{
       $sql7="insert into donars_info (slno,did,name,phone,email,gender,bloodgroup,aadhaar,dateofbirth,category,state,district,mandal,dateofregister) values(1,'{$row1["id"]}','{$row1["fullname"]}','{$row1["phone"]}','{$row1["email"]}','{$row1["gender"]}','{$row1["bloodgroup"]}','{$row1["aadhaar"]}','{$row1["dateofbirth"]}','{$row1["category"]}','{$row1["state"]}','{$row1["district"]}','{$row1["mandal"]}',NOW())";
     }
     $res7=$con4->query($sql7);
    $message="your Request has been successfully sent, wait for hospital response";
     echo $message;
     }
   
else{
    echo "there is no hospital is registered with in this admin account";
}

?>