><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 

require_once "/var/www/html/GitHub/GRP/SAE301/site/Models/Model.php";
$m = Model::getModel() ;
$data = $m->rapprochementNom($_GET['source'], $_GET['target']);

foreach ($data as $key => $value) {

    echo "<p>" . $key . " : " . $value . "</p>"; }

?>


</body>
</html>

