<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

# This process deletes a record. There is no display.

# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();

# 2. assign user info to a variable
$id = $_GET['id'];

# 3. assign MySQL query code to a variable
$sql = "DELETE FROM persons WHERE id=$id";

# 4. update the message in the database
$pdo->query($sql); # execute the query

?>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<h1>Record has been deleted</h1><br>

<button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
	name="list">Back to display list</button>
