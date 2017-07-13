<?php
$textfile = "periodo.txt"; // Declares the name and location of the .txt file
$fileLocation = "$textfile";
$fh = fopen($fileLocation, 'r') or die("Something went wrong!"); // Opens up the .txt file for writing and replaces any previous content
$texto = fgets($fh,8); 
fclose($fh); 
echo "$texto";
?>