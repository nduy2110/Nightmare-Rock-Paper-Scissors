<?php
    session_start();

    $connect = mysqli_connect('database','root','PHP_number_one','rank', 3306);
	mysqli_set_charset($connect, "utf8");

    $erors = ["username" => "", "password" => ""];

    if(isset($_POST["submit"])) {

        $username = $_SESSION["username"];
        $old_password = $_POST['old-password'];
        $new_password = $_POST['new-password'];

        
        if(empty($old_password) or empty($new_password)) { //if password empty
            $erors['password'] = 'Password không được trống';
        }

        //check password
        $password_check_query = "SELECT password FROM score WHERE password='$old_password'";
        $result = mysqli_query($connect, $password_check_query);
        $password_check = mysqli_fetch_assoc($result);
        if ($old_password) {
            if ($password_check['password'] !== $old_password) {
                $erors['password'] = "Password không đúng";
            }
        }

        //save user
        if(!array_filter($erors)) {
            
                $query = "UPDATE score SET password='$new_password' WHERE username='$username' and password='$old_password'";           
                mysqli_query($connect, $query);

                $message = "<p>Đổi mật khẩu thành công, <a href='login.php'>Đăng nhập</a></p>";
        }

    } 
    $connect -> close();
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('../../templates/header.php'); ?>

    <form action="./changepass.php" method="POST">
        <div class="container w-25">
            <h4>Đổi Mật khẩu</h4>


            <label for="password" class="form-label">Old Password:</label>
            <input type="password" name="old-password" class="form-control">
            <div class="text-danger"><?php echo htmlspecialchars($erors["password"]) ?></div>

            <label for="password" class="form-label">New Password:</label>
            <input type="password" name="new-password" class="form-control">
    

            <input type="submit" value="Submit" name="submit" class="btn mt-3 text-ligth" style="background-color: cadetblue;color: white">

            <?php
                if(isset($message)) {
                    print($message);
                }
            ?>
        </div>
    </form>

    </body>
</html>