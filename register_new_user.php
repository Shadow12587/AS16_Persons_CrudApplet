<?php
session_start();

# This process inserts a new user into mes_person table. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

$_POST = $_SESSION['register_post_array'];

# 2. assign username / password to a variable
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

$password_salt = MD5(microtime());
$password_hash = MD5($password.$password_salt);


# 3. assign MySQL query code to a variable
$sql = "INSERT INTO persons (role, fname, lname, email, phone, password_hash, password_salt, address, address2, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$query=$pdo->prepare($sql);
$query->execute(Array("User", $fname, $lname, $email, $phone, $password_hash, $password_salt, $address, $address2, $city, $state, $zip_code));


echo "<p>Your info has been added. You can now log in!</p><br>";

?>

<head>
    <meta charset ="utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<button class="btn btn-lg btn-primary" onclick="window.location.href = 'login.php'"
name="list">Back to display list</button>
