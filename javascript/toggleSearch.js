function toggleSearch() {
    var searchbar = document.getElementById("searchbar");
    var suggestions = document.getElementById("suggestions");
    var textbox = document.getElementById("textbox");

    textbox.value = "";

    if (!searchbar.style.display || searchbar.style.display === "none") {
        searchbar.style.display = "block";
    } else {
        searchbar.style.display = "none";

        //reset searchbox
        textbox.value = "";
        suggestions.innerHTML = "";
    }
}