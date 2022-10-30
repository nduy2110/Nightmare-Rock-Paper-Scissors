<!DOCTYPE html>
<html lang="en">

    <?php
    session_start();
    include('../../templates/header.php')
    ?>

    <style>
        #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #customers td, #customers th {
        border: 1px solid #FFFFFF;
        padding: 8px;
        }

        #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: cadetblue;
        color: white;
        }
    </style>

        <?php

        // ket noi du lieu 
        $conn = mysqli_connect("localhost", "root", "","rank");
        // truy van du lieu 
        if(isset($_GET["search"]) && !empty($_GET["search"]))
        {
            $search = $_GET["search"];
            $sql = "SELECT username,point FROM score WHERE username LIKE '%$search%' ORDER BY username DESC";
        }
        else {
            $sql = "SELECT * FROM score";
        }
        $result = mysqli_query($conn,$sql);
        ?>
        <h1 align = "center"> Score Board </h1>
        <table id="customers" class="container">
            <tr>
                <td>
                        <form action = "" method = "get">
                            <input class="form-control w-25" type = "text" name = "search" value = 
                            "<?php if(isset($_GET["search"])) {echo htmlspecialchars($_GET["search"]);} ?>" >
                            <input class="btn text-light mt-3" type = "Submit" value = " Search" style="background-color: cadetblue">
                        </form>
                </td>
            </tr>
        </table>
        <table id="customers" class="container table">
            <tr>
                <th>Username</th>
                <th>Score</th>
            </tr>
        <?php
        while($row = mysqli_fetch_assoc($result))
        {
            $username = $row["username"];
            $score = $row["point"];
        ?>
        <tr>
            <td><?php echo $username ?></td>
            <td><?php echo $score ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
     </body>
</html>
