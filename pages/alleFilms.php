<?php
    session_start();
    require_once ("../../config.php");

    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        $pdo = new PDO($dsn, $read_user, $read_password);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    if (!$pdo) die("can't connect to db");

    $catogorie = "Crime";

    $sql = "SELECT * FROM movie WHERE category = :catogorie";
    $statement = $pdo->prepare($sql);
    $statement->execute(['catogorie' => $catogorie]);

    $movie = $statement->fetchall(PDO::FETCH_ASSOC);

    if (!$movie) echo "fetching movie failed";

    if (isset($_SESSION['user_id'])) {
        $user = $_SESSION['user_id'];

        $sql = "SELECT name, is_admin FROM `users` WHERE user_id = $user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $name = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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
    <link rel="stylesheet" href="../styles/style_films.css" type="text/css">

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

        <?php if (isset($_SESSION['user_id'])) {
            if ($name[0]['is_admin'] == 1) {
                echo "<li class='nav-item'><a href='../pages/admin.php'>" . $name[0]['name'] . "</a>";
            }
            else {
                echo "<li class='nav-item'><a href='../pages/profile.php'>" . $name[0]['name'] . "</a>";
            }
        } else {
            echo "<li class='nav-item'><a href='../pages/signup.php'>SIGNUP</a></li>";
            echo "<li class='nav-item'><a href='../pages/login.php'>LOGIN</a></li>";
        }
        ?>

    </ul>
</nav>


<header>
    <h1 class="header-gradient">ALL MOVIES</h1>
</header>


    <main>
        <section>
            <h3 class="genre-title">Crime Movies</h3>
            <div class="genre-container">

                <figure class="item1">
                    <a href="verwijs.php?movie_id=<?php echo $movie[0]['movie_id']?>">
                        <?php echo "<img src='" . $movie[0]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[0]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[1]['movie_id']?>">
                        <?php echo "<img src='" . $movie[1]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[1]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[2]['movie_id']?>">
                        <?php echo "<img src='" . $movie[2]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[2]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[3]['movie_id']?>">
                        <?php echo "<img src='" . $movie[3]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[3]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[4]['movie_id']?>">
                        <?php echo "<img src='" . $movie[4]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[4]['title']?></figcaption>
                </figure>
            </div>
        </section>

        <?php

        $catogorie = "Romance";

        $sql = "SELECT * FROM movie WHERE category = :catogorie";
        $statement = $pdo->prepare($sql);
        $statement->execute([':catogorie' => $catogorie]);

        $movie = $statement->fetchall(PDO::FETCH_ASSOC);

        ?>


        <section>
            <h3 class="genre-title">Romantic Movies</h3>
            <div class="genre-container">

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[0]['movie_id']?>">
                        <?php echo "<img src='" . $movie[0]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[0]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[1]['movie_id']?>">
                        <?php echo "<img src='" . $movie[1]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[1]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[2]['movie_id']?>">
                        <?php echo "<img src='" . $movie[2]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[2]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[3]['movie_id']?>">
                        <?php echo "<img src='" . $movie[3]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[3]['title']?></figcaption>
                </figure>

                <figure>
                    <a href="verwijs.php?movie_id=<?php echo $movie[4]['movie_id']?>">
                        <?php echo "<img src='" . $movie[4]['poster_path'] . "'>"; ?>
                    </a>
                    <figcaption><?php echo $movie[4]['title']?></figcaption>
                </figure>
            </div>
        </section>
    </main>
</body>
</html>
