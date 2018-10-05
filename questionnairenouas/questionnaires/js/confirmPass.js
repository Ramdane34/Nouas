var contElt = document.querySelector("div");
var formElt = document.getElementById("envoi");
var erreurPasse = document.createElement("p");
erreurPasse.style.color = "red";
contElt.insertBefore(erreurPasse, formElt);
formElt.addEventListener("submit", function(e)
{
    var motpasse = formElt.elements.motpasse.value;
    var motpasse2 = formElt.elements.motpasse2.value;

    if(motpasse != motpasse2)
    {
	e.preventDefault();
	erreurPasse.textContent = "Les mots de passes ne sont pas identiques !";
    }
});