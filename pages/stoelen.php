<?php
session_start();
require_once ("../../config.php");

$dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8mb4";

try{
$connection= new PDO ($dsn,$write_user,$write_password);

}catch(PDOException $error){
die($error);
}

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}
$user = $_SESSION['user_id'];

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
    <link rel="stylesheet" href="../styles/stoelen.css" type="text/css">

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
</nav>


<header>
    <h1 class="header-gradient">CHOOSE CHAIRS</h1>
    </header>

    <main>
        <ul id="seat-information">
            <li id="available">available</li>
            <li id="select">Selected</li>
            <li id="sold">Sold</li>
        </ul>
        <p id="seats"></p>

        <div id="screen"></div>

        <?php
        $showtime_id=$_GET['showtime_id'];
        $sql="SELECT taken FROM seat WHERE showtime_id = :showtime_id";
        $stmt = $connection->prepare($sql);
        $stmt->execute([':showtime_id' => $showtime_id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
                    
            <script>
                var seats=new Array;
                $(document).ready(function () {
                    $(".grid-item").click(function () {
                        if ($(this).css('background-color')=="rgb(209, 172, 0)"){
                            $(this).toggleClass("selected");
                            seats.push($(this).attr("id"));    
                            document.getElementById("seats").innerHTML = seats.length+" seats chosen";  
                        }
                        else if($(this).css('background-color')=="rgb(23, 184, 144)"){
                            $(this).toggleClass("selected");
                            const element = seats.indexOf($(this).attr("id"));
                            if(element>-1){
                                seats.splice(element,1);
                            }
                            document.getElementById("seats").innerHTML = seats.length+" seats chosen";
                        }
                    })
                });
            </script> 
        <form method="POST">
        <div class="grid-container">
            <input type="checkbox" name="seats[]" value="A1" class="grid-item taken_<?php echo $result[0]['taken'];?>">
            <input type="checkbox" name="seats[]" value="A2" class="grid-item taken_<?php echo $result[1]['taken'];?>">
            <input type="checkbox" name="seats[]" value="A3" class="grid-item taken_<?php echo $result[2]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A4" class="grid-item taken_<?php echo $result[3]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A5" class="grid-item taken_<?php echo $result[4]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A6" class="grid-item taken_<?php echo $result[5]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A7" class="grid-item taken_<?php echo $result[6]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A8" class="grid-item taken_<?php echo $result[7]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A9" class="grid-item taken_<?php echo $result[8]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="A10" class="grid-item taken_<?php echo $result[9]['taken'];?>">
            <input type="checkbox" name="seats[]" value="B1" class="grid-item taken_<?php echo $result[10]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B2" class="grid-item taken_<?php echo $result[11]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B3" class="grid-item taken_<?php echo $result[12]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B4" class="grid-item taken_<?php echo $result[13]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B5" class="grid-item taken_<?php echo $result[14]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B6" class="grid-item taken_<?php echo $result[15]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B7" class="grid-item taken_<?php echo $result[16]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B8" class="grid-item taken_<?php echo $result[17]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B9" class="grid-item taken_<?php echo $result[18]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="B10" class="grid-item taken_<?php echo $result[19]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C1" class="grid-item taken_<?php echo $result[20]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C2" class="grid-item taken_<?php echo $result[21]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C3" class="grid-item taken_<?php echo $result[22]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C4" class="grid-item taken_<?php echo $result[23]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C5" class="grid-item taken_<?php echo $result[24]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C6" class="grid-item taken_<?php echo $result[25]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C7" class="grid-item taken_<?php echo $result[26]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C8" class="grid-item taken_<?php echo $result[27]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C9" class="grid-item taken_<?php echo $result[28]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="C10" class="grid-item taken_<?php echo $result[29]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D1" class="grid-item taken_<?php echo $result[30]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D2" class="grid-item taken_<?php echo $result[31]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D3" class="grid-item taken_<?php echo $result[32]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D4" class="grid-item taken_<?php echo $result[33]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D5" class="grid-item taken_<?php echo $result[34]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D6" class="grid-item taken_<?php echo $result[35]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D7" class="grid-item taken_<?php echo $result[36]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D8" class="grid-item taken_<?php echo $result[37]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D9" class="grid-item taken_<?php echo $result[38]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="D10" class="grid-item taken_<?php echo $result[39]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E1" class="grid-item taken_<?php echo $result[40]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E2" class="grid-item taken_<?php echo $result[41]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E3" class="grid-item taken_<?php echo $result[42]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E4" class="grid-item taken_<?php echo $result[43]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E5" class="grid-item taken_<?php echo $result[44]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E6" class="grid-item taken_<?php echo $result[45]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E7" class="grid-item taken_<?php echo $result[46]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E8" class="grid-item taken_<?php echo $result[47]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E9" class="grid-item taken_<?php echo $result[48]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="E10" class="grid-item taken_<?php echo $result[49]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F1" class="grid-item taken_<?php echo $result[50]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F2" class="grid-item taken_<?php echo $result[51]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F3" class="grid-item taken_<?php echo $result[52]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F4" class="grid-item taken_<?php echo $result[53]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F5" class="grid-item taken_<?php echo $result[54]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F6" class="grid-item taken_<?php echo $result[55]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F7" class="grid-item taken_<?php echo $result[56]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F8" class="grid-item taken_<?php echo $result[57]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F9" class="grid-item taken_<?php echo $result[58]['taken'];?>"> 
            <input type="checkbox" name="seats[]" value="F10" class="grid-item taken_<?php echo $result[59]['taken'];?>"> 
        </div>
            <button type="submit" id="seat-select-done" name="done">DONE</button>
            </form>
            
        <?php
        if(isset($_POST['done'])){
            if(isset($_POST['seats']) AND is_array($_POST['seats'])){
                foreach($_POST['seats'] as $seats){
                $sql="SELECT * FROM seat WHERE seat_name=:seat AND showtime_id =:showtime_id";
                $stmt = $connection->prepare($sql);
                $stmt->execute(['seat' => $seats,'showtime_id' => $showtime_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($result['taken'] == 1){
                    $seat_name = $result['seat_name'];
                    echo "<script>alert('$seat_name has been taken')</script>";
                    }
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                foreach($_POST['seats'] as $seats){
                $sql="UPDATE seat SET taken = 1 WHERE seat_name=:seat AND showtime_id =:showtime_id";
                $stmt = $connection->prepare($sql);
                $stmt->execute(['seat' => $seats,'showtime_id' => $showtime_id]);
                }
                    echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                $message = "Select at least one seat!";
                echo "<script>alert('$message')</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
        ?>
    </main>


</body>

</html>
