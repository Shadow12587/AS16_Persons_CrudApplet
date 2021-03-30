<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}


if($_SESSION['role'] == "Admin" || $_SESSION['id'] == $_GET['id']) {
    # connect
    require '../database/database.php';
    $pdo = Database::connect();

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

    <form method='post' action='update_record.php?id=<?php echo $id ?>'>
        
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
            <select name="role" id="role" value='<?php echo $result['role']; ?>' disabled>
        
            <option value="User">User</option>
            <option value="Admin">Admin</option>
            </select> <br><br>

            <?php 
        }

        ?>

        ID: <input name='id' type='text' value='<?php echo $result['id']; ?>' disabled><br><br>
        First Name: <input name='fname' type='text' value='<?php echo $result['fname']; ?>' required><br><br>
        Last Name: <input name='lname' type='text' value='<?php echo $result['lname']; ?>' required><br><br>
        Email: <input name='email' type='text' value='<?php echo $result['email']; ?>' required><br><br>
        Address: <input name='address' type='text' value='<?php echo $result['address']; ?>'><br><br>
        Address2: <input name='address2' type='text' value='<?php echo $result['address2']; ?>'><br><br>
        City: <input name='city' type='text' value='<?php echo $result['city']; ?>'><br><br>
        State: <input name='state' type='text' value='<?php echo $result['state']; ?>'><br><br>
        Zip Code: <input name='zip_code' type='text' value='<?php echo $result['zip_code']; ?>'><br><br>
        <input type="submit" value="Submit">

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
    
