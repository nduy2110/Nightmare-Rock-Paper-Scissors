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

    return $filename;
}

if(isset($_FILES["file"])) {
    $error = '';
    $success = '';
    try {
        $filename = $_FILES["file"]["name"];
        $filename = change_name($filename);
        $dir = $_SESSION['dir'];
        print_r($_SESSION); # DEBUG
        $file = $dir . "/" . $filename;
        move_uploaded_file($_FILES["file"]["tmp_name"], $file);
        $relative_path = substr($file, strlen($_SESSION['root'])); // Extract only relative
        # Todo: add $file to database !
        $success = 'Successfully uploaded file at: <a href="' . $relative_path . '">' . $relative_path . ' </a><br>';
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload avatar</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        Select file to upload:
        <input type="file" name="file" id="file">
        <br/>
        <input type="submit">
    </form>
    <?php if(isset($success)) {echo $success;} ?>
</body>
</html>