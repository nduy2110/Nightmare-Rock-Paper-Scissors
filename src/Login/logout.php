<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["file"]);
    unset($_SESSION["success"]);

    header('Location: ../Home/home.php');
?>