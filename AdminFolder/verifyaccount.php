<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
include "../connect.php";

$username = $_POST['username1'];
$password = $_POST["password1"];

$sql2 = "SELECT username FROM admin WHERE username='$username' AND password='$password'";
$res2 = $con->query($sql2);

if ($res2) {  
    if ($res2->num_rows > 0) {
        session_start();
        $_SESSION["username"]= $username;
       $_SESSION["password"]= $password;
        $response=['redirect'=>'account.php'];
        echo json_encode($response);
    } else {
       
        echo "invalid";
    }
} else {
    echo "Error: " . $con->error;
}

$con->close();
}
?>





