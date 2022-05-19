function createCard(id) {
    let main = document.getElementById("main-container");

    // sourced from https://www.w3schools.com/PHP/php_ajax_database.asp
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            main.innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "/pages/movie-slide.php?id="+id, true);
    xmlhttp.send();
}
