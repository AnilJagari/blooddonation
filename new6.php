<?php
 include ("connectaddress.php");
 $sql1="select id,name from state";
 $res1=$con->query($sql1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State, District, and Mandal Dropdowns</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Select Location</h2>
        <form>
            <div class="form-group">
                <label for="stateDropdown">State</label>
                <select class="form-control" id="stateDropdown">
                    <option value="" selected disabled>Select State</option>
                    <?php 
                   
                    if($res1){
          while($st=$res1->fetch_assoc()){
            ?>
            <option value="<?php echo $st["id"];?>"><?php echo $st["name"];?></option>
            <?php }
            }
            $con->close();?>
 
                </select>
            </div>
            <div class="form-group">
                <label for="districtDropdown">District</label>
                <select class="form-control" id="districtDropdown" disabled>
                    <option value="" selected disabled>Select District</option>
                    <!-- District options will be dynamically populated based on selected state -->
                </select>
            </div>
            <div class="form-group">
                <label for="mandalDropdown">Mandal</label>
                <select class="form-control" id="mandalDropdown" disabled>
                    <option value="" selected disabled>Select Mandal</option>
                    <!-- Mandal options will be dynamically populated based on selected district -->
                </select>
            </div>
        </form>
    </div>
<script>
     document.addEventListener('DOMContentLoaded', function () {
            const stateDropdown = document.getElementById('stateDropdown');
            const districtDropdown = document.getElementById('districtDropdown');
            const mandalDropdown = document.getElementById('mandalDropdown');

            stateDropdown.addEventListener('change', function () {
                const stateId = this.value;
                if (stateId) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'fetch_district.php', true);
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
                    xhr.open('POST', 'fetch_mandal.php', true);
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
</body>
</html>










 