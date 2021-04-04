<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

# This process inserts a new user into mes_person table. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

$_POST = $_SESSION['create_post_array'];

# 2. assign username / password to a variable
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
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


echo "<p>User info has been added. They can now log in!</p><br>";

?>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
name="list">Back to display list</button>
