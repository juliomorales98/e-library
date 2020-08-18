<?php
session_start();
if(isset($_SESSION["LOGGEDIN"]) && $_SESSION["loggedin"] === true){
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
                        session_start();
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
    </head>
    <body>
        <form method="post">
            <input type="text" name="username" id="username" placeholder="Username...">
            <input type="password" name="password" id="password" placeholder="password...">
            <input type="submit" value="Login">
        </form>
    </body>
</html>
        
