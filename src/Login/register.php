<?php 
    session_start();

    $connect = mysqli_connect('database','root','PHP_number_one','rank', 3306);
	mysqli_set_charset($connect, "utf8");

    $erors = ["username" => "", "password" => ""];

    if(isset($_POST["submit"])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username)) { //if username empty
            $erors['username'] = 'Username không được trống';
        }
        
        if(empty($password)) { //if password empty
            $erors['password'] = 'Password không được trống';
        }

        //check user exist
        $user_check_query = "SELECT username FROM score WHERE username='$username'";
        $result = mysqli_query($connect, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        if ($username) {
            if ($user['username'] === $username) {
                $erors['username'] = "Username đã tồn tại";
            }
        }

        //save user
        if(!array_filter($erors)) {
            
                //validate code go here

                $query = "INSERT INTO score (username, password) VALUE ('$username', '$password')";
                mysqli_query($connect, $query);

                $_SESSION['success'] = 1;
                header('location: login.php');
        }

    } 
    $connect -> close();
?>


<!DOCTYPE html>
<html lang="en">

    <?php include('../../templates/header.php'); ?>

    <form action="./register.php" method="POST">
        <div class="container w-25">
            <h4>Đăng ký</h4>
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control">
            <div class="text-danger"><?php echo htmlspecialchars($erors["username"]) ?></div>

            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control">
            <div class="text-danger"><?php echo htmlspecialchars($erors["password"]) ?></div>

            <input type="submit" value="Submit" name="submit" class="btn mt-3 text-ligth" style="background-color: cadetblue;color: white">
        </div>
    </form>

    </body>
</html>