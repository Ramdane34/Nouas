<?php
//session_start();
if(isset($_SESSION["email"])){
$select_profil = $bdd->prepare("
SELECT account.id, email, password, image, type, statut, statut, root, nom, prenom, annee_naissance, mois_naissance, jour_naissance, adresse, complement_adresse, ville, code_postal, telephone, formation, account_id, civilite, structure_prescriptrice, prescripteur, projet_professionnel, formation_visee, permis_B, permis, vehicule 
FROM account
INNER JOIN account_details
ON account.id = account_details.account_id AND account.email = ?");
$select_profil->execute(array($_SESSION["email"]));
$profil_infos = $select_profil->fetch(); 
                         }

$moyenne = 0;


$requete = $bdd->prepare("SELECT AVG(note) AS moyenne FROM resultats WHERE idmembre = ?");
$requete->execute(array
(
    $_SESSION["id"]
));
while($reponseMoyenne = $requete->fetch())
{
        $moyenne = $reponseMoyenne["moyenne"];
}
$requete->closeCursor();
$moyenne = number_format($moyenne, 2);
 echo "<div class='list-group'>
    			
<p class='list-group-item list-group-item-action list-group-item-secondary'>Nom : ".$profil_infos["prenom"] ." ".$profil_infos["nom"]."</p>
	<p class='list-group-item list-group-item-action list-group-item-secondary'>Moyenne : ".$moyenne."/20.00<br/></p></div>";
?>