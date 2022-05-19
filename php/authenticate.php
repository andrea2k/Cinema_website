<?php
require ("../../config.php");

function is_admin($userID): bool {
    require ("../../config.php");
    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        //set up new pdo instance
        $pdo = new PDO($dsn, $read_user, $read_password);
    } catch (PDOException $e) {
        die ($e->getMessage());
    }

    //check if connection has been made
    if (!$pdo) die("Failed to create pdo object");

    //check if user is admin
    $sql = "SELECT is_admin FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['is_admin']) {
        return true;
    } else return false;
};

function is_user($userID): bool {
    require ("../../config.php");
    $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

    try {
        //set up new pdo instance
        $pdo = new PDO($dsn, $read_user, $read_password);

        //check if connection has been made
        if (!$pdo) die("Failed to create pdo object");
    } catch (PDOException $e) {
        die ($e->getMessage());
    }

    //check if userID exists
    $sql = "SELECT count(1) AS num FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userID]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //admins are not users
    if ($row['num'] && !is_admin($userID)) {
        return true;
    } else {
        return false;
    }
};

function user_has_access($user_id, $privilage): bool
{
    if ($privilage == 'admin') {
        return is_admin($user_id);
    } else if ($privilage == 'user') {
        return is_user($user_id);
    } else {
        //no privilage needed
        return true;
    }
}

function authenticate($user_id, $privilage) {
    if (!user_has_access($user_id, $privilage)) {
        header("location: ../index.php");
    }
}
