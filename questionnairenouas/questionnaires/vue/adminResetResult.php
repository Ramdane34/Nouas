<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Administrateur Nouas</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
</head>
<body>
    <?php
    // include("../controlleur/autoCo.php");
    include("../controlleur/isCo.php");
    include('../../../bddConnect.php');
    include('head.php');
    $pagecharger="questionnaire.php";
    include("nav.php");
    if($isCo == true)
    {
	include("../controlleur/isAdmin.php");
	if($isAdmin == true)
	{
            echo "<div id='quests'>";
            if(isset($_POST["membre"]) && isset($_POST["questionnaire"]))
            {
		$requete = $bdd->prepare("DELETE FROM resultats WHERE idmembre = ? AND idquest = ?");
		$requete->execute(array
		(
                    $_POST["membre"],
                    $_POST["questionnaire"]
		));
		$requete->closeCursor();
		echo "<p style='color: green'>Formulaire remit à zéro !</p>";
            }
    ?>
    <form method="post" action="adminResetResult.php">
    	<p>
            <label for="membre">Membre : </label>
            <select name="membre" required>
		<?php
		$requete = $bdd->query("SELECT * FROM account ORDER BY id ");
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
            <label for="questionnaire">Questionnaire : </label>
            <select name="questionnaire" required>
            	<?php
		$requete = $bdd->query("SELECT * FROM quests");
		while($quests = $requete->fetch())
		{
                    echo "<option value='".htmlspecialchars($quests["id"])."'>".htmlspecialchars($quests["nomquest"])."</option>";
		}
		$requete->closeCursor();
		?>
            </select>
            <input type="submit" name ="reset" value="Mettre à zéro"/>
	</p>
    </form>
        <?php
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
	echo "<p>Connectez vous pour avoir accès à l'espace administrateur.</p>";
    }
    ?>
</body>
</html>