<?php
$movie_id = $_GET['movie_id'];
?>
<!doctype html>
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
    <link rel="stylesheet" href="../styles/locations.css" type="text/css">

<!--    link scripts-->
    <script src="../scripts/locations.js"></script>

    <!--    webpage title-->
    <title>Webtechnologie voor KI/INF 2022</title>

    <body>
        
        <h1 class="header-gradient">CHOOSE LOCATION</h1>
        <ul class="location">
            <div id="Amsterdam" class="ul-item" onclick="display_information('#information-amsterdam')"> Amsterdam</div>
            <div id ="Rotterdam" class="ul-item" onclick="display_information('#information-rotterdam')"> Rotterdam </div>
            <div id ="Denhaag" class="ul-item" onclick="display_information('#information-denhaag')"> Den Haag </div>
            <div id ="Eindhoven" class="ul-item" onclick="display_information('#information-eindhoven')"> Eindhoven </div>
            <div id ="Utrecht" class="ul-item" onclick="display_information('#information-utrecht')"> Utrecht </div>
        </ul>


        <div id ="information-amsterdam" class="information">
            <div class="head">The opening times and adress for our location in Amsterdam are :</div>
            <p>MON - THU: 09.30 AM – 10.00 PM <br><br>
            FRI - SUN: 11.00 AM – 11.30 PM <br><br>
            Adres: Dam 300, 1078 FE Amsterdam</p>
            <a href="tijd.php?location_id=1&movie_id=<?php echo $movie_id?>"><button class="button" name="go_amsterdam">Go</button></a>
        </div>
        
        <div id ="information-rotterdam" class="information"> 
            <div class="head">The opening times and adress for our location in Rotterdam are :</div>
            <p>MON - THU: 09.30 AM – 10.00 PM <br><br>
            FRI - SUN: 11.00 AM – 11.30 PM <br><br>
            Adres: Erasmusbrug 800, 1008 FE Rotterdam</p>
            <a href="tijd.php?location_id=2&movie_id=<?php echo $movie_id?>"><button class="button" name="go_rotterdam">Go</button></a>
        </div>
        
        <div id ="information-eindhoven" class="information"> <p>
            <div class="head">The opening times and adress for our location in Eindhoven are :</div>
            <p>MON - THU: 09.30 AM – 10.00 PM <br><br>
            FRI - SUN: 11.00 AM – 11.30 PM <br><br>
            Adres: Prins hendrikstraat 120, 1071 Bl Eindhoven</p>
            <a href="tijd.php?location_id=4&movie_id=<?php echo $movie_id?>"><button class="button" name="go_eindhoven">Go</button></a>
        </div>
        
        <div id ="information-denhaag" class="information"> <p>
            <div class="head">The opening times and adress for our location in Den Haag are :</div>
            <p>MON - THU: 09.30 AM – 10.00 PM <br><br>
            FRI - SUN: 11.00 AM – 11.30 PM <br><br>
            Adres: Parlement 34, 1234 PK Den Haag</p>
            <a href="tijd.php?location_id=3&movie_id=<?php echo $movie_id?>"><button class="button" name="go_denhaag">Go</button></a>
        </div>
        
        <div id ="information-utrecht" class="information"> 
            <div class="head">The opening times and adress for our location in Utrecht are :</div>
            <p>MON - THU: 09.30 AM – 10.00 PM <br><br>
            FRI - SUN: 11.00 AM – 11.30 PM <br><br>
            Adres: lange Nieuwstraat 52, 1402 RT Utrecht</p>
            <a href="tijd.php?location_id=5&movie_id=<?php echo $movie_id?>"><button class="button" name="go_utrecht">Go</button></a>
        </div>

    </body> 
</html>
