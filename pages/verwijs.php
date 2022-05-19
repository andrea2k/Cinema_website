<?php
    require ("../../config.php");

    $movie_id = $_GET['movie_id'];

    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        $pdo = new PDO($dsn, $read_user, $read_password);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $sql = "SELECT * FROM movie WHERE movie_id = :movie_id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['movie_id' => $movie_id]);

    $movie = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$movie) echo "fetching movie failed";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verwijs</title>

    <!--    custom icons from fontawesome-->
    <script src="https://kit.fontawesome.com/9458b18579.js" crossorigin="anonymous"></script>

    <!--    custom font from google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <!--    link stylesheets-->
    <link rel="stylesheet" href="../styles/base.css" type="text/css">
    <link rel="stylesheet" href="../styles/navbar.css" type="text/css">
    <link rel="stylesheet" href="../styles/verwijs.css" type="text/css">

    <!--    link javascript-->
    <script src="../scripts/toggleSearch.js"></script>
    <script src="../scripts/showResult.js"></script>

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

        <?php if (isset($_SESSION['user_id'])) {
            echo "<li class='nav-item'><a href='../pages/profile.php'>" . $_SESSION['user_id'] . "</a>";
        } else {
            echo "<li class='nav-item'><a href='../pages/signup.php'>SIGNUP</a></li>";
            echo "<li class='nav-item'><a href='../pages/login.php'>LOGIN</a></li>";
        }
        ?>

    </ul>
</nav>




<header>
    <h1 class="header-gradient"><?php echo $movie['title'] ?></h1>
</header>

<!--main has background image-->
    <main>
        <?php echo "<img src='" . $movie['poster_path'] . "'>"; ?>

<!--    this is where all the information will be-->
        <section>
            <h2 id="individual-movie-header"><?php echo $movie['title'] ?></h2>
            <div id="star-container">
                <?php
                    if ($movie['rating'] == 5) {
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                    }
                    else if ($movie['rating'] == 4) {
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                    }
                    else if ($movie['rating'] == 3) {
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                    }
                    else if ($movie['rating'] == 2) {
                        echo "<i class='fas fa-star'></i>";
                        echo "<i class='fas fa-star'></i>";
                    }
                    else if ($movie['rating'] == 1) {
                        echo "<i class='fas fa-star'></i>";
                    }
                ?>
            </div>
            <p class="description"><?php echo $movie['description'] ?></p>
            <button type="button"><a href="locations.php?movie_id=<?php echo $movie['movie_id'] ?>">BUY TICKETS</a></button>

        </section>
    </main>
</body>
</html>
