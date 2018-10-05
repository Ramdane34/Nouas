    <?php
		session_start();
    		include('../../../bddConnect.php');
		include('head.php');
		$pagecharger="pagePerso.php";
    		include("nav.php");    				
		echo "<div class='container' style='margin-top:30px'>";

    
    //Récuparation compte connecté
	if(isset($_SESSION["email"])){
		$select_profil = $bdd->prepare("
		SELECT account.id, email, password, image, type, statut, statut, root, nom, prenom, annee_naissance, mois_naissance, jour_naissance, adresse, complement_adresse, ville, code_postal, telephone, formation, account_id, civilite, structure_prescriptrice, prescripteur, projet_professionnel, formation_visee, permis_B, permis, vehicule 
		FROM account
		INNER JOIN account_details
		ON account.id = account_details.account_id AND account.email = ?");
		$select_profil->execute(array($_SESSION["email"]));
		$profil_infos = $select_profil->fetch(); 
	                             }
    //si l'utilisateur est connecté
    if($isCo)
    {
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
  			echo "<div class='row'>";
    			echo "<div class='col-sm-4'>";
			echo "<h2>Mes Infos</h2>";
			echo "<div class=''container-fluid'>";
			include("mesinfos.php");
			echo "</div></div><div class='col-sm-8'>
    			<div id='quests'><h2>Mes résultats</h2>
<div class='container-fluid'>			
  <table class='table table-striped'>
    <thead>
      <tr>
        <th>Nom du Questionnaire</th>
        <th>Evaluation</th>
        <th>Résultat</th>
      </tr>
    </thead>
    <tbody>
";
 
    			$requete = $bdd->prepare("SELECT * FROM resultats WHERE idmembre = ?");
			$requete->execute(array
			(
	            	$_SESSION["id"]
			));
			while($questionnairesFinis = $requete->fetch())
			{
	            	$reponse = $bdd->prepare("SELECT * FROM quests WHERE id = ?");
	            	$reponse->execute(array
	            	(
			$questionnairesFinis["idquest"]
	            	));
	           	while($nomQuest = $reponse->fetch())
	            		{
				echo "
      <tr>
        <td>".$nomQuest["nomquest"]."</td>
        <td><img src='../images/note.png' width='50' height='30'</td>
        <td>".number_format($questionnairesFinis["note"], 2)."/20</td>
      </tr>";

	            		}
	            		$reponse->closeCursor();
			}
			$requete->closeCursor();
			echo "</tbody>
  </table></div>";
  			echo "</div></div></div>";


// -----------En trop ???----------->
/*
echo "<div id='quests'>
<h2>Mes résultats</h2>
<p>Nom : ".$profil_infos["prenom"] ." ".$profil_infos["nom"]."</p>
<p>Moyenne : ".$moyenne."/20.00<br/></p>
<h2>Questionnaires terminés</h2>";

		$requete = $bdd->prepare("SELECT * FROM resultats WHERE idmembre = ?");
		$requete->execute(array
		(
	            $_SESSION["id"]
		));
		while($questionnairesFinis = $requete->fetch())
		{
	            $reponse = $bdd->prepare("SELECT * FROM quests WHERE id = ?");
	            $reponse->execute(array
	            (
			$questionnairesFinis["idquest"]
	            ));
	            while($nomQuest = $reponse->fetch())
	            {
			echo "<p>".$nomQuest["nomquest"].", Note : ".number_format($questionnairesFinis["note"], 2)."/20.00</p>";
	            }
	            $reponse->closeCursor();
		}
		$requete->closeCursor();
		echo "</div>";*/
// <-----------En trop ???-----------
        
    }
    else
    {
	echo "<p><a href='../../../index.php'>Connectez vous</a> pour avoir accès aux questionnaires.</p>";
    }
echo "</div></div>";
// -----------DEBUT Navigation FOOTER----------->
                            echo "<div class='container' style='margin-top:10px'>
                                <div class='card text-center'>
                                    <div class='card-header'>
                                        <ul class='nav nav-pills card-header-pills'>
                                                <li class='nav-item'>
                                                    <a class='nav-link' href='index.php'>Accueil</a>
                                                </li>
                                            <li class='nav-item'>
                                                    <a class='nav-link active' href='pagePerso.php' >Mes résultats</a>
                                                </li>
                                                                                            </li>
                                            <li class='nav-item'>
                                                    <a class='nav-link' href='questionnaire.php' >Questionnaires</a>
                                            </li>";
                            if($isCo)
                            {
                                            echo "<li class='nav-item'>
                                                    <a class='nav-link' href='adminIndex.php'>Administration</a>
                                                </li>";
                            }
                                            echo "<li class='nav-item'>
                                                    <a class='nav-link disabled' href='../../../index.php'>Retour</a>
                                                </li>
                                            </ul>
                                    </div>";
                            include("footer.php");
// <----------- FIN Navigation FOOTER  -----------
    ?>
