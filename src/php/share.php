<?php

session_start();

require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $file = $_POST['filename'];
    $owner = $_POST['owner'];

    if(empty($file) || empty($owner)){
        print_r("\nData empty");
        return;
    }

    if ($owner != $_SESSION['username']){
        print_r("\nFile doesn't belong to you");
        return;
    }
    $sql = "SELECT shared FROM books WHERE name = ? AND owner = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt,"ss",$param_name,$param_owner);
        $param_name = $file;
        $param_owner = $owner;

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$shared);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);
        $sqlU = "UPDATE books set shared = ? WHERE name = ? AND owner = ?";

        if($stmtU = mysqli_prepare($link, $sqlU)){
            mysqli_stmt_bind_param($stmtU,"iss",$param_shareU,$param_nameU,$param_ownerU);
            $param_nameU = $file;
            $param_ownerU = $owner;
            $param_shareU = $shared == 1 ? 0 : 1;
            mysqli_stmt_execute($stmtU);

            mysqli_stmt_close($stmtU);
        }    
    }


    


}
