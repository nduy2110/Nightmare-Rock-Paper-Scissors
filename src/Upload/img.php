<?php
$length = strlen('src/Upload/img.php');
$file_name = substr($_SERVER['PHP_SELF'], $length+2);
$file_path = '../' . $file_name; 

if (file_exists($file_path)) {
    echo(readfile($file_path));
}
else { // Image file not found
    echo " 404 Not Found";
}

?>
