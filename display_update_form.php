<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}


if($_SESSION['role'] == "Admin" || $_SESSION['id'] == $_GET['id']) {


    # connect
    require '../database/database.php';
    $pdo = Database::connect();

    if($_POST) {

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

        $role = htmlspecialchars($role);
        $fname = htmlspecialchars($fname);
        $lname = htmlspecialchars($lname);
        $email = htmlspecialchars($email);
        $phone = htmlspecialchars($phone);
        $address = htmlspecialchars($address);
        $address2 = htmlspecialchars($address2);
        $city = htmlspecialchars($city);
        $state = htmlspecialchars($state);
        $zip_code = htmlspecialchars($zip_code);

        $passwordErr = '';


        $id = $_GET['id'];


        //Check to make sure username is not there


        $sql = "SELECT id FROM persons WHERE email =? ";
        $query=$pdo->prepare($sql);
        $query->execute(Array($email));
        $result=$query->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT email FROM persons WHERE id =? ";
        $query=$pdo->prepare($sql);
        $query->execute(Array($id));
        $result2=$query->fetch(PDO::FETCH_ASSOC);

        $email_check = $result2['email'];


        if($result != '' && ($email != $result2['email'])) {
            echo "<p> Email $email is already in use!</p><br>";
        }

        //Email check gotten from: https://www.w3schools.com/php/php_form_url_email.asp
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            echo "<p>ERROR: Email is not formatted properly </p><br>";
        }

        elseif($email == '') {
            echo "<p> Email field has been left empty!</p><br>";
        }

        else {

            $_SESSION['update_post_array'] = $_POST;

            //ERROR: Trying to pass the id like this dosnt work
            header('Location: update_record.php?id= '. $id);
        }

    }

    # put the information for the chosen record into variable $results 
    $id = $_GET['id'];
    $sql = "SELECT * FROM persons WHERE id=" . $id;
    $query=$pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();


    ?>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <style>
            form {
                padding-left: 10px;
            }
        </style>
    </head>

    <h1>Update existing record</h1>

    <form method='post' action=''>
        
        <?php 
        if ($_SESSION['role'] == "Admin") {

            ?>

            <select name="role" id="role" value='<?php echo $result['role']; ?>' required>
        
            <option value="User">User</option>
            <option value="Admin">Admin</option>
            </select> <br><br>

            <?php 

        }

        else {

            ?>
            <select name="role" id="role" value='<?php echo $result['role']; ?>' required>
        
            <option value="User">User</option>
            </select> <br><br>
            
            <?php 
        }

        ?>

        <!-- ERROR: ID Isnt being sent to poist array --> 
        ID: <input name='id' type='text' value='<?php echo $result['id']; ?>' disabled><br><br>
        First Name: <input name='fname' type='text' value='<?php if($_POST) {echo $_POST['fname'];} else {echo $result['fname'];} ?>' required><br><br>
        Last Name: <input name='lname' type='text' value='<?php if($_POST) {echo $_POST['lname'];} else {echo $result['lname'];}  ?>' required><br><br>
        Email: <input name='email' type='text' value='<?php if($_POST) {echo $_POST['email'];} else {echo $result['email'];}  ?>' required><br><br>
        Phone: <input name='phone' type='text' value='<?php if($_POST) {echo $_POST['phone'];} else {echo $result['phone'];}  ?>'><br><br>
        Address: <input name='address' type='text' value='<?php if($_POST) {echo $_POST['address'];} else {echo $result['address'];} ?>'><br><br>
        Address2: <input name='address2' type='text' value='<?php if($_POST) {echo $_POST['address2'];} else {echo $result['address2'];}  ?>'><br><br>
        City: <input name='city' type='text' value='<?php if($_POST) {echo $_POST['city'];} else {echo $result['city'];}  ?>'><br><br>
        State: <input name='state' type='text' value='<?php if($_POST) {echo $_POST['state'];} else {echo $result['state'];}  ?>'><br><br>
        Zip Code: <input name='zip_code' type='text' value='<?php if($_POST) {echo $_POST['zip_code'];} else {echo $result['zip_code'];}  ?>'><br><br>
        
        <button class="btn btn-lg btn-secondary" type="submit"
        name="submit">Submit</button>

        <a class='btn btn-lg btn-secondary' role='button' href='display_list.php'>Cancel</a>

    </form>

    <?php

}

else {
    ?>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    </head>
    <h1>ERROR: USERS CANNOT UPDATE RECORDS</h1>

    <button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
        name="list">Back to display list</button>

    <?php
}
?>
 
