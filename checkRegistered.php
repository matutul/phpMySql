<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "course";

    $student= "";
    $selected_id = 0;


    $conn = new mysqli($server, $username, $password, $dbname);
    if($conn->connect_error){
        die("Database connection failed: ".$conn->connect_error);
    }
     $sql = "SELECT * FROM slot";
     $result = $conn->query($sql);
     if($result->num_rows > 0){
         while($row = $result->fetch_assoc()){
            $slot_id[] = $row['slot_id'];
            $slot[] = $row['slot'];
         }
     }

    // search operation
    $lid = $lec_name = "";
    $available_seat = 0; 
     if(isset($_POST['search']) && $_POST['search']!=""){
        $selected_id = $_POST['slot_id'];
        $sql2 = "SELECT * FROM lecturer WHERE lid = (SELECT lid FROM slot WHERE slot_id = '$selected_id')";
        $rslt = $conn->query($sql2);
        if($rslt = $rslt->fetch_assoc()){
            $lid = $rslt['lid'];
            $lec_name = $rslt['lec_name'];
        }
        $sql2 = "SELECT * FROM student WHERE slot_id = '$selected_id'";
        $rslt = $conn->query($sql2);
        
        while($rslt2 = $rslt->fetch_assoc()){
            if($student == ""){
                $student = "<tr><td>".$rslt2['sid']."</td><td>".$rslt2['fname']." ".$rslt2['lname']."</td></tr>";
            }else{
                $student .= "<tr><td>".$rslt2['sid']."</td><td>".$rslt2['fname']." ".$rslt2['lname']."</td></tr>";
            }
            // $sid[] = $rslt['sid'];
            // $sname[] = $rslt['fname']." ".$rslt['lname'];
        }
        $sql2 = "SELECT * FROM slot WHERE slot_id = '$selected_id'";
        $rslt = $conn->query($sql2);
        if($rslt = $rslt->fetch_assoc()){
            $available_seat = 8-$rslt['snum'];
        }
     }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="checkRegistered.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/f23aed0610.js" crossorigin="anonymous"></script>
    <title>Check Registered Student</title>
</head>
<body>
    <div class="container">        
        <div class="main-content">
            <div class="search">
                <table class="chart">
                    <tr>
                        <th>Slot id</th>
                        <th>Slot name</th>
                    </tr>
                    <tr>
                        <td><?php echo $slot_id[0];?></td>
                        <td><?php echo $slot[0];?></td>
                    </tr>
                    <tr>
                        <td><?php echo $slot_id[1];?></td>
                        <td><?php echo $slot[1];?></td>
                    </tr>
                    <tr>
                        <td><?php echo $slot_id[2];?></td>
                        <td><?php echo $slot[2];?></td>
                    </tr>
                    <tr>
                        <td><?php echo $slot_id[3];?></td>
                        <td><?php echo $slot[3];?></td>
                    </tr>
                </table>
                <div class="search-input">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
                        <select name="slot_id">
                            <option value="">Slot id: </option>
                            <option value="<?php echo $slot_id[0];?>"><?php echo $slot_id[0];?></option>
                            <option value="<?php echo $slot_id[1];?>"><?php echo $slot_id[1];?></option>
                            <option value="<?php echo $slot_id[2];?>"><?php echo $slot_id[2];?></option>
                            <option value="<?php echo $slot_id[3];?>"><?php echo $slot_id[3];?></option>
                        </select>
                        <input type="submit" name="search" value="Search">
                    </form>
                </div>
            </div>
            <div class="output">
                <div class="lecturer">
                    <p><?php echo $lid;?><br><?php echo $lec_name;?></p><br>
                    <p>Slot id: <?php echo $selected_id;?></p><br>
                    <p>Available seat: <?php echo $available_seat;?></p>
                </div>
                <div class="student">
                    <table>
                        <tr>
                            <th>Student id</th>
                            <th>Student name</th>
                        </tr>
                        <?php echo $student;?>
                    </table>
                </div>            
            </div>
        </div>
    </div>

    <div class="help">
        <i id="helpbtn" class="fas fa-question-circle"></i>
    </div>
</body>
</html>