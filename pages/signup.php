<?php
    require_once '../../config.php';

session_start();

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try {
    $pdo = new PDO($dsn, $write_user, $write_password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$status = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // fetching info the user has given
    $name = $_POST["name"];
    $password = $_POST["password"];
    $password_check = $_POST["password_check"];
    $email = $_POST["email"];
    $emailrep = $_POST["email-rep"];

    // error handling
    if (empty($name) || empty($email) || empty($password) || empty($password_check)) {
        $status = "Make sure to fill in every field!";
    }

    // to check if the user is a human
    else if (!empty($emailrep)) {
        $status = "Begone, bots!";
    }

    else {

        // Username can't be longer than 10 characters and only a selected set of characters
        if (strlen($name) >= 25 || !preg_match("/^[a-zA-Z0-9'\s]+$/", $name)) {
            $status = "Please enter a valid name!";
        }

        // password can't be shorter than 6 characters
        else if (strlen($password) < 6) {
            $status = "Your password must be at least 6 characters!";
        }

        // Checks if given email really is an email
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = "Please enter a valid email!";
        }

        // Checks if password check and password are the same
        else if ($password_check != $password) {
            $status = "Please enter the same password!";
        }

        // Checks if user agrees with terms and conditions
        else if (!isset($_POST['termscons'])) {
            $status = "If you don't accept the terms and conditions, you won't be able to sign up!";
        }

        // if everything is more or less correct on the user's side...
        else {
            // Check if email is already in use
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $exist = $stmt->fetch();

            if ($exist) {
                $status = "Please use an e-mail adress which is not in use yet.";
            }

            else {;
                $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users(name, email, pw_hash) VALUES (:name,:email,:password)";

                try {
                    $query = $pdo->prepare($sql);
                    $query->execute(['name' => $name, 'email' => $email, 'password' => $hashed_pw]);
                    $status = "<label> Registration successful </label>";
                    header("location: login.php");
                }

                catch (Exception $e) {
                    $status = "<label> Username already exists, please choose a different one! </label> ";
                }
            }
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
    <link rel="stylesheet" href="../styles/signup.css" type="text/css">

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


<header><h1 class="header-gradient">SIGN UP</h1></header>
<form method = "POST" action="">
        <?php
            if (isset($status)){
                echo '<label class = "text-danger">'.$status.'</label>';
            }
        ?>

        <br>
        <article class = "Signup">
            <div class = "u_and_p">
                <div class = "Username">
                    <label for = name>USERNAME</label>
                    <input type="text" name= "name" style="color:black;text-align:center;" class="input">
                </div>

                <br>
                
                <div class = "Password">
                    <label for = password>PASSWORD</label>
                    <input type = "password" name = "password" style= "color:black;text-align:center;" class="input">
                </div>

                <br>

                <div class = "Password">
                    <label for = password>PASSWORD REPEAT</label>
                    <input type = "password" name = "password_check" style= "color:black;text-align:center;" class="input">
                </div>

                <br>

                <div class = "e-mail">
                    <label for = email>EMAIL</label>
                    <input type ="email" name = "email" style="color:black;text-align:center;" class="input">
                </div>

                <div class = "email-rep">
                    <input type = "email" name = "email-rep" style="display:none;text-align:center;" class = "input">                
                </div>
                <br>

                <div id = "consent">
                    <input type="checkbox" name = "termscons" value = "yes">
                    <label id = "consent-label" for = "termsandcons"> I agree to the <a href = "../privacyPolicy/termscons2.php">
                        terms and conditions
                    </a> and to our <a href = "../privacyPolicy/privacypol.php">Privacy Policy</a></label>
                </div>
            </div>

            <button id = "signup-button" type = "submit"> SIGN ME UP </button>
        </article>
    </form>
    <br>
    <br>
</body>
</html>
