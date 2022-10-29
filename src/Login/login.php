<?php 
    session_start();

    $connect = mysqli_connect('localhost','root','','rank', 3307);
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

        //authentication
        if(!array_filter($erors)) {
            
                //validate code go here

                $sql = "SELECT username,password FROM score where username = '$username' and password = '$password' ";
                echo $sql;
			    $query = mysqli_query($connect,$sql);
			    $num_rows = mysqli_num_rows($query);
			if ($num_rows==0) {
				$erors['password']="Tên đăng nhập hoặc mật khẩu không đúng !";
			}else{
				$_SESSION['username'] = $username;
				$_SESSION['is_login'] = 1;
                header('location: ../Upload/index.php');    
            }
        } 
    }
    $connect -> close();
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('../../templates/header.php'); ?>

    <form action="./login.php" method="POST">
        <div class="container w-25">
            <h4>Đăng Nhập</h4>
            <?php if(isset($_SESSION["success"])) {
                echo "<h6 class='text-info'>Đăng ký thành công, tiến hành đăng nhập</h6>";
            } else {
                echo "<h6 class='text-info'> <a href='register.php'>Nhân vào đây để đăng ký</a> </h6>";
            }
            ?>
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control">

            <input type="submit" value="Submit" name="submit" class="btn text-ligth mt-3" style="background-color: cadetblue; color: white">
        </div>
    </form>

    </body>
</html>