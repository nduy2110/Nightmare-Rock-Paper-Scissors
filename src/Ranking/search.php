<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        background-color: #6B8E23;
        color: white;
        }
</style>
</head>
<body>
        <?php
        // ket noi du lieu 
        $conn = mysqli_connect("localhost", "root", "","rank");
        // truy van du lieu 
        if(isset($_GET["search"]) && !empty($_GET["search"]))
        {
            $search = $_GET["search"];
            $sql = "SELECT * FROM score WHERE username LIKE '%".$search."%'";
        }
        else {
            $sql = "SELECT * FROM score";
        }
        $result = mysqli_query($conn,$sql);
        ?>
        <h1 align = "center"> Score Board </h1>
        <table id="customers">
            <tr>
                <td>
                        <form action = "" method = "get">
                            <input type = "text" name = "search" value = 
                            "<?php if(isset($_GET["search"])) {echo $_GET["search"];} ?>" >
                            <input type = "Submit" value = " Search">
                        </form>
                </td>
            </tr>
        </table>
        <table id="customers">
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