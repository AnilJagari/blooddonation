<?php
session_start();
include "../connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
  $sql2="select name,phone,email,state,district,mandal,no_of_donars,no_of_hospitals from admin where username='$username' and password='$password'";
    $res2=$con->query($sql2);
    if($res2){
      $row=$res2->fetch_assoc();
      $name=$row["name"];
      $phone=$row["phone"];
      $email=$row["email"];
      $state=$row["state"];
      $district=$row["district"];
      $mandal=$row["mandal"];
      $no_of_donars=$row["no_of_donars"];
      $no_of_hospitals=$row["no_of_hospitals"];
      $con2=new mysqli("localhost","root","",$name);
      if($con2->connect_error){
        die("conection failed".$con2->connect_error);
      }else{
         $sql3="select count(*) as donations from $name.hospital_donar";
         $res3=$con2->query($sql3);
         if($res3){
           $row3=$res3->fetch_assoc();
           $no_of_donations=$row3["donations"];
      }else{
        echo "Error: " . $con2->error;
      }
      } 
      if($con2){
        $con2->close();
      }
      
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
    <title>Admin Account Page</title>
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
    <a class="navbar-brand" href="#">BlooddPlaza</a>
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
          
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrN2ghgs96YHEHS6SaFjDOYLn9sT24cpBtIw&s" class="img-thumbnail" alt="..." style="height:30px;"><sup class="sup1" id=""></sup>
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
    <a href="#about">Logout</a>
    <a href="#contact">Delete Account</a>
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
      <div class="card" style="border-radius: 20px;">
        <div class="card-body p-4">
          <div class="d-flex">
           
            <div class="flex-grow-1 ms-3">
              <h4 class="mb-1"><?php echo $name; ?></h4>
               <br>
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
                  <p class="small text-muted mb-1">No Of Hospitals</p>
                  <p class="mb-0"><?php echo $no_of_hospitals; ?></p>
                </div>
                <div class="px-3">
                  <p class="small text-muted mb-1">No Of Donars</p>
                  <p class="mb-0"><?php echo $no_of_donars; ?></p>
                </div>
                
                <div class="px-3">
                  <p class="small text-muted mb-1">Total Donations</p>
                  <p class="mb-0"><?php echo $no_of_donations; ?></p>
                </div>
               
              </div>
              <div class="d-flex pt-1">
              <a href="hospitals_info.php"  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger me-1 flex-grow-1" >Hospitals Info</a>
              <a href="donars_info.php"  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary me-1 flex-grow-1">Donars Info</a>
              <a href="hosp_donar_info.php"  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-success  flex-grow-1">Hosp-Donars Info</a>     
              </div>
              </div>
              
              <div class="d-flex pt-1">
              <p class="small text-muted mb-1 me-5 flex-grow-1" id="paraforrequest">Click To Get Hospitals Info</p>
              <p class="small text-muted mb-1 me-5 flex-grow-1">Click To Get Donars Info</p>
              <p class="small text-muted mb-1 flex-grow-1">Click To Get Hosp-Donars Info</p>
              </div>
              <center>
              <div class="pt-4">
              <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger me-1 flex-grow-1" id="update">Update Donations</button>
              </div>
              
              <div class="d-flex pt-1">
              <p class="small text-muted mb-1 flex-grow-1" id='message'>Click To update Donations</p>
              </div>
              </center>
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
   document.querySelector("#update").addEventListener("click", () => {
    // Get references to elements
    var messageElement = document.querySelector("#message");
    var updateButton = document.querySelector("#update");

    // Clear the message before making a request
    messageElement.innerText = "";

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure it: POST request to resetdonations2.php
    xhr.open('POST', 'resetdonations2.php', true);

    // Define the onload handler
    xhr.onload = function () {
        if (xhr.status === 200) {
            var responseText = xhr.responseText.trim(); // Trim to avoid extra whitespace

            // Handle responses based on returned value
            switch (responseText) {
                case "done":
                    messageElement.innerText = "Updated successfully.";
                    updateButton.disabled = true; // Disable the button
                    break;

                case "no donars":
                    messageElement.innerText = "No donors to update.";
                    updateButton.disabled = true; // Disable the button
                    break;

                default:
                    messageElement.innerText = "Not updated. Server response: " + responseText;
                    updateButton.disabled = true; // Disable the button
                    break;
            }
        } else {
            // Display an error message if the status is not 200
            console.error("Error: " + xhr.statusText);
            messageElement.innerText = "Error: Unable to process the request.";
        }
    };

    // Define the onerror handler for network errors
    xhr.onerror = function () {
        console.error("Request failed.");
        messageElement.innerText = "Request failed. Please check your network connection.";
    };

    // Send the POST request
    xhr.send();
});

   
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