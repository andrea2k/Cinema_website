<?php

require_once ("../../config.php");
//require_once ("../php/authenticate.php");
//authenticate($_SESSION['user+id'], 'admin');

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    $connection = new PDO($dsn, $write_user, $write_password);

    if (!$connection) die("can't connect to db");

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Dit maakt een showtime voor elke film op elke locatie. Niet 24/7 maar 12 uur op een dag en dan om de minuut.
// Dus er draait een film op elke locatie 12 uur lang op een dag om de minuut.
try {
    $stmt = $connection->prepare("SELECT movie_id FROM `movie`");
    $stmt->execute();
    $movieID = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $count = count($movieID);

    for ($x = 0; $x < $count; $x++) {
        $movie_id = $movieID[$x];

        $stmt = $connection->prepare("SELECT location_id FROM `location`");
        $stmt->execute();
        $locationID = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $count2 = count($locationID);

        for ($y = 0; $y < $count2; $y++) {
            $location_id = $locationID[$y];

            $startdate=strtotime("4 february 2022 10:00");

                    $date = date("Y-m-d", $startdate);
                    $time = date ("h:i:s", $startdate);
                    
                    $sql = "INSERT INTO showtime (movie_id, location_id, date, time) VALUES (:movie_id, :location_id, :date, :time)";
                    $query = $connection->prepare($sql);
                    $query->execute(['movie_id' => $movie_id, 'location_id' => $location_id, 'date' => $date, 'time' => $time]);

                    $sql = "SELECT showtime_id FROM showtime
                    ORDER BY showtime_id DESC";
                    $query = $connection->prepare($sql);
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
                    $query = $connection->prepare($sql);
                    $query->execute();
            }  
        }
    echo "<script>alert('Successfully added');</script>";
}

catch (PDOException $error) {
    echo $error.getMessage();
}


