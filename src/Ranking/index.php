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
     </body>
</html>