<?php
session_start();
require ("../config.php");

    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        $pdo = new PDO($dsn, $read_user, $read_password);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    if(!$pdo) echo "ERROR: can't connect to database";

    if (isset($_SESSION['user_id'])) {
        $user = $_SESSION['user_id'];

        $sql = "SELECT name, is_admin FROM `users` WHERE user_id = $user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $name = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>
<!doctype html>
<html lang="en">

<head>
<!--    standard shit-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!--    custom icons from fontawesome-->
    <script src="https://kit.fontawesome.com/9458b18579.js" crossorigin="anonymous"></script>

<!--    custom font from google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

<!--    link stylesheet-->
    <link rel="stylesheet" href="styles/base.css" type="text/css">
    <link rel="stylesheet" href="styles/navbar.css" type="text/css">
    <link rel="stylesheet" href="styles/index.css" type="text/css">

    <!--    link javascript-->
    <script src="scripts/toggleSearch.js"></script>
    <script src="scripts/createCard.js"></script>
    <script src="scripts/showResult.js"></script>

<!--    webpage title-->
    <title>Webtechnologie voor KI/INF 2022</title>

</head>

<body onload="createCard(8)">


<!--    navbar-->
    <nav>
        <a href="index.php"><img id="logo" src="images/logo-cinema.png" alt="logo cinema"/></a>

        <ul>
            <form id="searchbar">
                <input id="textbox"
                       type="text"
                       placeholder="Search.."
                       onkeyup="showResult(this.value)"
                >
                <div id="suggestions"></div>
            </form>

            <li class="nav-item" onclick="toggleSearch()"><i class="fas fa-search"></i></li>
            <li class="nav-item"><a href="pages/alleFilms.php">FILMS</a></li>

            <?php if (isset($_SESSION['user_id'])) {
                if ($name[0]['is_admin'] == 1) {
                    echo "<li class='nav-item'><a href='pages/admin.php'>" . $name[0]['name'] . "</a>";
                }
                else {
                    echo "<li class='nav-item'><a href='pages/profile.php'>" . $name[0]['name'] . "</a>";
                }
            } else {
                echo "<li class='nav-item'><a href='pages/signup.php'>SIGNUP</a></li>";
                echo "<li class='nav-item'><a href='pages/login.php'>LOGIN</a></li>";
            }
            ?>

        </ul>
    </nav>

    <div id="header-container">
        <header>
            <!--        TODO add some javascript to "now" or "soon" be highlighted-->
            <h1 id="current">NOW</h1>
            <h1 class="header-gradient">SOON</h1>
        </header>
    </div>


    <div id="main-container"></div>

    <footer>
        <h3>Follow Us</h3>
        <div id="socials"></div>
    </footer>
</body>

</html>
