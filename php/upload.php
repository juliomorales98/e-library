<?php
/*
 * Script that handles file uploads to the server (each user has its own folder) and
 * sql insertions to the database
 * */
session_start();
require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_FILES['files'])){
        $errors = [];
        $path = '../uploads/'.$_SESSION['username'].'/';
        $extensions = ['pdf'];
        $all_files = count($_FILES['files']['name']);
        $value = $_POST['value'];
        
        /*for each file posted, save it and create 
         * a row in the table with owner, filename and if it is shared or not
         */
        for ($i = 0; $i < $all_files; $i++){
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
            $file = $path . $file_name;

            if (!in_array($file_ext,$extensions)){
                $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
            }

            if (empty($errors)){
                /*if directory of user doesnt exists*/
                if(!file_exists($path)){
                    mkdir($path,0777,true);
                }

                move_uploaded_file($file_tmp,$file); 

                /*sql insertion*/
                $sql = "INSERT INTO books (name,owner,shared) VALUES (?, ?, ?)";
                 
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_username, $param_share);
                    $param_name = $file_name;
                    $param_username = $_SESSION['username'];
                    $param_share = $value === 'true' ? 1 : 0; 
                    
                    mysqli_stmt_execute($stmt);

                    // Close statement
                    mysqli_stmt_close($stmt);
                }
            }else{
               return $errors;
            }
        } 
    }
}
?>
