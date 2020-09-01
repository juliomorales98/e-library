<?php

session_start();

require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $file = $_POST['filename'];
    $owner = $_POST['owner'];
    
    if (empty($file) || empty($owner)) {
        print_r("\nData error");
        print_r("\nfile->" . $file);
        print_r("\nowner->" . $owner);
        return;
    }
    if ($owner != $_SESSION['username']){
        print_r("File doesn't belong to you.Owner= " . $owner . ",user = " . $_SESSION['username'] );
        return;
    }

    $sql = "DELETE FROM books WHERE name = ? AND owner = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt,"ss", $param_name, $param_owner);
        $param_name = $file;
        $param_owner = $owner;

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }

    // Delete file
    $file = '../uploads/'.$owner.'/'.$file;
    if(file_exists($file)){
        unlink($file);
    }

    
}
?>
