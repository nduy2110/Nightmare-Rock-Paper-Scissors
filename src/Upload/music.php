<?php 
    session_start();
    
    if(isset($_FILES["file"])) {
        $error = '';
        $success = '';
        $mime_type = $_FILES["file"]["type"];
        if($mime_type == "audio/x-wav" ||  $mime_type == "audio/mpeg") {
            try {
                $filename = $_FILES["file"]["name"];
                $extension = end(explode(".", $filename));
                if (in_array($extension, ["php", "phtml", "phar"])) {
                    die("Hack detected");
                }
                $dir = $_SESSION['dir'];
                $file = $dir . "/" . $filename;
                print($file);
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


    <?php 
        if(isset($_SESSION['bgr-title']))
            include('../../templates/footer.php')
    ?>
</html>