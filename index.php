<?php
?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <!--Javascript-->
        <!--CSS-->
        <link rel="stylesheet" href="css/index.css">
        <title>E-library</title>
    </head>
    <body>
        <h1 id="title">My library</h1><input type="button" id="selectedFolder" value="Shared Folder">
        <div id="filesContainer" class="filesContainer">
            <?php
                $fileList = glob('uploads/*');
                foreach($fileList as $fileName){
                    if(is_file($fileName)){
                        $cleanName = str_replace("uploads/","",$fileName);
                        $nameQuotes = '"'.$cleanName.'"';
                        echo "<div class='fileItem' onclick='ShowManagePanel($nameQuotes);'> " ;
                        echo "<label>$cleanName</label>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
        <div id="addButton" class="addButton"><button type="button" onclick="ShowAddForm();">+</button></div>
        <div id="addPopup" class="addPopup">
            <form method="post" id="documentUploadForm" enctype="multipart/form-data">
                <h2>Add pdf</h2>
                <input type="file" id="file" name="file" multiple accept="application/pdf">
                <input id="isShared" type="checkbox"><label for="isShared">Share this file</label>
                <input type="submit" value="Upload">
            </form>
        </div>
        <div id="managePanel" class="managePanel">
            <h4>Manage file</h4>
            <h5 id="managePanelTitle" class="managePanelTitle"></h5>
            <form method="get" action="view.php/" target="_blank">
            <input type="hidden" name="fileGet" id="fileHidden" >
            <input type="submit" id="openButton" value="Open">
            </form>
            <input type="button" value="Share">
            <a id="downloadButton" href="#" download><input type="button" value="Download" ></a>
            <input type="button" value="Delete">
        </div>
        <script src="./js/upload.js"></script>

        <script src="js/index.js"></script>
    </body>
<html>
