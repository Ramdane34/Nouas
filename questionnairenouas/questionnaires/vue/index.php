<?php
  session_start();
  $pagecharger="index.php";
  include('../../../bddConnect.php');
	include('head.php');	
   include("nav.php");				     				
	echo "<div class='container' style='margin-top:30px'>";				
  //si l'utilisateur est connecté
    include("../controlleur/isCo.php");
    	if($isCo) {												
    		$questionnairesRemplis = [];
    		$requete = $bdd->prepare("SELECT * FROM resultats WHERE idmembre = ?");
    		$requete->execute(array($_SESSION["id"]));
    			while($questionnairesFinis = $requete->fetch()) {
            							array_push($questionnairesRemplis, $questionnairesFinis["idquest"]);
                                        //echo "While2";
    			}
    		$requete->closeCursor();
// -----------DEBUT 1 Blocks ----------->							
  			echo "<div class='row'>
    			<div class='col-sm-4'>
					<h2>Mes Infos</h2>
					<div class='container-fluid'>";
				include("mesinfos.php");
				echo "</div></div><div class='col-sm-8'>
    		  <div id='quests'><h2>Liste des Questionnaires</h2>
				  <div 'container-fluid'>";
    		include("questionnaires.php");
    		echo "</div></div></div>";
// -----------DEBUT 2 Blocks ----------->
   		} else {
    		echo "<p><a href='../../../index.php' style='color: #ED9A3B;'>Connectez vous</a> pour avoir accès aux questionnaires.</p>";
    	}
// -----------DEBUT Navigation FOOTER----------->
                            echo "<div class='container' style='margin-top:10px'>
                                <div class='card text-center'>
                                    <div class='card-header'>
                                        <ul class='nav nav-pills card-header-pills'>
                                                <li class='nav-item'>
                                                    <a class='nav-link active' href='index.php'>Accueil</a>
                                                </li>
                                            <li class='nav-item'>
                                                    <a class='nav-link' href='pagePerso.php' >Mes résultats</a>
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