<?php 
    session_start();
    
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
    
        return $filename;
    }

    if (!isset($_SESSION['dir'])) {
        $_SESSION['dir'] = 'music/' . session_id();
    }
    $dir = $_SESSION['dir'];
    if ( !file_exists($dir) )
        mkdir($dir);

    if(isset($_FILES["file"])) {
        $error = '';
        $success = '';
        $mime_type = $_FILES["file"]["type"];
        if($mime_type == "audio/x-wav" ||  $mime_type == "audio/mpeg") {
            try {
                $filename = $_FILES["file"]["name"];
                $filename = change_name($filename); 
                $file = $dir . "/" . $filename;
                move_uploaded_file($_FILES["file"]["tmp_name"], $file);
                $success = 'Successfully uploaded file at: <a href= "'.$file . '">' . $file . ' </a><br>';
            } catch(Exception $e) {
                $error = $e->getMessage();
            }

            $exec = exec('exiftool '. $file .'| grep Title');
            $title = substr($exec, 8);
            
            $connect = mysqli_connect('database','root','PHP_number_one','rank', 3306);
            mysqli_set_charset($connect, "utf8");
            
            $username_id = (int)$_SESSION['id'];
            $sql = "SELECT * FROM music where username_id=$username_id";
            $query = mysqli_query($connect,$sql);
			$num_rows = mysqli_num_rows($query);
            var_dump($num_rows);

            if ($num_rows==0) {
				$insert = "INSERT INTO music (username_id, title, link) VALUES ($username_id, '$title', '$file')";
                $exec = mysqli_query($connect,$insert);
                var_dump($exec);
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
        Select file to upload - must be a mp3 file:
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


</body>
</html>