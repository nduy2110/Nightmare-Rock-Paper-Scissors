<!DOCTYPE html>
<html lang="en">
            
    <?php include('../../templates/header.php');?>

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
    $count = 1;
    // ket noi du lieu 
    $conn = mysqli_connect("localhost", "root", "","rank");

    $query = "SELECT username,point FROM score";
    $out =$conn -> query($query);

    $emptyArray = array(array());
    while($result = mysqli_fetch_array($out))
    {
        $row['username'] = $result['username'];
        $row['point'] = $result['point'];
        array_push($emptyArray,$row);
    }
    array_shift($emptyArray);
    array_multisort( array_column($emptyArray, "point"), SORT_DESC, $emptyArray);
    //echo "<pre>"; print_r($emptyArray); echo "</pre>";

    ?>
    <h1 align = "center"> Score Board </h1>
    <table id="customers">
                <tr>
                    <td>
                            <form action = "" method = "get">
                                <input type = "text" name = "search" value = 
                                "<?php if(isset($_GET["search"])) {echo $_GET["search"];} ?>" >
                                <input type = "button" value = " Search" onclick = "window.location.href = 'search.php'">
                            </form>
                    </td>
                </tr>
    </table>
    <table id="customers">
                        <tr>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        <tr>
                        <td><?php foreach ( $emptyArray as $var ) {
                            echo "<br>".$var['username']."<br>";} ?></td>
                        <td><?php foreach ( $emptyArray as $var ) {
                            echo "<br>".$var['point']."<br>";} ?></td>
                        
                </tr>
            </table>
    
    <!-- <?php include('../../templates/footer.php');?>    -->
    </body>
</html>
