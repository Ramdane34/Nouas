<?php
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
function inscription ($idmembre, $idreponses,$nbpass,$idquest)
  {   
    if (is_int($idmembre) && is_int($idreponses) && is_int($nbpass) && is_int($idquest)) 
      { 
            echo 'Les variables sont des nombres';
            $requete = "INSERT INTO reponsestg(idmembre, idreponses, nbpass, idquest) VALUES (?, ?, ?, ?)";
            $stmt = connectDB()->prepare($requete);
            $result= $stmt->execute(array($idmembre, $idreponses,$nbpass,$idquest));
            return $result;
            echo "<br>1 ligne creer";
    
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


// APPELELEUR de FONCTIONS
if (isset($_POST['creer'])) 
  {
    inscription (18, 86,6,18);    
  }
elseif (isset($_POST['compter'])) 
  {
  echo "Compteur ";
  //echo CompteurTable ();
        $requete = 'SELECT COUNT(*) as NbNews FROM reponsestg where idreponses=34';
        $stmt = connectDB()->prepare($requete);
        $stmt->execute();
        $result= $stmt->fetch();
        echo $result['NbNews'];


  }

  elseif (isset($_POST['Max'])) 
  {
echo "Max";
  
        $requete = 'SELECT Max(nbpass) FROM reponsestg Where idmembre = 18';
        foreach(connectDB()->query($requete) as $TableMax);
        //$stmt->execute();
        //$result= $stmt->fetch();
        echo "Nombre de passage : ", $TableMax['Max(nbpass)'];

   }
elseif (isset($_POST['Stectionner'])) 
  {
    echo "Debut de la selections ";
$idStagiaire = Selecteur('account_details', 19,'prenom');
echo "Stagiaire : ", $idStagiaire;
//$resule = Selecteur('reponsestg', 107,'idmembre');
//echo " - idmembre : ", $resule;
//$LaReponse = Selecteur('reponses', $idreponse,'idquestion');
//echo " - idquestion : ", $question;
//$Laquestion = Selecteur('questions', $question,'question');
//echo " - la question : ", $question;

  //   $requete = $db->query('SELECT * FROM reponsestg');
  //   while($donnees = $requete->fetch())
  //     {
  // $varmembre=$donnees['idmembre']; 
  // $varreponses=$donnees['idreponses'];
  

// //-------------Recupere le nom de la personne
//           $requete1 = $db->query('SELECT nom, prenom, account_id FROM account_details where account_id="'.$donnees['idmembre'].'"');
//          while($donnees1 = $requete1->fetch())
//             {
//             echo "<br>L'utilsateur ", $donnees1['prenom']," à répondu ";
//          }
// //-------------FIN Recupere le nom de la personne
// //-------------Recupere la reponse
//           $requete2 = $db->query('SELECT * FROM reponses where id="'.$varreponses.'"');
//          while($donnees2 = $requete2->fetch())
            
//             echo "<br>le choix suivant ", $donnees2['rep'];
//             $varquestion=$donnees2['idquestion'];           
         
//           //-------------FIN Recupere la question
//           //-------------Recupere la reponse
//           $requete3 = $db->query('SELECT * FROM questions where id="'.$varquestion.'"');
//          while($donnees3 = $requete3->fetch())
//             {
//             echo "<br>à la question suivante : ", $donnees3['question'];
//             $varquiz=$donnees3['idquest'];
//             echo $varquiz;
//          }
//           //-------------FIN Recupere la question
//         //-------------FIN Recupere le quizz
//          //-------------Recupere la reponse
//           $requet4 = $db->query('SELECT * FROM quests where id="'.$varquiz.'"');
//          while($donnees4 = $requete4->fetch())
//             {
//             echo "<br>à la question suivante : ", $donnees4['nomquest'];
//          }
// //-------------FIN Recupere la question

//     echo "<br>L'utilsateur ",$varmembre ," à répondu ", $varreponses," à la question ";
//   }

}

?>

<!DOCTYPE html>

<html>

  <head>

    <title>Mini jeu de combat</title>

    

    <meta charset="utf-8" />

  </head>

  <body>

    <form action="" method="post">

      <p>

        idreponsestg : <input type="text" name="idreponsestg" maxlength="50" />

        <input type="submit" value="Créer" name="creer" />

        <input type="submit" value="Stectionner" name="Stectionner" />

        <input type="submit" value="compter" name="compter" />

        <input type="submit" value="Max" name="Max" />

      </p>

    </form>

  </body>

</html>