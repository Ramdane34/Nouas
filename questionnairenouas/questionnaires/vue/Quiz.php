<?php
include("../controlleur/isCo.php");
include('../../../bddConnect.php');
echo"Liste des getters<br>";

class ObjetrepStag
{

  private $_idStagiaire;


    // Un tableau de données doit être passé à la fonction (d'où le préfixe « array »).

 
  // Liste des getters

  
  public function idStagiaire()
  {
    return $this->_idStagiaire;
  }
  
 
  // Liste des setters
  
  public function setidstag($idStagiaire)
  {
    // On convertit l'argument en nombre entier.
    // Si c'en était déjà un, rien ne changera.
    // Sinon, la conversion donnera le nombre 0 (à quelques exceptions près, mais rien d'important ici).
    $idStagiaire = (int) $idStagiaire;
    
    // On vérifie ensuite si ce nombre est bien strictement positif.
    if ($idStagiaire > 0)
    {
      // Si c'est le cas, c'est tout bon, on assigne la valeur à l'attribut correspondant.
      $this->_idStagiaire = $idStagiaire;
    }
  }
  
  
	public function hydrate(array $donnees)

{

  foreach ($donnees as $key => $value)

  {

    // On récupère le nom du setter correspondant à l'attribut.

    $method = 'set'.ucfirst($key);

        

    // Si le setter correspondant existe.

    if (method_exists($this, $method))

    {

      // On appelle le setter.

      $this->$method($value);

    }

  }

}
}
?>

<?php
$donnees = ['id' => 16];


 
$request = $bdd->query('SELECT * FROM RepStagiaires');


while($donnees = $request->fetch(PDO::FETCH_ASSOC))
{
    


$Stag = new ObjetrepStag($donnees);

 echo " jkjk -->".htmlspecialchars($Stag->ID_RepStagiaires())." .";
  //    {
	  //echo "dd ", $Stag->ID_RepStagiaires(), $donnees(["Id_RepStagiaires"])," rr ";
      
      //echo  " ".htmlspecialchars($donnees["Id_RepStagiaires"])." - kk23<br>";

// }else{
//       echo "Pas Passer<br>";
//   }
    
}
//$requests ->closeCursor();

//<?php
// On admet que $db est un objet PDO.
//$request = $db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnages');
    
//while ($donnees = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
//{
  // On passe les données (stockées dans un tableau) concernant le personnage au constructeur de la classe.
  // On admet que le constructeur de la classe appelle chaque setter pour assigner les valeurs qu'on lui a données aux attributs correspondants.
  //$perso = new Personnage($donnees);
        
  //echo $perso->nom(), ' a ', $perso->forcePerso(), ' de force, ', $perso->degats(), ' de dégâts, ', $perso->experience(), ' d\'expérience et est au niveau ', $perso->niveau();
//}

?>-->