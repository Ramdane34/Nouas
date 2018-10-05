
    <?php
   
	session_start();
    	include("../controlleur/isCo.php");
    	include("../controlleur/isAdmin.php");
    	include("../controlleur/isModo.php");
 	include('../../../bddConnect.php');
	include('head.php');
	$pagecharger="adminIndex.php";
	include("nav.php");    				
	echo "<div class='container' style='margin-top:30px'>";
    if($isCo)
    {
		if($isAdmin)
        {	
            if(isset($_GET["del"]))
            {
        		$requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
        		$requete->execute(array
        		(
                    $_POST["membre"]
        		));
        		while($donnee = $requete->fetch())
        		{
                    $selectedModo = $donnee["type"];
        		}
        		$requete->closeCursor();
        		if($selectedModo == "Modo")
                {
                    echo "<div id='quests'><p style='color: red;'>Vous ne pouvez pas reprendre ses droits au modérateur !</p></div>";
        		}
        		else
        		{
                    if(isset($_POST["membre"]))
                    {
            			$requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            			$requete->execute(array
            			(
                            $_POST["membre"]
            			));
            			while($donnee = $requete->fetch())
            			{
                            $selectedModo = $donnee["type"];
            			}
            			$requete->closeCursor();
            			if($selectedModo == "Modo")
            			{
                            echo "<div id='quests'><p style='color: red;'>Cette personne est modérateur !</p></div>";
            			}
            			else
            			{
                                $requete = $bdd->prepare("UPDATE account SET type = ? WHERE id = ?");
                                $requete->execute(array
                                (
            				        "Membre",
            				        $_POST["membre"]
                                ));
                                $requete->closeCursor();
                                header("Location: adminIndex.php?admin=".$_POST["membre"]."&delAdmin=ok");
            			}
                    }	
        		}
            }
            else
            {
        		if(isset($_POST["membre"]))
        		{
                    $requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
                    $requete->execute(array
                    (
                        $_POST["membre"]
                    ));
                    while($donnee = $requete->fetch())
                    {
			            $selectedModo = $donnee["type"];
                    }
                    $requete->closeCursor();
                    if($selectedModo == "Modo")
                    {
        			    echo "<div id='quests'><p style='color: red;'>Cette personne est déjà modérateur !</p></div>";
                    }
                    else
                    {
            			$requete = $bdd->prepare("UPDATE account SET type = ? WHERE id = ?");
            			$requete->execute(array
            			(
                            "Admin",
                            $_POST["membre"]
            			));
            			$requete->closeCursor();
            			header("Location: adminIndex.php?admin=".$_POST["membre"]);
                    }
        		}
            }
  			echo "<div class='row'>";
    			echo "<div class='col-sm-4'>";
			echo "<h2>Mes Infos</h2>";
			echo "<div class='container-fluid'>";
			include("mesinfos.php");
			echo "</div></div><div class='col-sm-8'>";
    			echo "<div id='quests'><h2>Actions possibles en tant qu'Administrateur</h2>";
			echo "<div class='container-fluid'>";

            echo "<div class='list-group'>
    			<a href='adminModFormulaire.php' class='list-group-item list-group-item-action list-group-item-secondary'>Modifier un formulaire</a>
    			<a href='adminAddFormulaire.php?etape=1' class='list-group-item list-group-item-action list-group-item-secondary'>Créer un questionnaire (par membre)</a>
    			<a href='adminIndex.php?mod=adminA' class='list-group-item list-group-item-action list-group-item-secondary'>Donner les droits d'administrateur à un membre</a>
                <a href='adminResetResult.php' class='list-group-item list-group-item-action list-group-item-secondary'>Remettre à zéro un questionnaire (par membre)</a>
    			";
        if($isModo == true)
        {
		    echo "<div id='modo'><p><a href='adminIndex.php?mod=adminD'>Reprendre les droits d'administrateur à un membre</a></p></div>";
        }
        if(isset($_GET["mod"]))
        {
		if($_GET["mod"] == "adminA")
		{
                    ?>
                    <div id="quests">
			            <form method="post" action="adminIndex.php">
                            <label for="membre">Membre : </label>
                            <select name="membre" required>
                            <?php
            				$requete = $bdd->query("SELECT * FROM account ORDER BY id");
            				while($membres = $requete->fetch())
            				{
                                $requete2 = $bdd->prepare("SELECT * FROM account_details WHERE account_id = ?");
                                $requete2->execute(array($membres["id"]));
                                while($mmbr = $requete2->fetch())
                                {
                                                echo "<option value='".htmlspecialchars($membres["id"])."'>".htmlspecialchars($mmbr["nom"])." ".htmlspecialchars($mmbr["prenom"])." (".htmlspecialchars($mmbr["formation"]).")</option>";
                                }
                                $requete2->closeCursor();
            				}
            				$requete->closeCursor();
                            ?>
                            </select>
                            <input type="submit" name="adminAdd" value="Donner les droits"/>
			            </form>
                    </div>
                    <?php
		}
		if($_GET["mod"] == "adminD")
		{
            if($isModo == true)
            {
			?>
			<div id="quests">
                            <form method="post" action="adminIndex.php?del=admin">
				<label for="membre">Membre : </label>
				<select name="membre" required>
				<?php
                                    $requete = $bdd->query("SELECT * FROM account ORDER BY id");
                            while($membres = $requete->fetch())
                            {
                                $requete2 = $bdd->prepare("SELECT * FROM account_details WHERE account_id = ?");
                                $requete2->execute(array($membres["id"]));
                                while($mmbr = $requete2->fetch())
                                {
                                                echo "<option value='".htmlspecialchars($membres["id"])."'>".htmlspecialchars($mmbr["nom"])." ".htmlspecialchars($mmbr["prenom"])." (".htmlspecialchars($mmbr["formation"]).")</option>";
                                }
                                $requete2->closeCursor();
                            }
                            $requete->closeCursor();
				?>
				</select>
				<input type="submit" name="adminAdd" value="Reprendre les droits"/>
                            </form>
			</div>
			<?php
                    }
                    else
                    {
			echo "<p>Vous n'êtes pas modérateur !</p>";
                    }
		}
            }
            if(isset($_GET["admin"]))
            {
		if(isset($_GET["delAdmin"]))
		{
                    $requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
                    $requete->execute(array
                    (
			$_GET["admin"]
                    ));
                    while($donnee = $requete->fetch())
                    {
			$nomAdmin = $donnee["email"];
                    }
                    $requete->closeCursor();
                    echo "<div id='quests'><p style='color: green;'>Le compte ".$nomAdmin." ne dispose désormais plus des droits d'administrateur.</p></div>";
		}
		else
		{
                    $requete = $bdd->prepare("SELECT * FROM account WHERE id = ?");
                    $requete->execute(array
                    (
			$_GET["admin"]
                    ));
                    while($donnee = $requete->fetch())
                    {
			$nomAdmin = $donnee["email"];
                    }
                    $requete->closeCursor();
			echo "<div id='quests'><p style='color: green;'>Le compte ".$nomAdmin." dispose désormais des droits d'administrateur.</p></div>";
		}
            }
	}
	else
	{
            echo "<p>Vous n'êtes pas administrateur !</p>";
	}
        
    }
    else
    {
	echo "<p>Connectez vous pour avoir accès à l'espace administrateur.</p>";
    }
	echo "</a></div></div></div></div></div></div>";
// -----------DEBUT Navigation FOOTER----------->
                            echo "<div class='container' style='margin-top:10px'>
                                <div class='card text-center'>
                                    <div class='card-header'>
                                        <ul class='nav nav-pills card-header-pills'>
                                                <li class='nav-item'>
                                                    <a class='nav-link' href='index.php'>Accueil</a>
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
                                                    <a class='nav-link active' href='adminIndex.php'>Administration</a>
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
