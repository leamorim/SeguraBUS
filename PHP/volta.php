<?php
$textfile = "s.txt";
$fileLocation = "$textfile";
$fh = fopen($fileLocation, 'r') or die("Something went wrong!"); 
$h = fgets($fh,7); 
fclose($fh); 
echo "$h";
return $h;
?>