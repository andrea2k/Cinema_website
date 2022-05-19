<?php
    //connect to database
    require_once ("../../config.php");
function getNameFromID($user_id): string {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        $pdo = new PDO($dsn, $read_user, $read_password);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    if(!$pdo) echo "ERROR: can't connect to database";

    //fetch name from db
    $sql = "SELECT name FROM `users` WHERE user_id = $user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $name = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $name[0]['name'];
}


