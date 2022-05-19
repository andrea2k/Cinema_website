function display_information(information){
    document.getElementById("information-amsterdam").style.display="none";
    document.getElementById("information-rotterdam").style.display="none";
    document.getElementById("information-eindhoven").style.display="none";
    document.getElementById("information-denhaag").style.display="none";
    document.getElementById("information-utrecht").style.display="none";
    $(information).slideToggle(500);
}
