<?php

session_start();

// login not implemented -> use default name
$_SESSION['name'] = '123456';

// if is not login
if (!isset($_SESSION['name'])) {
    header('Location: /register.php');
    die();
}


// Adding more protection
// CVE-2020–35498 : https://blog.wpsec.com/contact-form-7-vulnerability/
function change_name($filename) {
    
    $filename = basename($filename);
    $parts = explode('.', $filename);

    if (count($parts) < 2) {
        return $filename;
    }

    $script_pattern = '/^(php|phtml|phar|pl|py|rb|cgi|asp|aspx)\d?$/i';

    $filename = array_shift($parts);
    $ext = array_pop($parts);

    foreach( (array) $parts as $part ) {
        if (preg_match($script_pattern, $part)) {
            $filename .= '.' . $part . '_'; // <- mitigation
        } else {
            $filename .= '.' . $part;
        }
    }
    if (preg_match($script_pattern, $ext)) {
        $filename .= '.' . $ext . '_.txt'; // <- mitigation
    } else {
        $filename .= '.' . $ext;
    }

    $filename = preg_replace('/[\pC\pZ]+/i', '', $filename); // <- Cannot find CVE's correct PoC, change source code a little bit!

    return $filename;
}

if(isset($_FILES["file"])) {
    $error = '';
    $success = '';
    try {
        $filename = $_FILES["file"]["name"];
        $filename = change_name($filename); // Payload: mal.php + any unicode character
        $dir = $_SESSION['dir'];
        print_r($_SESSION); # DEBUG
        $file = $dir . "/" . $filename;
        move_uploaded_file($_FILES["file"]["tmp_name"], $file);
        $relative_path = substr($file, strlen($_SESSION['root'])); // Extract only relative
        # Todo: add $relative_path to database !
        # Todo: path traversal via apache misconfiguration
        $success = 'Successfully uploaded file at: <a href="' . $relative_path . '">' . $relative_path . ' </a><br>';
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

    <?php 
        include("../../templates/header.php"); 
        if(isset($_SESSION['username'])) {
            echo '
            <form class="form-controls container" method="post" enctype="multipart/form-data">
                Select file to upload:
                <input class="btn" type="file" name="file" id="file">
                <br/>
                <input class="btn text-light" style="background-color: cadetblue" type="submit">
            </form>
            ';
            if(isset($success)) {echo $success;}
        } else {
            echo '
                <div class="container">
                    <h5>Đăng nhập trước đã fen. <a href="../Login/login.php">Login</a></h5>
                </div>
            ';
        }
    ?>
    

</body>
</html>