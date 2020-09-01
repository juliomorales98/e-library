<?php
    session_start();
    require "php/config.php";
    if($_SERVER['REQUEST_METHOD'] === 'GET')
        $document = $_GET["fileGet"]; 
        $owner = $_GET["ownerGet"];
?>
<html>
    <head>
        <title>View <?php echo $document; ?></title>
    </head>
    <body>
        <object data="/uploads/<?php echo $owner."/".$document; ?>" width="100%" height="100%" type="application/pdf">
    </object>
    </body>
</html>
