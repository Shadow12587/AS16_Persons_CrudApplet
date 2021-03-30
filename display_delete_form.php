<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
}

if($_SESSION['role'] == "Admin") {
    ?>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    </head>

    <h1> Are you sure you want to delete this record? </h1>

    <?php

    # connect
    require '../database/database.php';
    $pdo = Database::connect();

    # put the information for the chosen record into variable $results
    $id = $_GET['id'];
    $sql = "SELECT * FROM persons WHERE id=" . $id;
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetch();

    ?>
    <form method='post' action='delete_record.php?id=<?php echo $id ?>'>
        First Name: <input name='fname' type='text' value='<?php echo $result['fname']; ?>' disabled><br /><br />
        Last Name: <input name='lname' type='text' value='<?php echo $result['lname']; ?>' disabled><br /><br />
        <input type="submit" name="Yes" value="Yes" />
        <a href="display_list.php"><input type="button" value="No"></a>
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
    <h1>ERROR: USERS CANNOT DELETE RECORDS</h1>

    <button class="btn btn-lg btn-primary" onclick="window.location.href = 'display_list.php'"
        name="list">Back to display list</button>

    <?php
}
?>
