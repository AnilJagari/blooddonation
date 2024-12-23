<?php
include "../connect.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username=$_POST["uname"];
    

    $sql1="select name from admin";
    $res1=$con->query($sql1);
    while($row1=$res1->fetch_assoc()){
        $adminname=$row1["name"];
        $con2=new mysqli($mysqlhostname,$mysqlusername,$mysqlpassword,$adminname);
        $sql2="select username from $adminname.donar where username='$username'";
        $res2=$con->query($sql2);  
        if($res2->num_rows>0){
            $con->close();
            $con2->close();
            echo "exist";
            break;
        }
    }
    echo "not exist";
}
?>   