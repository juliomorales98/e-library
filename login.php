<?php
session_start();
if($_SESSION["loggedin"] === true){
    header("location:index.php");
    exit;
}
require("./config.php");

$username = $password = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if($stmt = mysqli_prepare($link,$sql)){
        mysqli_stmt_bind_param($stmt,"s",$param_username);
        $param_username = $username;

        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt,$id,$username,$hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password,$hashed_password)){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username; 
                        header("location:index.php");
                    }
                    else{
                        //header("location:login.php");
                        echo "fallo al conectar";
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/userForm.css">
    </head>
    <body>
        <div class="wrapper">
            <h3>Log in</h3>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="username" id="username" placeholder="Username..." class="form-control">
                    <input type="password" name="password" id="password" placeholder="Password..." class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
                <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
            </form>
        </div>
    </body>
</html>
        
