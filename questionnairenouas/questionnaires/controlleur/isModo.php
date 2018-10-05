<?php
$isModo = false;
$requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
$requete->execute(array
(
    $_SESSION["id"]
));
while($donnee = $requete->fetch())
{
    if($donnee["type"] == "Modo")
    {
		$isModo = true;
    }
    else
    {
    	$isModo = false;
    }
}
$requete->closeCursor();