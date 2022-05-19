//https://www.w3schools.com/PHP/php_ajax_livesearch.asp
function showResult(str) {
    let suggestions = document.getElementById("suggestions");

    if (str.length == 0) {
        suggestions.innerHTML = "";
        suggestions.style.border = "0px";
        return;
    }

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            suggestions.innerHTML = this.responseText;
        }
    }

    xmlhttp.open("GET", "/php/liveSearch.php?q=" + str, true);
    xmlhttp.send();
}

