<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_FILES['files'])){
        $errors = [];
        $path = 'uploads/';
        $extensions = ['pdf'];

        $file_name = $_FILES['files']['name'][0];
        $file_tmp = $_FILES['files']['tmp_name'][0];
        $file_type = $_FILES['files']['type'][0];
        $file_size = $_FILES['files']['size'][0];
        $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][0])));

        $file = $path . $file_name;

        if (!in_array($file_ext,$extensions)){
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        if (empty($errors)){
            move_uploaded_file($file_tmp,$file); 
        }else{
           print_r($errors); 
        }
        
    }
}

?>
