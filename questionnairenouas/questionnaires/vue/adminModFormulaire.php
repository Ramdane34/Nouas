<?php
    session_start();
    include("../controlleur/isCo.php");
    include('../../../bddConnect.php');
    include('head.php');
    include("nav.php");
    //si l'utilisateur est connecté
    if($isCo)
    {
	include("../controlleur/isAdmin.php");
    echo "<div class='container' style='margin-top:30px'>";     
	if($isAdmin == true)
	{
            if(isset($_GET["del"]))
            {
		$requete = $bdd->prepare("DELETE FROM quests WHERE id = ?");
		$requete->execute(array
		(
                    $_GET["del"]
		));
		$requete->closeCursor();
		$requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ?");
		$requete->execute(array
		(
                    $_GET["del"]
		));
		while($donnees = $requete->fetch())
		{
                    $delReps = $bdd->prepare("DELETE FROM reponses WHERE idquestion = ?");
                    $delReps->execute(array
                    (
			$donnees["id"]
                    ));
                    $delReps->closeCursor();
		}
		$requete->closeCursor();
		$requete = $bdd->prepare("DELETE FROM questions WHERE idquest = ?");
		$requete->execute(array
		(
                    $_GET["del"]
		));
		$requete->closeCursor();
		$requete = $bdd->prepare("DELETE FROM resultats WHERE idquest = ?");
		$requete->execute(array
		(
                    $_GET["del"]
		));
		$requete->closeCursor();
            }
            echo "<div id='quests'>";
            include("questionnairesMod.php");
            echo "</div>";
	}
	else
	{
            echo "<p>Vous n'êtes pas administrateur !</p>";
	}
        include("mesinfos.php");
    }
    else
    {
    	echo "<p>Connectez vous pour avoir accès aux questionnaires.</p>";
    }
    ?>
</body>
</html>