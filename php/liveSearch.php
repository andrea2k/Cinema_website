<?php

//import creds
require_once ('../../config.php');

//connect to database
$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    //set up new pdo instance
    $pdo = new PDO($dsn, $read_user, $read_password);
} catch (PDOException $e) {
    $e->getMessage();
}

//check if connection has been made
if (!$pdo) die("can't connect to db");

//get parameter from url
$q = $_GET['q'];

$hint = "";

if (strlen($q)>0) {
    //get 3 best matches
    $sql = "SELECT title, poster_path FROM movie WHERE title LIKE :search LIMIT 3";
    $statement = $pdo->prepare($sql);
    $statement->execute([':search' => '%' . $q . '%']);
    $suggestions = $statement->fetchALL(PDO::FETCH_ASSOC);

    foreach ($suggestions as $suggestion) {

        if ($hint == "") {
            $hint = $suggestion['title'] . "<br>";
        } else {
            $hint .= $suggestion['title'] . "<br>";
        }
    }
}

if ($hint == "") {
    $response = "No suggestions";
} else {
    $response = $hint;
}
echo $response;