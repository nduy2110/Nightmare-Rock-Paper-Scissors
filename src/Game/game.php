<?php
    $names = array('Rock', 'Paper', 'Scissors');
    $human = isset($_POST["human"]) ? $_POST['human']+0 : -1;
    $username='endy';

    $computer = 0;
    $computer = rand(0,2);

    function check($computer, $human) {
        if ( $human == $computer ) {
            return "Hòa";
        } else if ( $human == 0 && $computer == 2) {
            return "You Win";
        } else if ( $human == 1 && $computer == 0) {
            return "You Win";
        } else if ( $human == 2 && $computer == 1) {
            return "You Win";
        } else if ( $human == 0 && $computer == 1) {
            return "You Lose";
        } else if ( $human == 1 && $computer == 2) {
            return "You Lose";
        } else if ( $human == 2 && $computer == 0) {
            return "You Lose";
        }
        return false;
    }

    $result = check($computer, $human);

    $conn = mysqli_connect("localhost", "root", "","rank", 3307);
    if(!$conn) {
        echo mysqli_connect_error();
    }

    
    $query = "SELECT id,username,point FROM score WHERE username='$username'";
    $execute = mysqli_query($conn, $query);
    $temp_arr = mysqli_fetch_assoc($execute);
    $id = $temp_arr['id'];

    
    
    if(strpos($result, 'Win') != FALSE) {
        $point = $temp_arr['point'] + 1;
        $query = "UPDATE score SET point=$point WHERE id=$id";
        $execute = mysqli_query($conn, $query);
    } else if (strpos($result, 'Lose') != FALSE) {
        $point = $temp_arr['point'] - 1;
        $query = "UPDATE score SET point=$point WHERE id=$id";
        $execute = mysqli_query($conn, $query);
    }

    $conn->close();
?>

<!DOCTYPE html>
    <html>
        <?php require_once "../../templates/header.php"; ?>
        
        <div class="container">
            <h1>Kéo Búa Bao Battle Cực gắt</h1>
        <?php
            // if ( isset($_REQUEST['name']) ) {
            //     echo "<p>Welcome: ";
            //     echo htmlentities($_REQUEST['name']);
            //     echo "</p>\n";
            // }
        ?>
        <form method="post">
            <select name="human">
                <option value="-1">Select</option>
                <option value="0">Rock</option>
                <option value="1">Paper</option>
                <option value="2">Scissors</option>
            </select>
            <input type="submit" value="Play">
        </form>

        <div>
            <?php
                if ( $human == -1 ) {
                    print "Please select a strategy and press Play.\n";
                } else if ( $human < 3 ) {
                    print "Bạn chọn $names[$human], máy chọn $names[$computer]\n <br> $result";
                } else {
                    print "Hacked???";
                }
            ?>
        </div>
        </div>
    </body>
</html>