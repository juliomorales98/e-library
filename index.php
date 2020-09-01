<?php
session_start();
include "php/config.php";
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location:login.php");
    exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <!--Javascript-->
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <!--CSS-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="css/index.css">
        <title>E-library</title>
    </head>
    <body>
<div>
        <h1 id="title">My library (<?php echo $_SESSION["username"]; ?>)</h1><input type="button" id="selectedFolder" onclick="SwitchFolder('<?php echo $_SESSION["username"]; ?>');" value="Shared Folder">
</div>
        <a href="logout.php">Logout</a>
        <div id="userFilesContainer" class="filesContainer">
            <?php
               $sql = "SELECT name,owner FROM books WHERE owner = ?";
                $stmt = mysqli_prepare($link,$sql);
                mysqli_stmt_bind_param($stmt,"s",$param_owner);
                $param_owner = $_SESSION['username']; 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_bind_result($stmt,$name,$owner);
                    while(mysqli_stmt_fetch($stmt)){
                     $fileName = $name;
                     $fileNameQuotes = '"'.$fileName.'"';
                     $owner = '"'.$owner.'"';
                     echo "<div class='fileItem' onclick='ShowManagePanel($fileNameQuotes,$owner);'> " ;
                     echo "<label>$fileName</label>";
                     echo "</div>";
                    }
            ?>
        </div>
        <div id="sharedFilesContainer" class="filesContainer">
            <?php
               $sql = "SELECT name,owner FROM books WHERE shared = ?";
                $stmt = mysqli_prepare($link,$sql);
                mysqli_stmt_bind_param($stmt,"i",$param_share);
                $param_share = 1; 
                mysqli_stmt_execute($stmt); 
                mysqli_stmt_bind_result($stmt,$name,$owner);
                    while(mysqli_stmt_fetch($stmt)){
                     $fileName = $name;
                     $fileNameQuotes = '"'.$fileName.'"';
                     $owner = '"'.$owner.'"';
                     echo "<div class='fileItem' onclick='ShowManagePanel($fileNameQuotes,$owner);'> " ;
                     echo "<label>$fileName</label>";
                     echo "</div>";
                    }
            ?>
        </div>
        <div id="addButton" class="addButton"><button type="button" onclick="ShowAddForm();">+</button></div>
        <div id="addPopup" class="addPopup">             
            <div class="layout">
                <i onclick="ShowAddForm();" class="fas fa-times closeButton"></i>
                <form method="post" id="uploadForm" enctype="multipart/form-data">
                <h2>Add pdf(s) </h2>
                <div class="details">(Max <?php echo ini_get('max_file_uploads');?> files, <?php echo ini_get('post_max_size');?> MB)</div>
                    <label class="addLabel" for="file">Select File(s)</label><input type="file" id="file" name="file" multiple accept="application/pdf">
                    <label class="filesToUpload" id="filesToUpload"></label>
                    <input id="isShared" type="checkbox"><label for="isShared">Share this file</label>
                    <i class="fas fa-upload" onclick="Submit();"> Upload</i>
                </form>
            </div>
        </div>
        <div id="managePanel" class="managePanel">
            <input type="hidden" name="fileNameHidden" id="fileNameHidden">
            <input type="hidden" name="fileOwnerHidden" id="fileOwnerHidden">
             
            <h4>Manage file</h4>
            <h5 id="managePanelTitle" class="managePanelTitle"></h5>
            <form method="get" action="view.php/" target="_blank">
                <input type="hidden" name="fileGet" id="fileHidden" >
                <input type="hidden" name="ownerGet" id="ownerHidden" >
                <input type="submit" id="openButton" value="Open">
            </form>
            <input type="button" value="Share">
            <a id="downloadButton" href="#" download><input type="button" value="Download" ></a>
            <input type="button" value="Delete" onclick="DeleteFile();">
            
        </div>
        <script src="js/index.js"></script>
    </body>
<html>
