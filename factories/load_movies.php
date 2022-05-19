<?php
require_once ("../../config.php");
//require_once ("../php/authenticate.php");
//authenticate($_SESSION['user_id'], 'admin');

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    $pdo = new PDO($dsn, $write_user, $write_password);
} catch (PDOException $e) {
    die($e->getMessage());
}

    if(!$pdo) echo "ERROR: can't connect to database";

    //url for getting top rated movies
    $url = "https://api.themoviedb.org/3/movie/top_rated?api_key=$api_key";

    //fetch response
    $response = file_get_contents($url);
    $jsonobj = json_decode($response);

    $image_url = "https://image.tmdb.org/t/p/w500/";

    //sql statement to prepare
    $sql = "INSERT INTO 
    movie (title, rating, description, poster_path, lang)
    VALUES (:title, :rating, :description, :poster_path, :lang)";
    $statement = $pdo->prepare($sql);

    //loop over response objects
    foreach ($jsonobj->results as $movie) {
        $title = $movie->title;
        $rating = $movie->vote_average / 2;
        $description = $movie->overview;
        $poster_path = $image_url . $movie->poster_path;
        $lang = $movie->original_language;

        $succeeded = $statement->execute([
            ':title' => $title,
            ':rating' => $movie->vote_average / 2,
            ':description' => $movie->overview,
            ':poster_path' => $image_url . $movie->poster_path,
            ':lang' => $movie->original_language,
        ]);

        if (!$succeeded) die("no movies where added");
    }


