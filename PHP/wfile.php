<?php
$msg = $_GET["msg"]; 
$textfile = "status.txt"; // Declares the name and location of the .txt file
 
$fileLocation = "$textfile";
$fh = fopen($fileLocation, 'w') or die("Something went wrong!");  
$stringToWrite = "/";
fwrite($fh, $stringToWrite);
$stringToWrite = "$msg"; 
fwrite($fh, $stringToWrite); 
 
fclose($fh); 
 
header("Location: http://localhost/PHP/periodo.html");