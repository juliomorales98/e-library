<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_FILES['files'])){
        $errors = [];
        $path = 'uploads/';
        $extensions = ['pdf'];
        
        $all_files = count($_FILES['files']['name']);
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
                move_uploaded_file($file_tmp,$file); 
            }else{
               print_r($errors); 
               return $errors;
            }
        } 
    }
}

?>
