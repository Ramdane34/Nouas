<?php
session_start();
// connection Base de Donnée
function connectDB()
  {
    try 
      {    
        $Connexion = new PDO('mysql:host=localhost;dbname=nouas_account;charset=utf8', 'nouas_BDD', 'aou$$AIS@@1010');  
      } 
    catch (Exception $e) 
      {
        echo 'Échec lors de la connexion : '.$e->getMessage();
      }
    return $Connexion;
  }

// inscription donnees
function inscription ($idmembre, $idreponses,$nbpass)
  {   
    if (is_int($idmembre) && is_int($idreponses) && is_int($nbpass)) 
      {
        echo 'Les variables sont des nombres';      
        try 
          {
            $requete = "INSERT INTO reponsestg(idmembre, idreponses, nbpass) VALUES (?, ?, ?)";
            $stmt = connectDB()->prepare($requete);
            $result= $stmt->execute(array($idmembre, $idreponses,$nbpass));
            return $result;
            echo "<br>1 ligne creer";
          } 
        catch (Exception $e) 
          {
            echo 'Échec lors de la connexion :'.$e->getMessage();
          }        
      }
    else 
      {
        echo 'Erreur une variable au moins n est pas un nombre';
        echo "<br>pas de ligne creer";
      }
  }

// inscription donnees
function CompteurTable ()
  {  
    try 
      {
        $requete = 'SELECT COUNT(*) as NbNews FROM reponsestg';
        $stmt = connectDB()->prepare($requete);
        $stmt->execute();
        $result= $stmt->fetch();
        return $result['NbNews'];
      } 
    catch (Exception $e) 
      {
        echo 'Échec lors de la connexion :'.$e->getMessage();
      }      
  }

// Selecteur
function Selecteur ($vartable, $varreponses, $varchamp)
  {  
//echo $varreponses, $vartable;
    try 
      {
        $requete = 'SELECT * FROM '.$vartable.' where id="'.$varreponses.'"';
        $stmt = connectDB()->query($requete);
        
        while($result= $stmt->fetch())
          {
            // $varmembre=$donnees['idmembre']; 
 
             return $result[$varchamp];
            
          } 
        }
    catch (Exception $e) 
      {
        echo 'Échec lors de la connexion :'.$e->getMessage();
      }      
  }




if(isset($_GET["id"]))
{
 

    $note = 0;
    $coef = 0;
    include("../../../bddConnect.php");
    $requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ?");
    $requete->execute(array
    (
	$_GET["id"]
    ));
    while($donnees = $requete->fetch())
    {
	$reponse = $bdd->prepare("SELECT * FROM reponses WHERE idquestion = ?");
	$reponse->execute(array
	(
            $donnees["id"]
	));
	while($reps = $reponse->fetch())
	{
            if($_GET["type"] == "checkbox")
            {
		if(isset($_POST[$reps["id"]]))
		{
                    if($reps["vraifaux"] == "vrai") {
			$note += 1;
                    } else {
                			$cookieNom = "cookie/".strval($reps["idquestion"]);
                			setcookie($cookieNom, $reps["idquestion"], time() + 60, "/");
                    }
		}
            }
            else if($_GET["type"] == "radio")
            {
                if($_POST[$donnees["id"]] == $reps["id"])
		{
                    if($reps["vraifaux"] == "vrai")
                    {
			$note += 1;




                    }
                    else
                    {
			$cookieNom = "cookie_".strval($reps["idquestion"]);
			setcookie($cookieNom, $reps["idquestion"], time() + 60, "/");



//$Nbpass = Selecteur('account_details', 19,'prenom');
//echo "Stagiaire : ", $idStagiaire;
//$nbpass=_GET["id"]+1
$rqReponse = "INSERT INTO reponsestg(idmembre, idreponses, nbpass, idquest) VALUES (?, ?, ?, ?)";
$stmt = connectDB()->prepare($rqReponse);
 $result= $stmt->execute(array (
$_SESSION["id"],
$donnees["id"],
2,
($_GET["id"])
));

//inscription (19, $donnees["id"],1);


                    }
		}
            }
            else if($_GET["type"] == "text")
            {
		$_POST[$donnees["id"]] = mb_strtolower($_POST[$donnees["id"]], "UTF-8");
                if($reps["vraifaux"] == "vrai")
                {
                    $reponseDonnee = $_POST[$donnees["id"]];
                    $reponseAttendue = $reps["rep"];
                    include("compareInputText.php");
                    if($note == 0)
                    {
                        $cookieNom = "cookie/".strval($reps["idquestion"]);
                        setcookie($cookieNom, $reps["idquestion"], time() + 60, "/");
                    }
                }
		else
		{
                    $cookieNom = "cookie/".strval($reps["idquestion"]);
                    setcookie($cookieNom, $reps["idquestion"], time() + 60, "/");
		}
            }
	}
	$reponse->closeCursor();
	$reponse = $bdd->prepare("SELECT * FROM reponses WHERE idquestion = ? AND vraifaux = ?");
	$reponse->execute(array
	(
            $donnees["id"],
            "vrai"
	));
	while($vraiesReps = $reponse->fetch())
	{
            $coef += 1;
	}
	$reponse->closeCursor();
    }
    $requete->closeCursor();
    $note = ($note/$coef)*20;
    $requete = $bdd->prepare("INSERT INTO resultats(idmembre, idquest, note) VALUES(?, ?, ?)");
    $requete->execute(array
    (
	$_SESSION["id"],
	$_GET["id"],
	$note
    ));
    $requete->closeCursor();
    header("Location: ../vue/questionnaire.php?id=".$_GET["id"]."&cor=y");
}