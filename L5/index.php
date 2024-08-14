<?php
function printChristmasTree($row) {
    for ($i = 1; $i <= $row; $i++) {
        for ($j = $i; $j < $row; $j++) {
            echo "*";
        }
        for ($j = 1; $j <= (2 * $i - 1); $j++) {
            echo "#";
        }
        echo "<br>";
    }
}

$treeHeight = 5;
printChristmasTree($treeHeight);
?>
