    <?php 
        $title = $_SESSION['bgr-title'];

        $connect = mysqli_connect('database','root','PHP_number_one','rank', 3306);
        mysqli_set_charset($connect, "utf8");

        $sql = "SELECT username_id,title,link FROM music where title='$title'";
		$query = mysqli_query($connect,$sql);
        $row = mysqli_fetch_array($query);

    ?>

    
    <footer>
        <div class="container-fluid text-center text-light mt-3" style="height:100px;background-color: cadetblue;position:absolute;bottom: 0;">
            <p class="pt-2">PLaying: <?php echo $row['title'] ?> </p>
            <p>Tính năng play nhạc đang được bảo trì</p>
        </div>
    </footer>
    
    <script>
        var audio = new Audio('<?php echo $link?>');
        audio.play();
    </script>
</body>