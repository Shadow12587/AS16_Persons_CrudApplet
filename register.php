<?php
session_start();

if($_POST) {
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
        $passwordErr = "Password and Password Re-Entry do not Match ";
        echo "<p>ERROR: $passwordErr </p><br>";
        $_POST["password"] = '';
        $_POST["reEnter_Password"] = '';

    }

    //If block with regex gotten from https://stackoverflow.com/questions/22544250/php-password-validation#22544286
    elseif(!empty($_POST["password"]) && !empty($_POST["reEnter_Password"])) {
        
        if (strlen($_POST["password"]) <= '15') {
            $passwordErr = "Your Password Must Contain At Least 16 Characters!";
            echo "<p>ERROR: $passwordErr </p><br>";
            $_POST["password"] = '';
            $_POST["reEnter_Password"] = '';

        }
        
        elseif(!preg_match("#[A-Z]+#", $password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            echo "<p>ERROR: $passwordErr </p><br>";
            $_POST["password"] = '';
            $_POST["reEnter_Password"] = '';

        }
        elseif(!preg_match("#[a-z]+#", $password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            echo "<p>ERROR: $passwordErr </p><br>";
            $_POST["password"] = '';
            $_POST["reEnter_Password"] = '';

        }

        //Regex for if statement gotten from: https://stackoverflow.com/questions/13970412/php-regex-for-a-string-of-special-characters/13970853
        elseif(!preg_match('/[#$%^!&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Special Character!";
            echo "<p>ERROR: $passwordErr </p><br>";
            $_POST["password"] = '';
            $_POST["reEnter_Password"] = '';

        }

        else {

            require '../database/database.php';
            $pdo = Database::connect();

            $address = htmlspecialchars($address);
            $address2 = htmlspecialchars($address2);
            $city = htmlspecialchars($city);
            $state = htmlspecialchars($state);
            $zip_code = htmlspecialchars($zip_code);
            
            //Check to make sure username is not there
            $sql = "SELECT id FROM persons WHERE email =? ";
            $query=$pdo->prepare($sql);
            $query->execute(Array($email));
            $result=$query->fetch(PDO::FETCH_ASSOC);
            
            if($result != '' || $email == '') {
                echo "<p> Email $email is already in use or is empty!</p><br>";

            }
            
            //Email check gotten from: https://www.w3schools.com/php/php_form_url_email.asp
            elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p>ERROR: Email is not formatted properly </p><br>";
                $_POST["email"] = '';
                $_POST["password"] = '';
                $_POST["reEnter_Password"] = '';

            }
            
            else{
                $_SESSION['register_post_array'] = $_POST;
                header('Location: register_new_user.php');
            }


        }
    }

    else {

        $passwordErr = "Please enter and re-enter password: ";
        echo "<p>ERROR: $passwordErr </p><br>";
        $_POST["password"] = '';
        $_POST["reEnter_Password"] = '';
    }

}

?>

<head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
        <style>
            form {
                padding-left: 10px;
            }
        </style>
    </head>
    
<h1>Register new user</h1>
<form method='post' action='' name = 'register_form'>

    First Name: <input name='fname' type='text' value = '<?php if($_POST) {echo $_POST['fname'];} ?>' required><br />
    Last Name: <input name='lname' type='text' value = '<?php if($_POST) {echo $_POST['lname'];} ?>' required><br />
    Email: <input name='email' type='text' value = '<?php if($_POST) {echo $_POST['email'];} ?>' required><br />
    Phone: <input name='phone' type='text' value = '<?php if($_POST) {echo $_POST['phone'];} ?>' ><br />
    Password: <input name='password' type='password' value = '<?php if($_POST) {echo $_POST['password'];} ?>' required><br />
    Re-Enter Password: <input name='reEnter_Password' type='password' value = '<?php if($_POST) {echo $_POST['reEnter_Password'];} ?>' required><br />
    Address: <input name='address' type='text' value = '<?php if($_POST) {echo $_POST['address'];} ?>' ><br />
    Address2: <input name='address2' type='text' value = '<?php if($_POST) {echo $_POST['address2'];} ?>' ><br />
    City: <input name='city' type='text' value = '<?php if($_POST) {echo $_POST['city'];} ?>' ><br />
    State: <input name='state' type='text' value = '<?php if($_POST) {echo $_POST['state'];} ?>' ><br />
    Zip Code: <input name='zip_code' type='text' value = '<?php if($_POST) {echo $_POST['zip_code'];} ?>' ><br /><br> 

    <button class="btn btn-lg btn-secondary" type="submit"
    name="submit">Submit</button>

    <a class='btn btn-lg btn-secondary' role='button' href='login.php'>Cancel</a>

</form>
