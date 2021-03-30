<head>
    <meta charset ="utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>


<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}


# This process inserts a new user into mes_person table. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

# 2. assign username / password to a variable
$passwordErr = '';
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$reEnter_Password = $_POST['reEnter_Password'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$fname = htmlspecialchars($fname);
$lname = htmlspecialchars($lname);
$email = htmlspecialchars($email);
$phone = htmlspecialchars($phone);
$password = htmlspecialchars($password);
$reEnter_Password = htmlspecialchars($reEnter_Password);

$passwordErr = '';


if($_POST["password"] != $_POST["reEnter_Password"]) {
    $passwordErr = "ERROR: Password and Password Re-Entry do not Match ";
    echo "<p>ERROR: $passwordErr </p><br>";
    echo "<a href='display_create_form.php'>Back to Create</a>";
}

//If block with regex gotten from https://stackoverflow.com/questions/22544250/php-password-validation#22544286
elseif(!empty($_POST["password"]) && !empty($_POST["reEnter_Password"])) {
    
    if (strlen($_POST["password"]) <= '15') {
        $passwordErr = "Your Password Must Contain At Least 16 Characters!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='register.php'>Back to Register</a>";
    }
    
    elseif(!preg_match("#[A-Z]+#", $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='register.php'>Back to Register</a>";
    }
    elseif(!preg_match("#[a-z]+#", $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='register.php'>Back to Register</a>";
    }

    //Regex for if statement gotten from: https://stackoverflow.com/questions/13970412/php-regex-for-a-string-of-special-characters/13970853
    elseif(!preg_match('/[#$%^!&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password)) {
        $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
        echo "<p>ERROR: $passwordErr </p><br>";
        echo "<a href='register.php'>Back to Register</a>";
    }

    else {

        $address = htmlspecialchars($address);
        $address2 = htmlspecialchars($address2);
        $city = htmlspecialchars($city);
        $state = htmlspecialchars($state);
        $zip_code = htmlspecialchars($zip_code);
        
        $password_salt = MD5(microtime());
        $password_hash = MD5($password.$password_salt);
        
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
            $sql = "INSERT INTO persons (role, fname, lname, email, phone, password_hash, password_salt, address, address2, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query=$pdo->prepare($sql);
            $query->execute(Array("User", $fname, $lname, $email, $phone, $password_hash, $password_salt, $address, $address2, $city, $state, $zip_code));
            
            
            echo "<p>Your info has been added. You can now log in!</p><br>";
            echo "<a href='login.php'>Back to login</a>";
        }
    }
}

else {
     $passwordErr = "Please enter and re-enter password: ";
     echo "<p>ERROR: $passwordErr </p><br>";
     echo "<a href='register.php'>Back to Register</a>";
}