<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET')
        $document = $_GET["fileGet"]; 
?>
<html>
    <head>
        <title>View <?php echo $document; ?></title>
    </head>
    <body>
        <object data="/uploads/<?php echo $document ?>" width="100%" height="100%" type="application/pdf">
    </object>
    </body>
</html>
