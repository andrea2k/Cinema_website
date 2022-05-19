<?php
    require_once ("../../config.php");

// start a session to keep user logged in
session_start();

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

$status = "";

// if the user has clicked on the login button
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST["name"];
    $password = $_POST["password"];

    if (empty($name) && empty($password)) {
        $status = "<label> Please make sure to fill in all fields! </label>";
    }

    // if a user hasn't filled in a username
    else if(empty($name)) {
        $status = '<label> Please make sure to fill in a username! </label>';
    }

    // if a user hasn't filled in a password
    else if (empty($password)) {
        $status = "<label> Please make sure to fill in your password! </label>";
    }

    // if everything has been filled in
    else {
        try {
            $connection = new PDO($dsn, $read_user, $read_password);
            $stmt = $connection->prepare("SELECT * FROM users WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // if the username exists in the database
            if($stmt->rowCount() > 0){

                // if the name in the db and username as user input are the same
                if ($name == $row['name']) {

                    // if the right password has been filled in
                    if (password_verify($password, $row["pw_hash"])) {
                        $user_id = $row["user_id"];
                        $_SESSION["user_id"] = $user_id;
                        $status = "<label> You're logged in. </label>";
                        if ($row['is_admin'] == 0) {
                            header("location: profile.php?user_id=$user_id");
                        }
                        else if ($row['is_admin'] == 1){
                            header("location: admin.php?user_id=$user_id");
                        }
                    }

                    // if the wrong password has been filled in
                    else {
                        $status = "<label> Wrong password, please try again. </label>";
                    }
                }

                // if the username doesn't exist
                else {
                    $status = "<label> Wrong username, please try again. </label>";
                }
            }

            // if the username doesn't exist
            else {
                $status = "<label> Wrong username, would you like to sign up? </label>";
            }
        }

            // if anything else goes wrong
        catch (PDOException $error) {
            $status = $error.getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
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
    <link rel="stylesheet" href="../styles/login.css" type="text/css">

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
        <li class="nav-item"><a href="../pages/signup.php">SIGNUP</a></li>
        <li class="nav-item"><a href="../pages/login.php">LOGIN</a></li>
    </ul>
</nav>

<header><h1 class="header-gradient">LOGIN</h1></header>
<?php
        if (isset($status)){
            echo '<label class = "text-danger">'.$status.'</label>';
        }
    ?>
    <br>
        <article class="Login"> 
            <form method = "POST">                        
                    <div class="u_and_p">
                        <label for = fname>USERNAME</label>
                        <input class="submit" type="text" name="name" style="color:black;text-align:center;">
                        <br>

                        <label for = fpassword>PASSWORD</label>
                        <input class="submit" type="password" name="password" style="color:black;text-align:center;">
                    </div>

                    <br>

                    <div id="buttons-container">
                        <button type="submit" id="login-button"> LOGIN </button>
                       
                    </div>
            </form>

            <button id="signup-button" onclick="location.href='signup.php'"> SIGN ME UP </button>

            <div class ="footer1">
                <a href = ../privacyPolicy/termscons2.php> Terms & conditions </a>
            </div>

        </article>
    </body>
</html>
