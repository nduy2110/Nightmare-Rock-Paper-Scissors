<?php

// Create folder for each user
session_start();

#unset($_SESSION['dir']);
# Root directory at Nightmare-Rock-Paper-Scissors !
# Current file at Nightmare-Rock-Paper-Scissors/src/home.php 
# Upload folder at Nightmare-Rock-Paper-Scissors/upload
$_SESSION['root'] = dirname(__FILE__) . '/..';

# Create upload folder
if ( !file_exists($_SESSION['root'] . '/upload') )
    mkdir($_SESSION['root'] . '/upload');


# Create session's folder
if (!isset($_SESSION['dir'])) {
    $_SESSION['dir'] = dirname(__FILE__). '/../upload/' . session_id(); 
}
$dir = $_SESSION['dir'];

if ( !file_exists($dir) )
    mkdir($dir);
var_dump($_SESSION['dir']); # DEBUG
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('../templates/header.php')?>

    <?php include('../templates/footer.php')?>


</html>