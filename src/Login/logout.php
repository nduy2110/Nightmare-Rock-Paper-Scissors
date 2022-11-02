<?php
    session_start();
    unset($_SESSION["username"]);
    unset($_SESSION["file"]);
    unset($_SESSION["success"]);
    unset($_SESSION["bgr-title"]);

    header('Location: ../Home/home.php');
?>