<?php
require_once ("../../config.php");

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try{
$connection= new PDO ($dsn,$read_user,$read_password);

}catch(PDOException $error){
die($error);
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
    <link rel="stylesheet" href="../styles/tijd.css" type="text/css">

    <!--    webpage title-->
    <title>Webtechnologie voor KI/INF 2022</title>
</head>

<?php
$movie_id = $_GET['movie_id'];
$location_id = $_GET['location_id'];
if($location_id ==1 || $location_id ==2 || $location_id ==3 || $location_id ==4 || $location_id ==5){
    if ($location_id == 1){
        $location = "Amsterdam";
    }
    if ($location_id == 2){
        $location = "Rotterdam";
    }
    if ($location_id == 3){
        $location = "Den haag";
    }
    if ($location_id == 4){
        $location = "Eindhoven";
    }
    if ($location_id == 5){
        $location = "Utrecht";
    }
    echo "<h1 class='header-gradient'>$location</h1>";
    $sql = "SELECT * FROM movie WHERE movie_id = :movie_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute([':movie_id' => $movie_id]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);
    if($movie){    
        $title=$movie['title'];
        echo "<p class='title'>$title</p>";
        $sql="SELECT * FROM showtime WHERE movie_id =:movie_id AND location_id =:location_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute([':movie_id' => $movie_id,':location_id' => $location_id]);

        echo "<div class='grid-container'>";
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
            $showtime_id = $result['showtime_id'];
            $date = $result['date'];
            $time = $result['time'];
            echo "<a href=stoelen.php?showtime_id=$showtime_id class='grid-item'>$date $time</a>";
        }
    }
}
else{
    header("Location:../index.php");
}
?>
</html>
