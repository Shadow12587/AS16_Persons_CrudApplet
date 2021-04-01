<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

?>


<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<?php


# This process updates a record. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

$_POST = $_SESSION['update_post_array'];

# 2. assign user info to a variable
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

$id = $_GET['id'];


# 3. assign MySQL query code to a variable
$sql = "UPDATE persons SET 
role='$role',
fname='$fname',  
lname='$lname',
email='$email', 
phone ='$phone',
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

<button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
name="list">Back to display list</button>
