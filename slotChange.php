<?php
session_start();

$server = "localhost";
$username = "root";
$password = "";
$dbname = "course";
$options="";

// database connection
$conn = new mysqli($server, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

if(!isset($_SESSION['student_id'])){
    echo "<script>alert('Some error occurred....!');window.location = 'index.php';</script>";
    die("Error occured...!");    
}

// retrieve other data corresponding to the student id
$sid = $_SESSION['student_id'];

$sql = "SELECT * FROM student WHERE sid = '$sid'";
$result = $conn->query($sql);
if($row = $result->fetch_assoc()){
    $fname = $row["fname"];
    $lname = $row["lname"];
    $email = $row["email"];
}else{
    echo "<script>alert('Some error occurred....!');window.location = 'index.php';</script>";
}



// Making Available slot option
$sql = "SELECT * FROM slot WHERE snum<8 && slot_id != (SELECT slot_id FROM student WHERE sid = '$sid')";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    if($options==""){
        $options = "<option value=".$row['slot_id'].">".$row['slot']."</option>";
    }else{
        $options .= "<option value=".$row['slot_id'].">".$row['slot']."</option>";
    }
}
if($options == ""){
    $options = "<option disabled>There is no slot available.</option>";    
}

// MAIN TASK ==================================>>>>>>>>>>>>>>>>>>>>
// updating work after clicking submit_btn (update button)
if(isset($_POST['submit_btn'])){
    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
// sanitizing and validating email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
// sanitizing and validating slot option value (int)
    $slot_id = filter_var($_POST['slot_option'], FILTER_SANITIZE_NUMBER_INT);
    $slot_id = filter_var($slot_id, FILTER_VALIDATE_INT);

    $sql = "UPDATE student SET fname = '$fname', lname = '$lname', email = '$email', slot_id = '$slot_id' WHERE sid = '$sid'";
    $conn->query($sql);
    $conn->close();

// POPUP CONGRATULATION DIALOGUE BOX AND RETURN TO INDEX.PHP FILE (HOME PAGE)
    echo "<script>alert('Hello, Mr. " .$fname." ".$lname.". Your new slot and information are updated..!'); window.location = 'index.php';</script>"; 
// echo "<script src='congrats.js'></script>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- pop up congratulation dialogue box (It is not working here) -->
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/f23aed0610.js" crossorigin="anonymous"></script>
    <title>Edit Information</title>
</head>
<body>
    <div class="registration">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">  
            <h3>Register for course in a perticular slot:</h3>          
            <p class="just">
                <lebel>First Name: </lebel>
                <input type="text" name="fname" value="<?php echo $fname;?>" required>                
            </p>
            <p class="just">
                <lebel>Last Name: </lebel>
                <input type="text" name="lname" value="<?php echo $lname;?>" required>                
            </p>
            <p class="just">
                <lebel>Student ID: </lebel>
                <input type="text" name="sid" value="<?php echo $sid;?>" required disabled>                
            </p>
            <p class="just">
                <lebel>Email ID: </lebel>
                <input type="email" name="email" value="<?php echo $email;?>" required>                
            </p>

            <select name="slot_option" class="slottime" required>
                <option value="">Select your slot:</option>
                <?php echo $options;?>
            </select>
            <input type="submit" name="submit_btn" value="Update">
        </form>
    </div>
    
    <div class="help">
        <i id="helpbtn" class="fas fa-question-circle"></i>
    </div>
</body>
</html>