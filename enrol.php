<?php
$first_name = "";
$last_name = "";
$enrl_no = "";
$fac_no = "";
$main_sub = "";
$address = "";
$district = "";
$state = "";
$pin = "";
$errors = array();
$success = array();

$db = mysqli_connect('localhost','root', '', 'student');

if(isset($_POST['save_details'])) {
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $enrl_no = mysqli_real_escape_string($db, $_POST['enrl']);
    $fac_no = mysqli_real_escape_string($db, $_POST['fac']);
    $main_sub = mysqli_real_escape_string($db, $_POST['main_sub']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $district = mysqli_real_escape_string($db, $_POST['district']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $pin = mysqli_real_escape_string($db, $_POST['pin']);
    
    if (empty($first_name)) {
        array_push($errors, 'First Name cannot be left blank');
    }
    if (empty($last_name)) {
        array_push($errors, 'Last Name cannot be left blank');
    }
    
    //ENROLLMENT NUMBER VALIDATION
    if (empty($enrl_no)) {
        array_push($errors, 'Enrollment Number cannot be left blank');
    } else if (strlen($enrl_no) < 6){
        array_push($errors, "Enrollment number should be six digits E.g. AA1234");
    } else {
        $enrollment_char = substr($enrl_no, 0, -4);
        $enrollment_num = substr($enrl_no, 2);
        
        if(is_numeric($enrollment_char) || !is_numeric($enrollment_num)) {
        array_push($errors, "Enter enrollment number in proper format E.g. AA1234");
        }
    }
    
    if (empty($fac_no)) {
        array_push($errors, 'Faculty Number cannot be left blank');
    }
    if (empty($main_sub)) {
        array_push($errors, 'Main Subject cannot be left blank');
    }
    if (empty($address)) {
        array_push($errors, 'Address Line 1 cannot be left blank');
    }
    if (empty($district)) {
        array_push($errors, 'District cannot be left blank');
    }
    if (empty($state)) {
        array_push($errors, 'State cannot be left blank');
    }
    if (empty($pin)) {
        array_push($errors, 'PIN Code cannot be left blank');
    }
    $user_check_query = "SELECT * FROM details WHERE enrl='$enrl_no' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if($user) {
        if($user['enrl'] == $enrl_no) {
            array_push($errors, 'Enrolment Number already registered');
        }
        if($user['fac'] == $fac_no) {
            array_push($errors, 'Faculty Number already registered');
        }
    }
    if(count($errors) == 0) {
        $full_name = $first_name." ".$last_name;
        $store = "INSERT INTO details (first_name, last_name, full_name, enrl, fac, main_sub, address, district, state, pin) 
                      VALUES ('$first_name', '$last_name', '$full_name', '$enrl_no', '$fac_no', '$main_sub', '$address', '$district', '$state', '$pin')";
        $result = mysqli_query($db, $store);
        
        if($result) {
            array_push($success, 'Your Data Has Been Successfully Stored!');
        } else {
            echo 'Some Error Occured, please try after some time!';
        }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Register</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
            footer {
                text-align: center;
                background-color: smokewhite;
                padding: 3%;
                width: 100%;
                bottom: 0;
            }
            .form-content {
                padding-top: 2%;
                padding-right: 5%;
                padding-left: 5%;
                padding-bottom: 5%;
                padding-bottom: 7%;
                margin-left: 13%;
                margin-right: 13%;
                margin-top: 15%;
                margin-bottom: 6%;
            }
            .header-nav {
                position: fixed;
                width: 100%;
                top: 0;
            }
            .msg {
                width: 17%;
                position: fixed;
                right: 0;
            }
            .msg-container {
                padding: 4%;
                border-radius: 10px;
            }
            .closebtn {
                margin-left: 15px;
                color: white;
                font-weight: bold;
                float: right;
                font-size: 22px;
                line-height: 20px;
                cursor: pointer;
                transition: 0.3s;
            }

            .closebtn:hover {
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="header-nav">
            <div class="w3-container w3-light-blue w3-position">
                <h1 align='center'>Student's Register</h1>
            </div>

            <div class="w3-contianer">
                <div class="w3-bar w3-border w3-light-grey w3-large w3-card">
                    <a href="index.php" class="w3-bar-item w3-button">Home</a>
                    <a href="#" class="w3-bar-item w3-button w3-red">Enter Students Details</a>
                    <a href="search.php" class="w3-bar-item w3-button">Search</a>
                </div>
            </div>
            <br>
         <?php include('alert.php'); ?>
        </div>
        <div class="form-content w3-card-4 w3-light-grey">
            <h2 align="left">Enter Your Details</h2>
            <hr class="w3-grey">
            <form method="post" action="">
                <div id="part1">
                    <font color="red" size="2"> <p align="left" id="empty_part1"></p></font>
                <p>
                    <label>Full Name: </label><br>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" id="first_name"  type="text" name="first_name" placeholder="First Name" required>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" id="last_name"  type="text" name="last_name" placeholder="Last Name" required>
                </p>
                <p>
                    <label>Enrollment Number: </label>
                    <input class="w3-input w3-border w3-round-large" maxlength="6"  type="text" name="enrl" id="enrl" onblur="return constValidate()" placeholder="AA1111" onkeyup="this.value = this.value.toUpperCase();" required>
                <p id="error-enrl"></p>
                </p>
                <p>
                    <label>Faculty Number: </label>
                    <input class="w3-input w3-border w3-round-large" id="fac"  type="text" maxlength="9" name="fac" id="fac" placeholder="18CAB000" onkeyup="this.value = this.value.toUpperCase();" required>
                <p id="error-fac"></p>
                </p>
                <p>
                    <label>Main Subject: </label>
                    <input class="w3-input w3-border w3-round-large" id="main_sub" type="text" name="main_sub" id="main_sub" placeholder="Computer Science" required>
                </p>
                
                   <p align="right"><button class="w3-button w3-blue" onclick="return displayNext()">Next -></button></p>
                </div>
                
                <div id="part2">
                    <p align="right"><button class="w3-button w3-blue" onclick="displayBack()"><- Back</button></p>
                <p>
                    <label>Address: </label><br>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" type='text' name='address' id="address" " placeholder=" Line 1" required>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" type='text' name='district' id="district" placeholder=" District" required><br><br>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" type='text' name='state' id="state" placeholder=" State" required>
                    <input class="w3-border w3-round-large w3-large" style="width:49%; height:41px;" type='text' maxlength="6" id="pin" name='pin' placeholder=" PIN Code" required>
                </p>
                <p>
                    <button type="submit" name="save_details" onclick="return confirmSubmit();" class="w3-button w3-black w3-left w3-large">Save</button>
                    <button type="reset" class="w3-button w3-black w3-right w3-large">Reset</button>
                </p>
                </div>
            </form>
        </div>
        <footer class="w3-card-4">
            Designed and Developed by Gulfarogh Azam
        </footer>
        <script>
                function constValidate() {
                 var str = document.getElementById("enrl").value;
                 var st = str.charAt(0);
                 var st1 = str.charAt(1);
                 var st2 = str.charAt(2);
                 var st3 = str.charAt(3);
                 var st4 = str.charAt(4);
                 var st5 = str.charAt(5);
                 if(!isNaN(st) || !isNaN(st1)) {
                     document.getElementById("error-enrl").innerHTML = "<font size='2' color='red'>Please enter in proper format. E.g. AA1234</font>";
                     return false;
                 } else if(isNaN(st2) || isNaN(st3) || isNaN(st4) || isNaN(st5)) {
                     document.getElementById("error-enrl").innerHTML = "<font size='2' color='red'>Please enter in proper format. E.g. AA1234</font>";
                     return false;
                 } else if(str.length < 6) {
                     document.getElementById("error-enrl").innerHTML = "<font size='2' color='red'>Enrollment number should be six digits. E.g. AA1234</font>";
                     return false;
                 }  else {
                     document.getElementById("error-enrl").innerHTML = "";
                     return true;
                 }
            }
        </script>

    <script>
     var x = document.getElementById('part2');
     x.style.display = "none";
     </script>
     <script>
     function displayNext() {
        var x = document.getElementById('part1');
        var y = document.getElementById('part2');
        var a = document.getElementById('first_name').value;
        var aa = document.getElementById('last_name').value;
        var b = document.getElementById('enrl').value;
        var c = document.getElementById('fac').value;
        var d = document.getElementById('main_sub').value;
       if( a === "" || aa === "" || b === "" || c === "" || d === ""){
           document.getElementById("empty_part1").innerHTML = "*Please fill out every field";
           return false;
       } 
           x.style.display = "none";
           y.style.display = "block";
           document.getElementById("empty_part1").innerHTML = "";
           return true;
     }
    </script>
     <script>
     function displayBack() {
        var x = document.getElementById('part1');
        var y = document.getElementById('part2');
           x.style.display = "block";
           y.style.display = "none";
     }
    </script>
    <script>
        function confirmSubmit() {
         var a = document.getElementById('first_name').value;
         var aa = document.getElementById('last_name').value;
         var b = document.getElementById('enrl').value;
         var c = document.getElementById('fac').value;
         var d = document.getElementById('main_sub').value;
         var e = document.getElementById('address').value;
         var f = document.getElementById('district').value;
         var g = document.getElementById('state').value;
         var h = document.getElementById('pin').value;
         
            if(confirm("Please Verify Details: \nName: " + a + " " + aa +"\nEnrl. No.: " + b + "\nFaculty No.: " + c 
                    + "\nMain Sub.: " + d + "\nAddress\nLine 1: " + e + "\nDistrict: " + f + "\nState: " + g + "\nPIN Code: " + h)){
                return true;
            } 
            return false;
        }
    </script>
    </body>
</html>
