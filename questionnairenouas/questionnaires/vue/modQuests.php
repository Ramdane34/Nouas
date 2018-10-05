<?php
include('../../bddConnect.php');
$messageImage = "";
if(isset($_GET["nomquest"]))
{
    echo "<h2>Vous modifiez ".htmlspecialchars($_GET["nomquest"])."</h2>";
    $requete = $bdd->prepare("SELECT * FROM quests WHERE nomquest = ?");
    $requete->execute(array
    (
    	$_GET["nomquest"]
    ));
    while($donnee = $requete->fetch())
    {
	$idQuest = $donnee["id"];
    }
    $requete->closeCursor();
    if(isset($_GET["questionAdd"]))
    {
	if(isset($_GET["modq"]))
	{
            if(isset($_POST["question"]) && isset($_POST["aide"]))
            {
		$requete = $bdd->prepare("UPDATE questions SET question = ?, aide = ? WHERE id = ?");
		$requete->execute(array
		(
                    $_POST["question"],
                    $_POST["aide"],
                    $_GET["modq"]
		));
		$requete->closeCursor();
		if(isset($_FILES["lien"]) && $_FILES["lien"] != null)
		{
		            $target_dir = "../images/";
				$target_file = $target_dir . basename($_FILES["lien"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
				    $check = getimagesize($_FILES["lien"]["tmp_name"]);
				    if($check !== false) {
					echo "Une image - " . $check["mime"] . ".";
					$uploadOk = 1;
				    } else {
					$messageImage =  "Pas une image.";
					$uploadOk = 0;
				    }
				}
				// Check if file already exists
				if (file_exists($target_file)) {
				    $messageImage =  "L'image existe déjà.";
				    $uploadOk = 0;
				}
				// Check file size
				if ($_FILES["lien"]["size"] > 500000) {
				    $messageImage =  "Trop volumineux.";
				    $uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    $messageImage =  "Pas une image.";
				    $uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				    $messageImage =  "Erreur lors de la sauvegarde.";
				// if everything is ok, try to upload file
				} else {
				    if (move_uploaded_file($_FILES["lien"]["tmp_name"], $target_file)) {
					$messageImage =  "L'image ". basename( $_FILES["lien"]["name"]). " a été sauvegardée.";
				    $requete = $bdd->prepare("UPDATE questions SET lien = ? WHERE id = ?");
				    $requete->execute(array
				    (
					basename( $_FILES["lien"]["name"]),
					$_GET["modq"]
				    ));
				    $requete->closeCursor();
			    } else {
				$messageImage =  "Erreur lors de la sauvegarde.";
			    }
			}
		}
		$messageMod =  "<p style='color: green;'>Question modifiée</p>";
            }
            else
            {
		$messageMod = "<p style='color: red;'>Erreur lors de la modification de la question</p>";
            }
	}
	else
	{
            if(isset($_POST["question"]) && isset($_POST["aide"]))
            {
		$requete = $bdd->prepare("INSERT INTO questions(idquest, question, aide) VALUES(?, ?, ?)");
		$requete->execute(array
		(
                    $idQuest,
                    $_POST["question"],
                    $_POST["aide"]
		));
		$requete->closeCursor();
		$requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ? ANd question = ? AND aide = ?");
		$requete->execute(array
		(
                    $idQuest,
                    $_POST["question"],
                    $_POST["aide"]
		));
		while($donnee = $requete->fetch())
		{
                    $idQuestion = $donnee["id"];
		}
		$requete->closeCursor();
		if(isset($_FILES["lien"]) && $_FILES["lien"] != null)
		{
                    $target_dir = "../images/";
			$target_file = $target_dir . basename($_FILES["lien"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["lien"]["tmp_name"]);
			    if($check !== false) {
				$messageImage =  "Une image - " . $check["mime"] . ".";
				$uploadOk = 1;
			    } else {
				$messageImage =  "Pas une image.";
				$uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    $messageImage =  "L'image existe déjà.";
			    $uploadOk = 0;
			}
			// Check file size
			if ($_FILES["lien"]["size"] > 500000) {
			    $messageImage =  "Trop volumineux.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    $messageImage =  "Pas une image.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    $messageImage =  "Erreur lors de la sauvegarde.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["lien"]["tmp_name"], $target_file)) {
				$messageImage =  "L'image ". basename( $_FILES["lien"]["name"]). " a été sauvegardée.";
			    $requete = $bdd->prepare("UPDATE questions SET lien = ? WHERE id = ?");
			    $requete->execute(array
			    (
				basename( $_FILES["lien"]["name"]),
				$idQuestion
			    ));
			    $requete->closeCursor();
			    } else {
				$messageImage =  "Erreur lors de la sauvegarde.";
			    }
			}
		}
		$messageMod =  "<p style='color: green;'>Question ajoutée</p>";
            }
            else
            {
		$messageMod =  "<p style='color: red;'>Erreur lors de l'envoi de la question</p>";
            }
        }
    }
    $reponsesPresentes = false;
    echo "<h3>Questions déjà présentes dans le formulaire : </h3>";
    $requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ?");
    $requete->execute(array
    (
	$idQuest
    ));
    while($donnees = $requete->fetch())
    {
	$reponsesPresentes = true;
	if($donnees["lien"] == null)
	{
            $lienQuestion = "Non";
	}
	else
	{
            $lienQuestion = $donnees["lien"];
	}
	echo "<p><strong>Question : </strong>".htmlspecialchars($donnees["question"]).",<br/>".
	"<strong>Lien : </strong>".htmlspecialchars($lienQuestion).",<br/>".
	"<strong>Correction : </strong>".htmlspecialchars($donnees["aide"]).
	" <a href='adminAddFormulaire.php?etape=3&nomquest=".htmlspecialchars($_GET["nomquest"])."&mod=".htmlspecialchars($donnees["id"])."'>
	Modifier</a> <a href='adminAddFormulaire.php?etape=3&nomquest=".htmlspecialchars($_GET["nomquest"])."&del=".htmlspecialchars($donnees["id"])."'>Supprimer</a></p>";
    }
    $requete->closeCursor();
    if(isset($_GET["mod"]))
    {
	$requete = $bdd->prepare("SELECT * FROM questions WHERE id = ?");
	$requete->execute(array
	(
            $_GET["mod"]
	));
	while($donnee = $requete->fetch())
	{
            $valQuestion = $donnee["question"];
            $valLien = $donnees["lien"];
            if($valLien == null)
            {
		        $valLien = "";
            }
            $valAide = $donnee["aide"];
	}
	$requete->closeCursor();
	?>
	<form method="post" action="adminAddFormulaire.php?etape=3&nomquest=<?php echo htmlspecialchars($_GET['nomquest'])."&questionAdd=y&modq=".htmlspecialchars($_GET['mod']);?>" enctype="multipart/form-data">
            <p>
		<input type="text" name="question" placeholder="Question" value="<?php echo htmlspecialchars($valQuestion);?>" required/>
		<input type="file" name="lien" title="Image"/>
		<input type="text" name="aide" placeholder="Correction" value="<?php echo htmlspecialchars($valAide);?>" required/>
		<input type="submit" name="addquestion" value="Modifier question"/>
            </p>
	</form>
    <?php
    }
    else if(isset($_GET["del"]))
    {
	$requete = $bdd->prepare("DELETE FROM questions WHERE id = ?");
	$requete->execute(array
	(
            $_GET["del"]
	));
	$requete->closeCursor();
	$requete = $bdd->prepare("DELETE FROM reponses WHERE idquestion = ?");
	$requete->execute(array
	(
            $_GET["del"]
	));
	$requete->closeCursor();
	header("Location: adminAddFormulaire.php?etape=3&nomquest=".htmlspecialchars($_GET["nomquest"]));
    }
    else
    {
    ?>
	<form method="post" action="adminAddFormulaire.php?etape=3&nomquest=<?php echo htmlspecialchars($_GET['nomquest'])."&questionAdd=y";?>" enctype="multipart/form-data">
            <p>
		<input type="text" name="question" placeholder="Question" required/>
		<input type="file" name="lien" title="Image"/>
		<input type="text" name="aide" placeholder="Correction" required/>
		<input type="submit" name="addquestion" value="Ajouter question"/>
            </p>
	</form>
	<form method="post" action="adminAddFormulaire.php?etape=4&idquest=<?php echo htmlspecialchars($idQuest);?>">
            <?php
            if($reponsesPresentes == true)
            {
            ?>
            <input type="submit" name="envoi" value="Valider ces questions"/>
            <?php
            }
            else
            {
		echo "<p>Vous devez ajouter au moins une question à votre formulaire.</p>";
            }
            ?>
	</form>
    <?php
    }
}
else
{
    echo "<p>Vous n'avez pas eu accès à cette page d'une manière correcte !</p>";
}
echo $messageMod;
echo "<p>".$messageImage."</p>";
?>
<script>
window.addEventListener("load", function()
{
	window.scrollTo(0,document.body.scrollHeight);
});
</script>
