<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["file"]);
    header('Location: ../Home/home.php');
?>