<?php
require_once('../../config.php');

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    $pdo = new PDO($dsn, $write_user, $write_password);

    if (!$pdo) die("can't connect to db");

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

session_start();
require_once ("../php/authenticate.php");
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else $user_id = null;
authenticate($user_id, 'admin');

?>

<!DOCTYPE html>
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
    <link rel="stylesheet" href="../styles/Admin.css" type="text/css">

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


<header>
    <h1 class="header-gradient">Admin Page</h1>
</header>

<article class="Movie_invoegen">
    <form action="" method = "POST">

        <div id="add-button">
            <button type="submit" id="add-button" name="add">Add Showtime</button>
        </div>

        <div id="add-input">

            <label for="movie_id">Movie_id</label>
            <select name="movie_id">
                <?php
                    $sql="SELECT movie_id FROM movie";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value=$result[movie_id]>$result[movie_id]</option>";
                    }
                ?>
            </select>

            <label for="location">Location</label>
            <select name="location" id="location">
                <option value="1">Amsterdam</option>
                <option value="3">Den Haag</option>
                <option value="4">Eindhoven</option>
                <option value="2">Rotterdam</option>
                <option value="5">Utrecht</option>
            </select>

            <label for="date">Date</label>
            <input class="submit" type="date" id="date" name="date">

            <label for="time">Time</label>
            <input class="submit" type="time" id="time" name="time">

        </div>
    </form>

    <form action="" method ="POST">

        <div id="delete-button">
            <button type="submit" id="delete-button" name="delete">Delete Showtime</button>
        </div>

        <div id="delete-input">
            <label for="showtime_id">Showtime_id</label>
            <select name="showtime_id" id="showtime_id">
                <?php
                    $sql="SELECT showtime_id FROM showtime";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value=$result[showtime_id]>$result[showtime_id]</option>";
                    }
                ?>
            </select>
        </div>

    </form>

    <?php
    if(isset($_POST['add'])){
        $movie_id = $_POST["movie_id"];
        $location_id = $_POST["location"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        // error handling
        if (empty($movie_id) || empty($location_id) || empty($date) || empty($time)) {
            echo "<script>alert('Some fields are empty');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
        else {
            $sql = "INSERT INTO showtime(movie_id, location_id, date, time) VALUES (:movie_id,:location_id,:date,:time)";

            $query = $pdo->prepare($sql);
            $query->execute(['movie_id' => $movie_id, 'location_id' => $location_id, 'date' => $date, 'time' => $time]);

            $sql = "SELECT showtime_id FROM showtime
            ORDER BY showtime_id DESC";
            $query = $pdo->prepare($sql);
            $query->execute();
            $result=$query->fetch(PDO::FETCH_ASSOC);
            $id = $result['showtime_id'];
            $sql = "INSERT INTO seat (seat_name,taken,showtime_id)	
            VALUES
            ('A1',0,$id),('A2',0,$id),('A3',0,$id),('A4',0,$id),('A5',0,$id),
            ('A6',0,$id),('A7',0,$id),('A8',0,$id),('A9',0,$id),('A10',0,$id),
            ('B1',0,$id),('B2',0,$id),('B3',0,$id),('B4',0,$id),('B5',0,$id),
            ('B6',0,$id),('B7',0,$id),('B8',0,$id),('B9',0,$id),('B10',0,$id),
            ('C1',0,$id),('C2',0,$id),('C3',0,$id),('C4',0,$id),('C5',0,$id),
            ('C6',0,$id),('C7',0,$id),('C8',0,$id),('C9',0,$id),('C10',0,$id),
            ('D1',0,$id),('D2',0,$id),('D3',0,$id),('D4',0,$id),('D5',0,$id),
            ('D6',0,$id),('D7',0,$id),('D8',0,$id),('D9',0,$id),('D10',0,$id),
            ('E1',0,$id),('E2',0,$id),('E3',0,$id),('E4',0,$id),('E5',0,$id),
            ('E6',0,$id),('E7',0,$id),('E8',0,$id),('E9',0,$id),('E10',0,$id),
            ('F1',0,$id),('F2',0,$id),('F3',0,$id),('F4',0,$id),('F5',0,$id),
            ('F6',0,$id),('F7',0,$id),('F8',0,$id),('F9',0,$id),('F10',0,$id)";
            $query = $pdo->prepare($sql);
            $query->execute();
            echo "<script>alert('Successfully added');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
    else if(isset($_POST['delete'])) {
        $showtime_id = $_POST['showtime_id'];
        if(empty($showtime_id)) {
            echo "<script>alert('Some fields are empty');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
        else {
            $sql = "DELETE FROM seat WHERE showtime_id = :showtime_id";
            $query = $pdo->prepare($sql);
            $query->execute(['showtime_id' => $showtime_id]);
            $sql=  "SET @number:=0;
                    UPDATE seat SET seat_id=@number:=(@number+1);
                    ALTER TABLE seat AUTO_INCREMENT = 1;";
            $query = $pdo->prepare($sql);
            $query->execute();

            $sql = "DELETE FROM showtime WHERE showtime_id = :showtime_id";
            $query = $pdo->prepare($sql);
            $query->execute(['showtime_id' => $showtime_id]);
            $sql= "SET @number:=0;
                   UPDATE showtime SET showtime_id=@number:=(@number+1);
                   ALTER TABLE showtime AUTO_INCREMENT = 1;";
            $query = $pdo->prepare($sql);
            $query->execute();

            echo "<script>alert('Successfully deleted');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }

    ?>
</article>

</body>
</html>
