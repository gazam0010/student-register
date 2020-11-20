<?php $search_param = ""; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Register</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            footer {
                text-align: center;
                background-color: whitesmoke;
                padding: 3%;
                width: 100%;
                bottom: 0;
            }
            .header-nav {
                position: fixed;
                width: 100%;
                top: 0;
            }
            .form-content {
                padding-top: 5%;
                padding-right: 5%;
                padding-left: 5%;
                padding-bottom: 5%;
                margin-left: 13%;
                margin-right: 13%;
                margin-top: 15%;
                margin-bottom: 6%;
            }
            .strict-filter {
                padding-left: 8%;
                color: lightslategrey;
                text-size: 5px;
            }
            .reset-button {
                margin-left: 43%;
            }
            input[type="text"] {
                width: 100%;
            }
            .bb {
                margin-top: -43.7px;
                margin-left: 88%;
            }
            #students {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #students td, #students th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #students tr:nth-child(odd){background-color: white;}

            #students tr:hover {background-color: #ddd;}
            #students th {
                padding-top: 12px;
                padding-bottom: 12px;
                background-color: orange;
                color: white;
            }

        </style>
    </head>
    <body>
        <div class="header-nav">
            <div class="w3-container w3-light-blue">
                <h1 align='center'>Student's Register</h1>
            </div>
            <div class="w3-contianer">
                <div class="w3-bar w3-border w3-light-grey w3-large w3-card-4">
                    <a href="index.php" class="w3-bar-item w3-button">Home</a>
                    <a href="enrol.php" class="w3-bar-item w3-button">Enter Students Details</a>
                    <a href="#" class="w3-bar-item w3-button w3-red">Search</a>
                </div>
            </div>
        </div>
        <div class="form-content w3-card-4 w3-light-grey">
            <form action="" method="post">
                <p align="center"><font size="2" color="lightslategrey">Enter anything to search globally or you may use Strict Filter.</font></p>
                <input type="text" class="w3-input w3-border w3-round-large w3-large" name="search_param" value="<?php echo $search_param; ?>" placeholder="Enter required element to search" required>
                <div class="bb">
                    <button class="w3-button w3-round-large w3-large" type="submit" name="search">Search</button>
                </div>
                <p align="center"><font size="2" color="lightslategrey"><a href="#" onclick="useStrictFilter()">Use Strict Filter<a/></font></p>
                <div id="strict-filter" style="display:none">
                    <div class="strict-filter">
                        <font size="2px">
                        <input type="radio" name="strict_filter" value="first_name" id="1"> <label for="1">First Name</label>
                        &nbsp;<input type="radio" name="strict_filter" value="last_name" id="2"> <label for="2">Last Name</label>
                        &nbsp;<input type="radio" name="strict_filter" value="enrl_no" id="3"> <label for="3">Enrollment Number</label>
                        &nbsp;<input type="radio" name="strict_filter" value="fac_no" id="4"> <label for="4">Faculty Number</label>
                        &nbsp;<input type="radio" name="strict_filter" value="main_sub" id="5"> <label for="5">Main Subject</label>
                        &nbsp;<input type="radio" name="strict_filter" value="district" id="6"> <label for="6">District</label>
                        &nbsp;<input type="radio" name="strict_filter" value="state" id="7"> <label for="7">State</label></font>
                        <br>
                        <span class="reset-button"><button class="w3-button w3-border" type="reset"><i class="fa fa-refresh"></i></button></span>
                    </div>
                </div>
            </form>
            <br><br>
            
            
            
            <?php
            $db = mysqli_connect('localhost', 'root', '', 'student');


            if (isset($_POST['search'])) {
                $strict_filter = "";
                $search_param = mysqli_real_escape_string($db, $_POST['search_param']);
                if (isset($_POST['strict_filter'])) {
                    $strict_filter = mysqli_real_escape_string($db, $_POST['strict_filter']);
                }
                if ($strict_filter == 'last_name') {
                    $user_check_query = "SELECT * FROM details WHERE last_name='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'first_name') {
                    $user_check_query = "SELECT * FROM details WHERE first_name='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'enrl_no') {
                    $user_check_query = "SELECT * FROM details WHERE enrl='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'fac_no') {
                    $user_check_query = "SELECT * FROM details WHERE fac='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'main_sub') {
                    $user_check_query = "SELECT * FROM details WHERE main_sub='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'district') {
                    $user_check_query = "SELECT * FROM details WHERE district='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } elseif ($strict_filter == 'state') {
                    $user_check_query = "SELECT * FROM details WHERE state='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                } else {

                    $user_check_query = "SELECT * FROM details WHERE first_name='$search_param' OR last_name='$search_param' OR full_name='$search_param'
            OR enrl='$search_param' OR fac='$search_param' OR main_sub='$search_param' OR address='$search_param'
            OR district='$search_param' OR state='$search_param' OR pin='$search_param'";
                    $result = mysqli_query($db, $user_check_query);
                }

                if ($result->num_rows > 0) {

                    echo '<table border="1px" id="students">
                    <tr>
                        <th>Enrol. No.</th>
                        <th>Name</th>
                        <th>Faculty No.</th>
                        <th>Main Subject</th>
                        <th>H.No / Street</th>
                        <th>District</th>
                        <th>State</th>
                        <th>PIN</th>
                    </tr>';

                    while ($row = $result->fetch_assoc()) {

                        echo "<tr>";
                        echo "<td>";
                        echo "<strong>" . $row['enrl'] . "</strong>";
                        echo "</td>";
                        echo "<td>";
                        echo $row['full_name'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['fac'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['main_sub'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['address'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['district'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['state'];
                        echo "</td>";
                        echo "<td>";
                        echo $row['pin'];
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p align='center'><font color='red'>No result found!</font><br><br><font size='2px'>Try different category of Strict Filter</font></p>";
                }
            }
            ?>
            </table>
        </div>

        <footer>
            Designed and Developed by Gulfarogh Azam
        </footer>
    </body>
    <script>
        function useStrictFilter() {
            var x = document.getElementById('strict-filter');
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</html>
