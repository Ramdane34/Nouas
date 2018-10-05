<?php
$requete = $bdd->query("SELECT * FROM quests");
while($donnees = $requete->fetch())
{
    echo "<p><strong>".htmlspecialchars($donnees["nomquest"])."</strong> <a href='adminAddFormulaire.php?etape=3&nomquest=".htmlspecialchars($donnees["nomquest"])."'>Modifier</a> 
    <a href='adminModFormulaire.php?del=".$donnees["id"]."'>Supprimer</a></p>";
}
$requete->closeCursor();