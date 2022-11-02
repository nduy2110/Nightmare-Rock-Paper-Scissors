<?php

session_start();


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
        $file = $dir . "/" . $filename;
        move_uploaded_file($_FILES["file"]["tmp_name"], $file);
        $success = 'Successfully uploaded file at: <a href= "'.$file . '">' . $file . ' </a><br>';
        $_SESSION['file'] = $file;
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<style>
    .border {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    form {
        display: flex;
        flex-direction: column;
        
        
        align-items: center;
    }
</style>

<html lang="en">

    <?php 
        include("../../templates/header.php"); 
        if(isset($_SESSION['username'])) {
            echo '
            <span class="border">
            <form class="form-controls container" method="post" enctype="multipart/form-data">
                Select file to upload:
                <br/>
                <img src="https://icons.iconarchive.com/icons/grafikartes/flat-retro-modern-2/256/preview-icon.png" id="preview"/>
                <input class="btn" type="file" name="file" id="file" onchange="onChange(event);">
                <br/>
                <input class="btn text-light" style="background-color: cadetblue" type="submit">
            </form>
            </span>
            <div class="container text-center">
                <a href="../Login/changepass.php">Đổi mật khẩu</a>
            </div>
            <div class="container text-center">
                <a href="./music.php">Upload nhạc nền</a>
            </div>
            ';
        } else {
            echo '
                <div class="container">
                    <h5>Đăng nhập trước đã fen. <a href="../Login/login.php">Login</a></h5>
                </div>
            ';
        }
    ?>
    

</body>
<script>
    function onChange(event){
        img = document.getElementById("preview");
        console.log(event.target.files[0]);

        var reader = new FileReader();
    
        reader.addEventListener('load', function (e) {
            r =  e.target.result;
            if (r.includes("php") || r.includes("system")) {
                img.src = "https://i.pinimg.com/736x/e4/b3/44/e4b34454f9f4ccec3dfd8aad4658dd66.jpg"
            } else {
                img.src = URL.createObjectURL(event.target.files[0]);
                img.onload = function() {
                    URL.revokeObjectURL(img.src) // free memory
                }
            }
        });
        
        reader.readAsBinaryString(event.target.files[0]); 
    }
</script>
</html>