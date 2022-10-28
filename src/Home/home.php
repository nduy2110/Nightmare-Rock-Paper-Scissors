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

    <?php include('../../templates/header.php')?>

    <div  class="container w-50 p-3">
        <?php 
            $img = ["meme1.jpg", "meme2.jpg", "meme3.jpg", "meme4.jpg"];
            $meme=rand(0,3);
            echo '<img src="../../img/'.$img[$meme].'" width="100%">'
        ?>
        <!-- <img src="../../img/meme1.jpg" width="100%"> -->
    </div>


</html>