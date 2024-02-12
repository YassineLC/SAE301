<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Content/css/bootstrap.min.css" rel="stylesheet">
    <title>Resultat</title>
</head>
<body>

    <div id="page">
<h1>Resultat</h1>

<p> hehe <p>
<p> <?php echo "hoho" . $data ?></p>
<div> 
    <ol>
        <?php foreach($data as $ligne) : ?>
        <li>
            <?= print_r($ligne) ?>
        </li>
        <?php endforeach?>
    </ol>
</div>
        </div>
        </body>
        </html>