<?php
session_start();
include "../connect.php";
$username=$_SESSION["username"];
$password=$_SESSION["password"];
$sql1="select * from admin where username='$username' and password='$password'";
$res1=$con->query($sql1);
if($res1){
    $row=$res1->fetch_assoc();
    $name=$row["name"];
    $con2=new mysqli("localhost","root","",$name);
      if($con2->connect_error){
        die("conection failed".$con2->connect_error);
      }else{
        $name=$row["name"];
        $phone=$row["phone"];
        $email=$row["email"];
        $state=$row["state"];
        $district=$row["district"];
        $mandal=$row["mandal"];
        $username=$row["username"];
        $password=$row["password"];
      }
    }else{
        echo "Error: " . $con2->error;
    }
$con->close();
?>
<!DOCTYPE html>
<html>
  <head><title>update donar info</title>
  <link rel="stylesheet" href="../bootstrap.css">
</head>
    <body>


    <section class="bg-light py-3 py-md-5"  id="section2" >
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <div class="card border border-light-subtle rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4 p-xl-5"> 
          <div class="text-center mb-3">
          <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Enter Your Details </h2>
          </div>
         <?php echo "<form id='updatedonarinfo'>"; ?>
            <div class="row gy-2 overflow-hidden">
             
              
              <div class="col-12">
                <div class="form-floating mb-3">
                   <input class="form-control" name="phone" id="phone"  placeholder="phone" value="<?php echo $phone;?>" >
                   <label for="phone" class="form-label">Phone</label>
                    <b><span class="badge bg-danger" id="phoneerror"></span></b>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" name="email" id="email"  placeholder="email" value="<?php echo $email;?>">
                    <label for="email" class="form-label">Email</label>
                    <b><span class="badge bg-danger" id="emailerror"></span></b>
                  </div>
                </div>
   
<!-- drop down-->
<div class="container mt-3">  
   <select class="form-select" aria-label="Default select example" id="stateDropdown" name="state">
  <option value="" selected disabled>select your state</option>
  <?php 
include ("../connectaddress.php");
$sql2="select id,name from state";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($state==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        ?>   
         
    
  </select>
  <b><span class="badge bg-danger" id="stateerror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="districtDropdown" name="district">
  <option value="" selected disabled>select your district</option>
  <?php 
$sql2="select id,name from district";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($district==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        ?>   
  

  </select>
  <b><span class="badge bg-danger" id="districterror"></span></b>
</div> 
<div class="container mt-3"> 
   <select class="form-select" aria-label="Default select example"  id="mandalDropdown" name="mandal" >
  <option value="" selected disabled>select your mandal</option>
  <?php 
$sql2="select id,name from mandal";
$res2=$con->query($sql2);
if($res1){
    while($st=$res2->fetch_assoc()){
        if($mandal==$st["name"]){  ?>
            <option value="<?php echo $st["id"];?>" selected><?php echo $st["name"];?></option> 
      <?php  }else{ ?>
        <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
       <?php }?>
        <?php 
        }
        }else{
         echo "error :".$con->error;
        }
        $con->close();?>   
  
  </select>
  <b><span class="badge bg-danger" id="mandalerror"></span></b>
</div> 

<div class="d-flex pt-5">
              <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger me-1 flex-grow-1" id="cancel">Cancel</button>
                <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary flex-grow-1" id="update">Update</button>
              </div>


</div><?php echo "</form>"; ?>
   
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    </body>
<script>
   function test_input(data){
        function stripslashes(str){
          return str.replace(/\\/g,'');
        }
        data=data.trim();
        data=stripslashes(data);
        return data;
       }
       document.querySelector("#cancel").addEventListener("click", ()=> {
        window.location.href="account.php";
       });

    document.querySelector("#update").addEventListener("click", ()=> {
        let flag=true;
        let phoneerr=document.querySelector("#phoneerror");
        let emailerr=document.querySelector("#emailerror");
        let stateerr=document.querySelector("#stateerror");
        let districterr=document.querySelector("#districterror");
        let mandalerr=document.querySelector("#mandalerror");
        phoneerr.innerText="";
        emailerr.innerText="";
        stateerr.innerText="";
        districterr.innerText="";
        mandalerr.innerText="";
        var phone=test_input(document.querySelector("#phone").value);
        var email=test_input(document.querySelector("#email").value);
        var st=document.querySelector("#stateDropdown");
        if(st.value=="select your state"){
          stateerr.innerText="state not selected";
          flag=false;
        }
        var dist=document.querySelector("#districtDropdown");
        if(dist.value=="select your district"){
          districterr.innerText="district not selected";
          flag=false;
        }   
        var mdl=document.querySelector("#mandalDropdown");
        if(mdl.value=="select your mandal"){
          mandalerr.innerText="mandal not selected";
          flag=false;
        }                  
        const phoneregex=/^\d{10}$/;
        const emailregex= /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        
        if(phone===""){
          phoneerr.innerText="phone shouldn't empty";
          flag=false;
        }
        else if(!phoneregex.test(phone)){
          phoneerr.innerText="invalid phone number";
          flag=false;
        }
        if(email===""){
          emailerr.innerText="email shouldn't empty";
          flag=false;
        } 
        else if(!emailregex.test(email)){
          emailerr.innerText="invalid email";
          flag=false;
        }
        if(flag){
          var formData = new FormData(document.querySelector('#updatedonarinfo'));
          var xhr = new XMLHttpRequest();
          xhr.open('POST', 'updateinsertdb.php', true);
          xhr.onload = function() {
          if (xhr.status === 200) {
        if(xhr.responseText=="updated successfully") {
            window.location.href="account.php";
         }
         else{
            window.location.href="account.php";
         }
        } else {
            // Handle error
            console.error('Error: ' + xhr.statusText);
        }
    };
    xhr.send(formData); 
        }
      });

      document.addEventListener('DOMContentLoaded', function () {
            const stateDropdown = document.getElementById('stateDropdown');
            const districtDropdown = document.getElementById('districtDropdown');
            const mandalDropdown = document.getElementById('mandalDropdown');

            stateDropdown.addEventListener('change', function () {
                const stateId = this.value;
                if (stateId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../fetch_district.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            districtDropdown.innerHTML = xhr.responseText;
                            districtDropdown.disabled = false;
                            mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                            mandalDropdown.disabled = true;
                        } else {
                            console.error('Error: ' + xhr.statusText);
                        }
                    };
                    xhr.send('state_id=' + encodeURIComponent(stateId));
                } else {
                    districtDropdown.innerHTML = '<option value="" selected disabled>Select District</option>';
                    districtDropdown.disabled = true;
                    mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                    mandalDropdown.disabled = true;
                }
            });

            districtDropdown.addEventListener('change', function () {
                const districtId = this.value;
                if (districtId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '../fetch_mandal.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            mandalDropdown.innerHTML = xhr.responseText;
                            mandalDropdown.disabled = false;
                        } else {
                            console.error('Error: ' + xhr.statusText);
                        }
                    };
                    xhr.send('district_id=' + encodeURIComponent(districtId));
                } else {
                    mandalDropdown.innerHTML = '<option value="" selected disabled>Select Mandal</option>';
                    mandalDropdown.disabled = true;
                }
            });
        });


          </script>



</html>