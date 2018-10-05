<?php


$requete = $bdd->query("SELECT * FROM quests");

while($donnees = $requete->fetch())
{
    $rempli = false;
    for($i = 0; $i < count($questionnairesRemplis); $i++)
    {
	if($questionnairesRemplis[$i] == $donnees["id"])
	{
        $rempli = true;
        echo "<p class='list-group-item list-group-item-action list-group-item-secondary'><a href='questionnaire.php?id=".$donnees["id"]."'>".htmlspecialchars($donnees["nomquest"])." (".htmlspecialchars($donnees["theme"]).") <span class='btn btn-success'>Terminé</span></p>";
        
	}
    }
    if($rempli == false)
    {
    	echo "<p class='list-group-item list-group-item-action list-group-item-secondary'><a href='questionnaire.php?id=".$donnees["id"]."'>".htmlspecialchars($donnees["nomquest"])."</a> (".htmlspecialchars($donnees["theme"]).") </p>";
    }

}
$requete->closeCursor();

?>