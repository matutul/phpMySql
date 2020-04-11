<?php
session_start();
// $_SESSION['slotChange'] = 0;

// if($_SESSION['slotChange']==1){
    
// }

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

// Making Available slot option
$sql = "SELECT * FROM slot WHERE snum<8";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    if($options==""){
        $options = "<option value=".$row['sl_no'].">".$row['slot']."</option>";
    }else{
        $options .= "<option value=".$row['sl_no'].">".$row['slot']."</option>";
    }
}
if($options == ""){
    $options = "<option disabled>There is no slot available.</option>";    
}

// after click on submit button 
if(isset($_POST['submit_btn'])){
    // validating form data
    $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
    $lname = insert_test($_POST['lname']);
    $sid = insert_test($_POST['sid']);
    $email = insert_test($_POST['email']);
    $slot = intval($_POST['slot_option']);
    
    // checking whether the student is registered already
    $sql = "SELECT * FROM student WHERE sid = '$sid'";
    $result = $conn->query($sql);
    if(!$result->fetch_assoc()){
        $sql = "SELECT * FROM slot where sl_no = $slot";
        $snum = $conn->query($sql);
        $snum = $snum->fetch_assoc();
        $snum_result = $snum['snum'];
        $sl_id = $snum['slot_id'];
        $snum_result++;
    
        $sql1 = "UPDATE slot SET snum = $snum_result WHERE sl_no = $slot";
        $conn->query($sql1);
        $sql2 = $conn->prepare("INSERT INTO student (sl, sid, fname, lname, email, slot_id)
                VALUES ('NULL', ?, ?, ?, ?, ?)");
        $sql2->bind_param("sssss",$sid, $fname, $lname, $email, $sl_id);
        $sql2->execute();
        $sql2->close();
        
        echo "<script>alert('Hello, Mr. " .$fname." ".$lname.". Your registration is successfully completed..!');</script>";
    }else{
        $_SESSION['student_id']=$sid;
        echo "<script src='confirm.js'></script>";
    }
}

// validation function
function insert_test($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- for FONTAWSOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/f23aed0610.js" crossorigin="anonymous"></script>
    <title>Registration process</title>
</head>
<body>
    <div class="registration">
        <form action="index.php" method="POST">  
            <h3>Register for course in a perticular slot:</h3>          
            <p class="just">
                <lebel>First Name: </lebel>
                <input type="text" name="fname" required>                
            </p>
            <p class="just">
                <lebel>Last Name: </lebel>
                <input type="text" name="lname" required>                
            </p>
            <p class="just">
                <lebel>Student ID: </lebel>
                <input type="text" name="sid" required>                
            </p>
            <p class="just">
                <lebel>Email ID: </lebel>
                <input type="email" name="email" required>                
            </p>

            <select name="slot_option" class="slottime" required>
                <option value="">Select your slot:</option>
                <?php echo $options;?>
            </select>
            <input type="submit" name="submit_btn" value="Click here to register">
        </form>
    </div>

    <div class="help">
        <i id="helpbtn" class="fas fa-question-circle"></i>
    </div>
</body>
</html>