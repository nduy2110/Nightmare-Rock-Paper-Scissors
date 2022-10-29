
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../style/header.css">
    <link rel="stylesheet" href="../../style/footer.css">
    <title>Game of the year</title>
</head>

<body style="min-height: 100%">
    <header>
        <div class="container-fluid nav-div mb-3" style="height: 75px; align-items: center; line-height: 75px">
            <ul class="header-nav" style="font-size: 25px">
                <li> <a href="../Home/home.php">Home</a></li>
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo '<li> <a href="../Login/logout.php">Logout</a></li>';
                    } else {
                        echo '<li> <a href="../Login/login.php">Login</a></li>';
                    }
                ?>
                <li> <a href="../Game/game.php">Play</a></li>
                <li> <a href="../Ranking/">Ranking</a></li>
                <li> <a href="../Upload/index.php">Profile</a></li>
                    
                <?php 
                    if(isset($_SESSION['username'])) {
                        echo '<li> <a href="">'.$_SESSION['username'].'</a></li>';
                    }
                ?>

            </ul>
        </div>
    </header>