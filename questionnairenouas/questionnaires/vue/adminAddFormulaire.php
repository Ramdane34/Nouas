
    <?php
    session_start();
    include("../controlleur/isCo.php");
    include('../../../bddConnect.php');
    include('head.php');
    include("nav.php");
    

	if($isCo)
	{
        if($isAdmin)
        {
		    if(isset($_GET["etape"]))
		    {
                switch($_GET["etape"])
                {
			        case 1:
                        if(isset($_GET["erreur"]) && $_GET["erreur"] == "nf")
                        {
				            echo "<p style='color: red;'>Ce nom de formulaire est déjà utilisé</p>";
                        }
                        ?>
                            <form method="post" action="adminAddFormulaire.php?etape=2">
                                <p>
                                    <input type="text" name="nomquest" placeholder="Nom du formulaire" required/>
                                    <input type="text" name="theme" placeholder="Theme, ex: maths" required/>                          
                                    <input type="text" name="intro" placeholder="Texte d'introduction" required/>
                                    <select name="type">
                                        <option value="radio">(QCM)Une seule réponse par question</option>
                                        <option value="checkbox">(QCM)Plusieurs réponses par question</option>
                                        <option value="text">Attente d'un mot</option>
                                    </select>
                                    <input type="submit" name="envoi" value="Créer le formulaire"/>
                                </p>
                            </form>
                        <?php
                        break;
			        case 2:
                        if(isset($_POST["nomquest"]))
                        {
				            $erreur = 0;
				            include("../../bddConnect.php");
            				$requete = $bdd->query("SELECT * FROM quests");
            				while($donnees = $requete->fetch())
            				{
                                if($_POST["nomquest"] == $donnees["nomquest"])
                                {
            					   $erreur = 1;
                                }
            				}
            				$requete->closeCursor();
            				if($erreur == 0)
            				{
                                $requete = $bdd->prepare("INSERT INTO quests(nomquest, theme, intro, type) VALUES(?, ?, ?, ?)");
                                $requete->execute(array
                                (
                					$_POST["nomquest"],
                					$_POST["theme"],
                                    $_POST["intro"],
                					$_POST["type"]
                                ));
                                $requete->closeCursor();
                                header("Location: adminAddFormulaire.php?etape=3&nomquest=".htmlspecialchars($_POST["nomquest"]));
            				}
            				else
            				{
                                header("Location: adminAddFormulaire.php?etape=1&erreur=nf");
            				}
                        }
                        else
                        {
				            echo "<p>Vous n'avez pas eu accès à cette page d'une manière correcte !</p>";
                        }
                        break;
			        case 3:
                        include("modQuests.php");
                        break;
			        case 4:
                        include("modReps.php");
                        break;
			        case 5:
                        echo "<h2 style='color: green;'>Le formulaire ".htmlspecialchars($_GET["nomquest"])." est maintenant opérationnel !</h2>";
                        break;
			        default:
                        echo "<p>Il semble qu'une erreur se soit produite</p>";
                }
		    }
		    else
		    {
                echo "<p>Vous n'avez pas eu accès à cette page d'une manière correcte !</p>";
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
	?>
    </div>
    <?php
    if($isCo)
    {
        include("mesinfos.php");
    }
    ?>
</body>
</html>