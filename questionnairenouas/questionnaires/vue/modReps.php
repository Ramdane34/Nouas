<?php
if(isset($_GET["idquest"]))
{
    $nomQuestionnaire;
    include("../../bddConnect.php");
    $requete = $bdd->prepare("SELECT * FROM quests WHERE id = ?");
    $requete->execute(array
    (
	$_GET["idquest"]
    ));
    while($donnee = $requete->fetch())
    {
	$typeQuestionnaire = $donnee["type"];
	$nomQuestionnaire = $donnee["nomquest"];
	echo "<h2>Vous modifiez ".htmlspecialchars($nomQuestionnaire)."</h2>";
    }
    $requete->closeCursor();
    if(isset($_GET["reponseAdd"]))
    {
	if(isset($_GET["modr"]))
    	{
            if(isset($_POST["reponse"]) && isset($_POST["vraifaux"]))
            {
		$_POST["vraifaux"] = strtolower($_POST["vraifaux"]);
		if($_POST["vraifaux"] != "vrai")
		{
                    $_POST["vraifaux"] = "faux";
		}
		$requete = $bdd->prepare("UPDATE reponses SET rep = ?, vraifaux = ? WHERE id = ?");
		$requete->execute(array
		(
                    $_POST["reponse"],
                    $_POST["vraifaux"],
                    $_GET["modr"]
		));
		$requete->closeCursor();
		echo "<p style='color: green;'>Question modifiée</p>";
            }
            else
            {
		echo "<p style='color: red;'>Erreur lors de la modification de la réponse</p>";
            }
	}
	else
	{
            if(isset($_POST["reponse"]) && isset($_POST["vraifaux"]))
            {
		$_POST["vraifaux"] = strtolower($_POST["vraifaux"]);
		if($_POST["vraifaux"] != "vrai")
		{
                    $_POST["vraifaux"] = "faux";
		}
		if($typeQuestionnaire == "text")
		{
                    $_POST["reponse"] = mb_strtolower($_POST["reponse"], "UTF-8");
		}
		$requete = $bdd->prepare("INSERT INTO reponses(idquestion, rep, vraifaux) VALUES(?, ?, ?)");
		$requete->execute(array
		(
                    $_GET["reponseAdd"],
                    $_POST["reponse"],
                    $_POST["vraifaux"]
		));
		$requete->closeCursor();
		echo "<p style='color: green;'>Réponse ajoutée</p>";
            }
            else
            {
		echo "<p style='color: red;'>Erreur lors de l'ajout de la réponse</p>";
            }
	}
    }
    $requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ?");
    $requete->execute(array
    (
	$_GET["idquest"]
    ));
    echo "<h3>Questions présentes dans le formulaire : </h3>";
    $repsInAllPres = 0;
    $nbrQuestions = 0;
    while($donnees = $requete->fetch())
    {
    	$nbrQuestions += 1;
		echo "<div class='questionClass'><p><strong>Question : </strong>".htmlspecialchars($donnees["question"])."</p>
		<h3>Réponses : </h3>";
		$reponse = $bdd->prepare("SELECT * FROM reponses WHERE idquestion = ?");
		$reponse->execute(array
		(
	            $donnees["id"]
		));
		$repsPres = 0;
		while($reponsesPresentes = $reponse->fetch())
		{
	            $repsPres += 1;
	            echo "<p><strong>".htmlspecialchars($reponsesPresentes["rep"])."</strong>, <span style='color: green;'>".htmlspecialchars($reponsesPresentes["vraifaux"])."</span>
	            <a href='adminAddFormulaire.php?etape=4&idquest=".htmlspecialchars($_GET["idquest"])."&modrf=".htmlspecialchars($reponsesPresentes["id"])."'>Modifier</a> 
	            <a href='adminAddFormulaire.php?etape=4&idquest=".htmlspecialchars($_GET["idquest"])."&delr=".htmlspecialchars($reponsesPresentes["id"])."'>Supprimer</a></p>";
	            if(isset($_GET["modrf"]))
	            {
					if($reponsesPresentes["id"] == $_GET["modrf"])
					{
			                    $reponseaMod = $bdd->prepare("SELECT * FROM reponses WHERE id = ?");
			                    $reponseaMod->execute(array
			                    (
						$_GET["modrf"]
			                    ));
			                    while($repamod = $reponseaMod->fetch())
			                    {
						$reponseMod = $repamod["rep"];
						$vraifauxMod = $repamod["vraifaux"];
			                    }
			                    $reponseaMod->closeCursor();
			                    ?>
					<form method="post" action="adminAddFormulaire.php?etape=4&idquest=<?php echo htmlspecialchars($donnees['idquest']);?>&reponseAdd=y&modr=
			                    <?php echo htmlspecialchars($_GET['modrf']);?>">
			                    <p>
									<input type="text" name="reponse" value="<?php echo htmlspecialchars($reponseMod);?>" required/>
									<select name="vraifaux" required>
										<option value="vrai">Vrai</option>
										<option value="faux">Faux</option>
									</select>
									<input type="submit" name="addReponse" value="Modifier réponse"/>
			                    </p>
							</form>
			                    <?php
					}
	            }
	            else if(isset($_GET["delr"]))
	            {
					$reponseaDel = $bdd->prepare("DELETE FROM reponses WHERE id = ?");
					$reponseaDel->execute(array
			            	(
			                    $_GET["delr"]
					));
					$reponseaDel->closeCursor();
					header("Location: adminAddFormulaire.php?etape=4&idquest=".htmlspecialchars($_GET["idquest"]));
	            }
		}
		$reponse->closeCursor();
		if($repsPres >= 2)
		{
	            $repsInAllPres += 1;
		}
		else if($repsPres >= 1)
		{
	            if($typeQuestionnaire == "text")
	            {
			$repsInAllPres += 1;
	            }
		}
		?>
		<p>Ajouter une réponse : </p>
		<form method="post" action="adminAddFormulaire.php?etape=4&idquest=<?php echo htmlspecialchars($donnees['idquest']);?>&reponseAdd=<?php echo htmlspecialchars($donnees['id']);?>">
	            <p>
			<input type="text" name="reponse" placeholder="Réponse" required/>
			<select name="vraifaux" required>
					<option value="vrai">Vrai</option>
					<option value="faux">Faux</option>
				</select>
			<input type="submit" name="addReponse" value="Valider réponse"/>
	            </p>
		</form>
		</div>
            <?php
    }
    $requete->closeCursor();
    ?>
    <form method="post" action="adminAddFormulaire.php?etape=5&nomquest=<?php echo htmlspecialchars($nomQuestionnaire);?>">
        <?php
        if($nbrQuestions <= $repsInAllPres)
	{
	?>
            <input type="submit" name="endQuest" value="Terminer la création"/>
	<?php
	}
	else
	{
            echo "<p>Vous devez ajouter au moins deux réponses à chaque question.</p>";
	}
	?>
    </form>
    <?php
}
else
{
	echo "<p>Vous n'avez pas eu accès à cette page d'une manière correcte !</p>";
}
?>
<script>
window.addEventListener("load", function()
{
	var prevSel = document.querySelector("input[value='Modifier réponse']").parentNode.parentNode.closest(".questionClass");
	prevSel.scrollIntoView();
});
</script>