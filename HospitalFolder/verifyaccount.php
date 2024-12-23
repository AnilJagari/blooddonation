



<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username= $_POST['username1'];
    $password=$_POST["password1"];
    $flage=false;
    $sql1="select name from admin";
    $res1=$con->query($sql1);
    if($res1){
        
        while($row1=$res1->fetch_assoc()){
            $adminname=$row1["name"];
            $con2=new mysqli("localhost","root","",$adminname);
           if($con2->connect_error){
              die("conection failed".$con2->connect_error);
               } 
               else{
                $sql2="select username,password,state,district,mandal from $adminname.hospital where username='$username' and password='$password'";
                $res2=$con2->query($sql2);
                if($res2){
                    if($res2->num_rows==1){
                        $row2=$res2->fetch_assoc();
                        $flage=true;
                        session_start();
                        $_SESSION["username"]=$row2["username"];
                        $_SESSION["password"]=$row2["password"];
                        $_SESSION["state"]=$row2["state"];
                        $_SESSION["district"]=$row2["district"];
                        $_SESSION["mandal"]=$row2["mandal"];
                        $response=['redirect'=>'account.php'];
                        echo json_encode($response);  
                    }
                }else{
                    echo "Error: " . $con2->error;
                }
            }
            
                
        }
        if($flage===false){
        echo "invalid";

        }
               }
            
               else{
                echo "Error: " . $con2->error;
               }

           
   
}
?>
