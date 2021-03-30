<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

# This process updates a record. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

# 2. assign user info to a variable
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$email = htmlspecialchars($email);
$address = htmlspecialchars($address);
$address2 = htmlspecialchars($address2);
$city = htmlspecialchars($city);
$state = htmlspecialchars($state);
$zip_code = htmlspecialchars($zip_code);

$passwordErr = '';


$id = $_GET['id'];


//If block with regex gotten from https://stackoverflow.com/questions/22544250/php-password-validation#22544286
if(!empty($_POST["password"])) {
    
    $passwordErr = '';

    if (strlen($_POST["password"]) <= '15') {
        $passwordErr = "Your Password Must Contain At Least 16 Characters!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='display_update_form.php'>Back to Register</a>";
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='display_update_form.php'>Back to Register</a>";
    }
    elseif(!preg_match("#[a-z]+#",$password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='display_update_form.php'>Back to Register</a>";
    }

    
    //Regex for if statement gotten from: https://stackoverflow.com/questions/13970412/php-regex-for-a-string-of-special-characters/13970853
    elseif(!preg_match('/[#$%^!&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='register.php'>Back to Register</a>";
    }

    else {

        //Check to make sure username is not there
        $sql = "SELECT id FROM persons WHERE email =? ";
        $query=$pdo->prepare($sql);
        $query->execute(Array($email));
        $result=$query->fetch(PDO::FETCH_ASSOC);

        if($result != '' || $email == '') {
            echo "<p> Email $email is already in use or is empty!</p><br>";
            echo "<a href='register.php'>Back to Register</a>";
        }

        elseif(!preg_match('/[@.]/', $email)) {
            echo "<p>ERROR: Email is not formatted properly </p><br>";
            echo "<a href='register.php'>Back to Register</a>";
        }
        
        else{
            
            # 3. assign MySQL query code to a variable
            $sql = "UPDATE persons SET 
            fname='$fname',  
            lname='$lname',
            email='$email', 
            address='$address', 
            address2='$address2', 
            city='$city',
            state='$state', 
            zip_code='$zip_code' 
            WHERE id=$id";

            # 4. update the message in the database
            $pdo->query($sql); # execute the query
            echo "<p>Your info has been updated</p><br>";

            ?>

            <head>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
            </head>

            <button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
            name="list">Back to display list</button>
            
            <?php

        }

    }
}

else {
     $passwordErr = "Please enter password   ";
     echo "<p>ERROR: $passwordErr </p><br>";
     echo "<a href='display_update_form.php'>Back to Register</a>";
}
