<?php
session_start();
include "../connect.php";
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
    $sql2="select name,uniqnumb,htype,phone,email,state,district,mandal from hospital where username='$username' and password='$password'";
    $res2=$con2->query($sql2);
    if($res2){
      $row=$res2->fetch_assoc();
      $name=$row["name"];
      $fname=$name." "."Hospital";
      $uniqnumb=$row["uniqnumb"];
      $htype=$row["htype"];
      $phone=$row["phone"];
      $email=$row["email"];
      $state=$row["state"];
      $district=$row["district"];
      $mandal=$row["mandal"];
      $con3=new mysqli("localhost","root","",$name);
      if($con3->connect_error){
        die("conection failed".$con3->connect_error);
      }else{
        $sql3="select count(*) as pend_donars from $name.donars_info";
        $res3=$con3->query($sql3);
        if($res3){
          $row2=$res3->fetch_assoc();
          if($row2["pend_donars"]>0){
            $pend=$row2["pend_donars"];
            $value="foreground";
            }else{
              $value="none";
              $pend="";
            }
            $pending_donars=$row2["pend_donars"];
            $sql4="select count(*) as active_donars from $name.hosp_donars_info";
            $res4=$con3->query($sql4);
            if($res4){
              $row3=$res4->fetch_assoc();
              $active_donars=$row3["active_donars"];
            }else{
              echo "Error: " . $con3->error;
            }

        }else{
          echo "Error: " . $con3->error;
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Account Page</title>
    <link rel="stylesheet" href="../bootstrap.css">
    <style>
      *{
        padding:0px;
        margin: 0px;
      }
      .nav-item{
        padding-left:10px;
        padding-right:10px;
      }
      .dropbtn {
        height:37px;
        width:37px;
  border: none;
  cursor: pointer;
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: center; 
  
  
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: auto;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
      
    .menu{
      height:3px;
      width:20px;
  background-color:black;
  border:none;
  margin-top:5px;
  padding:0px;
      }
     #div1{
      border:none;
position: relative; /* Create a positioned parent */
margin-top:5px;
border:none;
}
#imageli{
  margin-left:550px;
}
#menuiconli{
  margin-left:50px;
  display:flex;
  flex-direction:row;
  justify-content: center;
  align-items: center;
}

#divformenu{
  margin-left:80px;
}
#foreground {
    position: absolute;
    border:none;
    background-color:red;
    height:26px;
    width:26px;
    padding:2px;
    font-size:20px;
    color:red;
    left: 0.8em;
    border-radius:50%;
    font-size:20px;
    font-weight:650;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color:white;
    z-index: 2; /* Higher value */
}
.sup1{
        font-size:20px;
        
      }
  section{
    height:800px;
  }    
     

    </style>
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">BloodPlaza</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Policy</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link active" aria-current="page" href="#">Permissions</a>
        </li>
        <li class="nav-item" >
          <a class="nav-link active" aria-current="page" href="#">contact Us</a>
        </li>

        <li class="nav-item" id="imageli">
         <div class="image-container" id="div1" style="cursor:pointer;" onclick="f1()">
          
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSP2OYovI7d3jd4BFwLlxeILt2tkubJmWXwMQ&s" class="img-thumbnail" alt="..." style="height:30px;"><sup class="sup1" id="<?php echo $value;?>"><?php echo $pend; ?></sup>
          </div>
      </li>

      <li class="nav-item" id="menuiconli">
      
      <div class="dropdown" id="divformenu"> 
  <div id="menuicon" onclick="myFunction()" class="dropbtn">
<div class="menu"></div>
<div class="menu" ></div>
<div class="menu"></div>
</div>
  <div id="myDropdown" class="dropdown-content">
    <a href="update.php">Update</a>
    <a href="logout.php">Logout</a>
    <a href="delete.php">Delete Account</a>
  </div>
</div>
        </li>
       
      </ul>
    </div>
  </div>
</nav>

<section class="w-100 px-4 py-5" style="background-color: #9de2ff;">
  <div class="row d-flex justify-content-center">
    <div class="col col-md-9 col-lg-7 col-xl-6">
      <div class="card" style="border-radius: 15px;">
        <div class="card-body p-4">
          <div class="d-flex">
            <div class="flex-grow-1 ms-3">
              <h5 class="mb-1"><?php echo $fname; ?></h5>
              <p class="mb-2 pb-1"><?php echo $htype; ?></p>
              
              <div class="media">
                      <label><b>Address</b></label>
                  <p><b>State : </b><?php echo $state;?>, <b>District :</b> <?php echo $district;?>, <b>Mandal :</b> <?php echo $mandal;?></p>
                    </div>
                    <div>
                    <div class="media">
                      <label><b>Phone</b></label>
                  <p><?php echo $phone;?></p>
                    </div>  
                    <div>
                    <div class="media">
                      <label><b>E-Mail</b></label>
                  <p><?php echo $email;?></p>
                    </div>     
               
                                    
                  <div class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary">
                <div>
                  <p class="small text-muted mb-1">Active Donars</p>
                  <p class="mb-0"><?php echo $active_donars;?></p>
                </div>
                <div class="px-3">
                  <p class="small text-muted mb-1">Pending Donars</p>
                  <p class="mb-0"><?php echo $pending_donars;?></p>
                </div>
                <div class="px-3">
                  <p class="small text-muted mb-1">Donations</p>
                  <p class="mb-0">0</p>
                </div>
                <div>
                  <p class="small text-muted mb-1">Patients</p>
                  <p class="mb-0">0</p>
                </div>
              </div>                      
              
              <div class="d-flex pt-1">
              <a href="contactdonar.php"  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger me-1 flex-grow-1" id="request">Contact Donars</a>
                <a href="blooddetails.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-success me-1 flex-grow-1">Hosp Blood Details</a>
                <a href="requesttodonar.php" type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary  flex-grow-1">Request</a>
              </div>
              <div class="d-flex pt-1">
              <p class="small text-muted mb-1 me-5 flex-grow-1" id="paraforrequest">Click To Contact Donars</p>
              <p class="small text-muted mb-1 me-4 flex-grow-1" id="paraforrequest">Click To Get Hosp Blood Details</p>
              <p class="small text-muted mb-1 flex-grow-1">Request to donars</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="bg-dark text-white pt-3 bottom" >
  <div class="container">
    <div class="row">
      <!-- About Section -->
      <div class="col-md-4">
        <h5>About Us</h5>
        <p class="small">Nothing</p>
      </div>
      
      <!-- Navigation Links -->
      <div class="col-md-4">
        <h5>Contact Us Through Social Media</h5>
        <ul class="list-unstyled" class="ful">
          <li class="flist"> <a href="https://www.facebook.com/aniljagari/" target="_blank" class="text-white"><i class="fab fa-facebook-f">facebook</i></a></li>
          <li class="flist">  <a href="https://www.twitter.com/aniljagari/" target="_blank" class="text-white mr-3"><i class="fab fa-twitter">Twitter</i></a></li>
          <li class="flist">  <a href="https://www.instagram.com/aniljagari/" target="_blank" class="text-white"><i class="fab fa-instagram">Instagram</i></a></li>
          
          
        </ul>
      </div>
      
      <!-- Contact Section -->
      <div class="col-md-4">
        <h5>Contact Us</h5>
        <ul class="list-unstyled" class="ful">
          <li class="flist"><i class="fas fa-map-marker-alt"></i>UCET,Nalgonda</li>
          <li class="flist"><i class="fas fa-phone"></i> 6300565735</li>
          <li class="flist"><i class="fas fa-envelope"></i>project@gmail.com</li>
         
        </ul>
      </div>
  </div>
  </div>
  <div class="bg-dark text-center py-4">
    <small>&copy;2024 Blood Donation Management System. All Rights Reserved.</small>
    </div>

</footer>


<script>
  function f1(){
    window.location.href="response.php";
  }
   
   function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}


   window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
    
</body>
</html>