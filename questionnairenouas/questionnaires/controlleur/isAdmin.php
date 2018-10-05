<?php
include("../../../bddConnect.php");
$requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
$requete->execute(array
(
    $_SESSION["id"]
));
$donnee = $requete->fetch();
if($donnee["type"] == "Admin" || $donnee["type"] == "Modo")
{
    $isAdmin = true;
}
else
{
    $isAdmin = false;
}
$requete->closeCursor();
$isAdmin = true;
