
function reset(){
document.getElementById('nom').value = null;
document.getElementById('date').value = null;
document.getElementById('ville').value = "";
document.getElementById('orga').checked = false ;
document.getElementById('passe').checked = false;
document.getElementById('inscrit').checked = false;
document.getElementById('pasInscrit').checked = false;
}

$(document).ready(function () {
    $(".button_show").click(function () {
        $(".formulaire").fadeIn();
        $('.button_show').hide();
    });
    $(".button_close").click(function () {
        $(".formulaire").fadeOut();
        $('.button_show').show();

    });
})




