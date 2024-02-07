<?php
echo '<br>';
foreach($data as $film) {
    echo "" . $film["primarytitle"] . "<br>";
}
echo "Total films: " . count($data);
?>