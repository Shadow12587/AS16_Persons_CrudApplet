<?php
    session_start();
    
    // if login.php is called using submit button, check user input
    
    $errMsg='';


    if (isset($_POST['login'])
        && !empty($_POST['email'])
        && !empty($_POST['password'])) {
        
        echo "<script>console.log('HIT');</script>";

        $_POST['email'] = htmlspecialchars($_POST['email']);
        $_POST['password'] = htmlspecialchars($_POST['password']);

        $email = $_POST['email'];

        require '../database/database.php';
        $pdo = Database::Connect();

        $sql = "SELECT password_salt FROM persons WHERE email =? ";
        $query=$pdo->prepare($sql);
        $query->execute(Array($email));
        $result=$query->fetch(PDO::FETCH_ASSOC);

        $password_salt = $result["password_salt"];
        $password_hash = MD5($_POST['password'].$password_salt);

        $sql = "SELECT id, role, email, password_hash, password_salt FROM persons " 
        . " WHERE email =? "
        . " AND password_hash =? "
        . " AND password_salt =? "
        . " LIMIT 1";
        
        $query=$pdo->prepare($sql);


        $query->execute(Array($_POST['email'], $password_hash, $password_salt));
        $result=$query->fetch(PDO::FETCH_ASSOC);
        
        if($result) {
            $_SESSION['email'] = $result['email'];
            $_SESSION['role'] = $result['role'];
            $_SESSION['id'] = $result['id'];
            header("Location: display_list.php");
        }

        else {
            $errMsg="Login Failure: wrong username/password";
        }

    }
    
?>

<!DOCTYPE html>
<html lang="en US">
    <head>
        <title> CRUD applet with login</title>
        <meta charset ="utf-8" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    </head>
    
    <body>
        
        
        <div class="container">
            <h1>CRUD applet with login</h1>
            <h2> Login</h2>
        
            <form action="" method="post">
                <p style="color:red;"><?php echo $errMsg; ?></p>
                
                <input type="text" class="form control" 
                name="email" placeholder="admin@admin.com"
                required autofocus /> <br />
                
                <input type="password" class="form control" 
                name="password" placeholder="admin"
                required /> <br /> <br>
                
                <button class="btn btn-lg btn-primary btn-block" type="submit"
                name="login">Login</button>
                
                <button class="btn btn-lg btn-secondary btn-block" type="submit"
                onclick="window.location.href = 'register.php';";
                name="Join">Join</button> <br> <br>

                <button class="btn btn-lg btn-secondary" type="submit"
                onclick="window.location.href = 'register.php';";
                name="github">GITHUB REPO</button>
                    
            </form>
        </div>


    </body>
</html>