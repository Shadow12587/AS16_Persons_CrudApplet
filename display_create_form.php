<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}

if($_SESSION['role'] == "Admin") {
    ?>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <style>
            form {
                padding-left: 10px;
            }
        </style>
    </head>

    <h1>Create New User</h1>

    <form method='post' action='insert_record.php'>
    <select name="role" id="role">
        <option value="User">User</option>
        <option value="Admin">Admin</option>
    </select> <br>

    
        First Name: <input name='fname' type='text' required ><br />
        Last Name: <input name='lname' type='text' required ><br />
        Email: <input name='email' type='text' required ><br />
        Phone: <input name='phone' type='text' ><br />
        Password: <input name='password' type='password' required ><br />
        Address: <input name='address' type='text' ><br />
        Address2: <input name='address2' type='text' ><br />
        City: <input name='city' type='text' ><br />
        State: <input name='state' type='text' ><br />
        Zip Code: <input name='zip_code' type='text' ><br />
    
        <input type="submit" value="Submit">

    </form>

    <?php
}

else {
    ?>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <style>
            form {
                padding-left: 10px;
            }
        </style>
    </head>
    <h1>ERROR: USERS CANNOT CREATE RECORDS</h1>

    <button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
        name="list">Back to display list</button>

    <?php
}
?>
