<?php
if(isset($_POST["login2"])){
    include "../connect.php";
    $firstname = $_POST['firstname'];
    $lastname= $_POST['lastname'];
    $name=$lastname." ".$firstname;
    $phone=$_POST["phone"];
    $email = $_POST['email'];
    $aadhaar = $_POST['aadhaar'];
    $gender = $_POST['gender'];
    $bloodgroup = isset($_POST['bloodgroup']) ? $_POST['bloodgroup'] : '';
    $date = $_POST['date'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $dateofbirth=$year."-".$month."-".$date;
    $dob=$dateofbirth;
    $state_id= $_POST['state'];
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
    include ("filterdonars.php");
    $category=agecategory($dob);
    $sql1="select name from admin where state='$state' and district='$district' and mandal='$mandal'";
    $res1=$con->query($sql1);
    if ($res1) {
      if($res1->num_rows>0){
        $rows=$res1->fetch_assoc();
        $adminname=$rows["name"];
        $con2=new mysqli("localhost","root","",$adminname);
        if($con2->connect_error){
           die("conection failed".$con2->connect_error);
        }else{
          $sql2="insert into $adminname.donar (username,password,fullname,phone,email,dateofbirth,aadhaar,gender,bloodgroup,state,district,mandal,category,registerdate,lastdonationdate) values('$username','$password','$name','$phone','$email','$dob','$aadhaar','$gender','$bloodgroup','$state','$district','$mandal','$category',NOW(),NOW())";
          $res2=$con2->query($sql2);
          if($res2){
            $sql3="update admin set no_of_donars=no_of_donars+1 where name='$adminname'";
            $res3=$con->query($sql3);
            if($res3){
              $con->close();
              $con2->close();
              session_start();  
                      $_SESSION["username"]=$username;
                      $_SESSION["password"]=$password;
                      $_SESSION["state"]=$state;
                      $_SESSION["district"]=$district;
                      $_SESSION["mandal"]=$mandal;
              header("location:account.php");
              exit();
            }else{
              echo "Error: " . $con2->error;
            }
          }else{
            echo "Error: " . $con2->error;
          }
        
        }
      }else{
        $message="You dinn't have  corresponding Admin in your locality";
        $encodemessage=urlencode($message);
              if($con){
                  $con->close();
              }
              header("location:home.php?message=$encodemessage");
              exit();
      }            

    }else{
      echo "Error: " . $con->error;
    }
    
}
?>
