<?php

//import creds
require_once ('../../config.php');

//data source name
$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    //set up new pdo instance
    $pdo = new PDO($dsn, $read_user, $read_password);

} catch (PDOException $e) {
    echo "something went wrong while fetching movie information from database!";
    $e->getMessage();
}

    //check if connection has been made
    if (!$pdo) die("can't connect to db");

    //get integer value id of movie from get request
    $id = intval($_GET['id']);

    //check if requested movie is exists
    $sql = "SELECT * FROM movie WHERE movie_id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $id]);
    $movie = $statement->fetch(PDO::FETCH_ASSOC);

    //movie id not found, fall back to movie id 1
    if (!$movie) {
        $id = 1;
        $sql = "SELECT * FROM movie WHERE movie_id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([':id' => $id]);
        $movie = $statement->fetch(PDO::FETCH_ASSOC);
    }
    $movie_id = $movie['movie_id'];
    $prev = $id - 1;
    $next = $id + 1;

    //generate template with movie information
    echo "<main>";
    echo "<i class='fas fa-arrow-left' onclick='createCard($prev)'></i>";
    echo "<section>";
    echo "<h1>" . $movie['title'] . "</h1>";
    echo "<p>" . $movie['description'] . "</p>";
    echo "<button type='button' onclick=window.location.href='pages/locations.php?movie_id=$movie_id'>BUY TICKETS</button>";
    echo "</section>";
    echo "<img src='" . $movie['poster_path'] . "' alt='movie poster'>";
    echo "<i class='fas fa-arrow-right' onclick='createCard($next)'></i>";
    echo "</main>";


