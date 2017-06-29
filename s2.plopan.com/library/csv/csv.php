<?php
/**
 * Created by PhpStorm.
 * User: Jaffa
 * Date: 24.06.2017
 * Time: 23:55
 */

$nameOfFile = '1.csv';

$fp = fopen($nameOfFile, "r");
$row=0;
while (($data = fgetcsv($fp,1000,";")) !== FALSE) {
    $num = count($data);
    echo "<p> $num полей в строке $row: <br /></p>\n";
    $row++;
    var_dump($data);
    for ($c=0; $c < $num; $c++) {
        echo $data[$c] . "<br />\n";
    }
}
fclose($fp);