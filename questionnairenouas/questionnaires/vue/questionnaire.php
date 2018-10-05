<?php
	session_start();
	include("../controlleur/isCo.php");
 	include('../../../bddConnect.php');
	include('head.php');
    $pagecharger="questionnaire.php";
	include("nav.php");
    				

	
    	//si l'utilisateur est connecté
if($isCo)
{


            $questionnairesRemplis = [];
            $requete = $bdd->prepare("SELECT * FROM resultats WHERE idmembre = ?");
            $requete->execute(array($_SESSION["id"]));
                while($questionnairesFinis = $requete->fetch()) 
                {
                array_push($questionnairesRemplis, $questionnairesFinis["idquest"]);
                }
            $requete->closeCursor();
    

        
    
//un questionnaire est choisi
    if(isset($_GET["id"]))
    {
            echo "<div class='container' style='margin-top:30px'><a href='index.php' class='btn btn-info' role='button'>Retour aux questionnaires</a></div><br><div class='container' style='margin-top:30px'>";
 
//recherche Nombre de passage 
//        $requete = 'SELECT Max(nbpass) FROM reponsestg where idmembre='.$_GET["id"];
//        foreach($bdd->query($requete) as $TableMax);
//        //$stmt->execute();
        //$result= $stmt->fetch();
//        echo "Nombre de passage : ", $TableMax['Max(nbpass)'];
//        $nbpassage=$TableMax['Max(nbpass)'] + 1

    //include("../../bddConnect.php");
     $requete = $bdd->prepare("SELECT * FROM quests WHERE id = ?");
     $requete->execute(array
     (
     $_GET["id"]
     ));
	   while($donnee = $requete->fetch())
	   {
	   $nomQuest = $donnee["nomquest"];
	   $intro = $donnee["intro"];
	   $type = $donnee["type"];
	   }
        $requete->closeCursor();
	       if(isset($nomQuest) && isset($type))
                    //if($isCo)
                    //{
                    //    echo "string";
                    //}
            {
        	$requete = $bdd->prepare("SELECT * FROM questions WHERE idquest = ?");
        	$requete->execute(array
        	(
            $_GET["id"]
        	));

            
        	echo "<div class='jumbotron text-center' id='quests' ><form method='post' action='../controlleur/checkAnswers.php?id=".htmlspecialchars($_GET["id"])."&type=".htmlspecialchars($type)."'>		
		<h2>".$nomQuest."</h2>
     		<p id='intro' class='text-info'>".$intro."</p>
		<p>";
                $compteurReps = 0;
        	       while($donnees = $requete->fetch())
        	           {
                    	$compteurReps += 1;
                    	$lien = null;
                    	   if($donnees["lien"] != null)
                    	       {
                                $lien = $donnees["lien"];
                    		  }
                              ;
//CompteurTable ();
        $reqCompte = 'SELECT COUNT(*) as NbNews FROM reponsestg where idmembre='.$_SESSION["id"].' AND idreponses='.$donnees["id"];
       $stmtCompte = $bdd->prepare($reqCompte);
        $stmtCompte->execute();
       $resultCompte = $stmtCompte->fetch();

//--->
                    		  if(isset($_GET["cor"]) || ($resultCompte['NbNews'] >= 1))
                    		      {
            			             $nCookie = "cookie_".$donnees["id"];


            				            if(isset($_COOKIE[$nCookie]) || ($resultCompte['NbNews'] >= 1))
            				            {
                            		      $messageAide = "<br><div class='alert alert-warning' role='alert'>Vous avez donnée une mauvaise réponse!<br>Explication : ".htmlspecialchars($donnees["aide"]).". <p class='p-3 mb-2 bg-danger text-white'>Pas de point sur cette question.</p></div>";
            				            }
            				            else
            				            {
                            		      $messageAide = "<br><div class='alert alert-primary' role='alert'>Bien ! <br><p class='font-italic'>Explication : ".htmlspecialchars($donnees["aide"]).".</p><br><p class='p-3 mb-2 bg-primary text-white'>1 point à cette question.</p></div>";
            				        }
            				        echo "<div class='p-3 mb-2 bg-secondary text-white text-sm-left'>".$compteurReps.") ".htmlspecialchars($donnees["question"])."</div>".$messageAide."";
                    			     }
                    			else
                    			     {
                        		      echo "<div class='p-3 mb-2 bg-secondary text-white text-sm-left'>".$compteurReps.") ".htmlspecialchars($donnees["question"])."</div>";

                            		      if($lien != null)
                            		          {
                                	       echo "<br/><img src ='../images/".$lien."' alt='image' height='auto' width='320px' style='display: block; margin: auto;'>";
                            		          }
                    		      }
                    		      $reponse = $bdd->prepare("SELECT * FROM reponses WHERE idquestion = ?");
                    		      $reponse->execute(array
                    		      (
        			             $donnees["id"]
                    		      ));
                                  //echo "<fieldset>";
                    		          while($reps = $reponse->fetch())
                    		              {
 // --------------CHECKBOX---------------------------------------------------->
            				                if($type == "checkbox")
            				                    {
                                                    if(isset($_GET["cor"]) || ($test=1)) {
                                                        //echo "cor";

                                                    }
                                                    else {
                                                        echo "<div class='form-check'><input type='".htmlspecialchars($type)."' name='".$reps["id"]."' value='".$reps["id"]."'/>".
                                                            "<label for='".$reps["id"]."'>".htmlspecialchars($reps["rep"])."</label></div>";
                                                    }

            				                    }
 // --------------RADIO---------------------------------------------------->
            				                else if($type == "radio")
            				                    {
                                                    if(isset($_GET["cor"]) || ($resultCompte['NbNews'] >= 1)) {
                                                        //echo "cor";

                                                    }
                                                    else {
                                                    echo "<fieldset><div class='form-check'><label class='toggle' for='".$reps["id"]."'><input type='".htmlspecialchars($type)."' name='".$donnees["id"]."' value='".$reps["id"]."' id='".$reps["id"]."' required/><span class='label-text'> ".htmlspecialchars($reps["rep"])."</span></label></div></fieldset>";
                                                    } 


            				                    }
 // --------------TEXTE----------------------------------------------------> 
            				                else if($type == "text")
    		            		                {  
                                                    if(isset($_GET["cor"])) {
                                                        //echo "cor";

                                                    }
                                                    else {          
                            		                echo "<br/><input type='".htmlspecialchars($type)."' name='".$donnees["id"]."' placeholder='Un mot sans espaces' required/>";
                                                   }
        			    	                    }

                                            }
                                           
                                        $reponse->closeCursor();


                                    }

                                    $requete->closeCursor();
                                    $fait = false;
                                    $reponse = $bdd->prepare("SELECT * FROM resultats WHERE idmembre = ? AND idquest = ?");
                                    $reponse->execute(array
                                    (
                                     $_SESSION["id"],
                                    $_GET["id"]
                                    ));
        	                           while($donnee = $reponse->fetch())
        	                               {
                                            $fait = true;
                                            $noteEue = number_format($donnee["note"], 2);
        	                               }
        	                           $reponse->closeCursor();
        	                           	   if($fait == false)
        	                           	       {
                                                echo "<br/></p><p><input type='submit' name='submit' class='btn btn-success' value='Valider mes réponses'/></p></form></div></div";		
        	                           	       }
        	                           	   else
        	                           	       {
                                                echo "<br/></p><p>Vous avez déjà rempli ce formulaire. Note : ".$noteEue."/20.00</p></form>";	
        	                           	       }
        	                           
                                }      
                           else
                                {
        	                   echo "<p>Le questionnaire demandé n'existe pas.</p>";

                                 }

                    }    
 // -----------DEBUT 1 Blocks ----------->                           
  
                echo "<div class='container' style='margin-top:30px'>
              <div><h2>Liste des Questionnaires</h2>
                  <div 'container-fluid'>";
            include("questionnaires.php");
            echo "</div></div></div>";
// -----------DEBUT 2 Blocks ----------->
}
else
{
echo "<p>Connectez vous pour avoir accès aux questionnaires.</p>";
  
}

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
                                                    <a class='nav-link active' href='questionnaire.php' >Questionnaires</a>
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
