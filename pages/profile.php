<?php
require_once '../php/authenticate.php';
require_once ("../../config.php");

session_start();

// Database connection
$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    $pdo = new PDO($dsn, $read_user, $read_password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

    // User_id ophalen uit de sessie
    if(!isset($_SESSION['user_id'])){
        header("location: login.php");
    }
    $user = $_SESSION['user_id'];

    // Orders van de betreffende user ophalen
    $sql = "SELECT * FROM `order` WHERE user_id = $user";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    $order = $statement->fetchall(PDO::FETCH_ASSOC);

    $count = count($order);

    if ($count > 0) {
        // Ticket ophalen om de seat_id en showtime_id te kunnen gebruiken
        $tijdelijk = $order[0]['orderID'];
        $sql = "SELECT showtime_id, seat_id FROM `ticket` WHERE orderID = $tijdelijk";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $ticket = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Showtime ophalen aan de hand van showtime_id
        $tijdelijk = $ticket[0]['showtime_id'];
        $sql = "SELECT * FROM `showtime` WHERE showtime_id = $tijdelijk";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $showtime = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Seat_name ophalen aan de hand van seat_id
        $tijdelijk = $ticket[0]['seat_id'];
        $sql = "SELECT seat_name FROM `seat` WHERE seat_id = $tijdelijk";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $seat = $statement->fetchAll(PDO::FETCH_ASSOC);

        // City ophalen aan de hand van location_id
        $tijdelijk = $showtime[0]['location_id'];
        $sql = "SELECT city FROM `location` WHERE location_id = $tijdelijk";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $location = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Movie title ophalen aan de hand van movie_id
        $tijdelijk = $showtime[0]['movie_id'];
        $sql = "SELECT title FROM `movie` WHERE movie_id = $tijdelijk";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $title = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Alle waardes opslaan in een tabelrij
        $html = "<tr> <th>" . $title[0]['title'] . " </th><th>" . $showtime[0]['date'] . " </th><th>" . $showtime[0]['time'] . " </th>
                                                            <th>" . $location[0]['city'] . " </th><th>" . $seat[0]['seat_name'] . "</th> </tr>";
    }
    else {
        $html = "<tr><th colspan='5' style='text-align: center'>No orders found</th></tr>";
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

    <!--    get jquery api from google cdn-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--    link stylesheet-->
    <link rel="stylesheet" href="../styles/base.css" type="text/css">
    <link rel="stylesheet" href="../styles/navbar.css" type="text/css">
    <link rel="stylesheet" href="../styles/profile.css" type="text/css">

    <!--    link javascript-->
    <script src="../scripts/toggleSearch.js"></script>
    <script src="../scripts/showResult.js"></script>

    <!--    webpage title-->
    <title>Webtechnologie voor KI/INF 2022</title>
</head>

<body>
    <!--    navbar-->
    <nav>
        <a href="../index.php"><img id="logo" src="../images/logo-cinema.png" alt="logo cinema"/></a>

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
            <li class="nav-item"><a href="../pages/alleFilms.php">FILMS</a></li>
            <li class="nav-item"><a href="../pages/logout.php">LOGOUT</a></li>
        </ul>
    </nav>



    
        <header> <h1 class="header-gradient"> PROFILE </h1></header>
        <main>
            <article class = "profile">
                <div id="block">
                    <table>
                        <tr>
                            <th> Movie </th>
                            <th> Date </th>
                            <th> Time </th>
                            <th> location </th>
                            <th> Seat </th>
                        </tr>
<!--                        Print de waardes aan de hand van bovenstaande PHP code-->
                            <?php echo $html ?>

                    </table>
                </div>
            </article>
        </main>
    </body>
</html>
