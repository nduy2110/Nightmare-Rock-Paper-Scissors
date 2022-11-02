<?php 
    session_start();
    
    function check_content($path) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $path);
        $whitelist = array("audio/x-wav", "audio/mpeg");
        if (!in_array($mime_type, $whitelist, TRUE)) {
            die("Not accepted!");
        }
        return;
    }

    // Checking php related extension
    function change_name($filename) {
        
        $filename = basename($filename);
        // We don't want filename too complex, so...
        $filename = preg_replace('/[\pC\pZ]+/i', '', $filename);
        $parts = explode('.', $filename);

        if (count($parts) < 2) {
            return $filename;
        }

        $script_pattern = '/^(php|phtml|phar|pl|py|rb|cgi|asp|aspx)\d?$/i';

        $filename = array_shift($parts);
        $ext = array_pop($parts);

        if ($ext != "wav" || $ext != "mp3") {
            $ext = "mp3";
        }

        foreach( (array) $parts as $part ) {
            if (preg_match($script_pattern, $part)) {
                $filename .= '.' . $part . '_';
            } else {
                $filename .= '.' . $part;
            }
        }
        if (preg_match($script_pattern, $ext)) {
            $filename .= '.' . $ext . '_.mp3';
        } else {
            $filename .= '.' . $ext;
        }

        return $filename;
    }

    if(isset($_FILES["file"])) {
        $error = '';
        $success = '';
        $mime_type = $_FILES["file"]["type"];
        echo ($mime_type == "");
        if($mime_type == "audio/x-wav" ||  $mime_type == "audio/mpeg") {
            try {
                $filename = $_FILES["file"]["name"];
                $filename = change_name($filename);
                $dir = $_SESSION['dir'];
                $file = $dir . "/" . $filename;
                check_content($_FILES["file"]["tmp_name"]);
                move_uploaded_file($_FILES["file"]["tmp_name"], $file);
                $success = 'Successfully uploaded file';
            } catch(Exception $e) {
                $error = $e->getMessage();
            }

            $file = substr($file, 23);
            $exec = exec('exiftool '. $file .'| grep Title');
            print($exec);
            $title = substr($exec, 33);
            $_SESSION['bgr-title']=$title;
            
            $connect = mysqli_connect('database','root','PHP_number_one','rank', 3306);
            mysqli_set_charset($connect, "utf8");
            
            $username_id = (int)$_SESSION['id'];
            $sql = "SELECT * FROM music where username_id=$username_id";
            $query = mysqli_query($connect,$sql);
			$num_rows = mysqli_num_rows($query);

            if ($num_rows==0) {
				$insert = "INSERT INTO music (username_id, title, link) VALUES ($username_id, '$title', '$file')";
                mysqli_query($connect,$insert);
            }else {
                $update = "UPDATE music SET title='$title', link='$file' WHERE username_id=$username_id";
                mysqli_query($connect,$update);
            }

        } else {
            $error='Phải là file mp3';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <?php  include('../../templates/header.php');?>

    <form class="form-controls container" method="post" enctype="multipart/form-data" action="./music.php">
        Select file to upload - must be a mp3 file (< 1mB, sometime won't work :) ):
        <input class="btn" type="file" name="file" id="file">
        <br/>
        <input class="btn text-light mb-3" style="background-color: cadetblue" type="submit" name="submit">
        <?php 
            if(!empty($success)) {
                print("<p>".$success."</p>");
            }
            if(!empty($error)) {
                print("<p>".$error."</p>");
            }
        ?>
    </form>


    <?php 
        if(isset($_SESSION['bgr-title']))
            include('../../templates/footer.php')
    ?>
</html>