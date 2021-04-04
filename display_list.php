<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

?>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<h1>Users List</h1>

<h2>Signed in as: <?php echo $_SESSION['email']?> </h2>
<h2>Role: <?php echo $_SESSION['role']?> </h2>

<body>
	<button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_create_form.php'"
	name="create">Create</button>

	<button class="btn btn-lg btn-primary" onclick="window.location.href = 'logout.php'"
	name="logout">Logout</button> <br> <br>

</body>

<?php 
# connect
require '../database/database.php';
$pdo = Database::connect();

# display all records
$sql = "SELECT id, fname, lname FROM persons";
foreach ($pdo->query($sql) as $row) {
	$str = "";
    $str .= ' (' . $row['id'] . ') ' . $row['fname']. " ". $row['lname']. " ";
	$str .= "<a href='display_read_form.php?id=" . $row['id'] . "'>Read</a> ";
	$str .= "<a href='display_update_form.php?id=" . $row['id'] . "'>Update</a> ";
	$str .= "<a href='display_delete_form.php?id=" . $row['id'] . "'>Delete</a> ";
	$str .=  '<br>';
	echo $str;
}
echo '<br />';
?>

