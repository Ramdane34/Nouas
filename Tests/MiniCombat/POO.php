<?php
echo "XP : ";


$array = array("foo", "bar", "hello", "world");

$array[] = 56;
var_dump($array);

$stack = array("orange", "banana");
array_push($stack, "apple", "raspberry");
print_r($stack);


$juices = array("Pomme", "orange", "koolaid1" => "purple");

echo "<br>Il a bu un jus de $juices[0].".PHP_EOL;
echo "<br>Il a bu un jus de $juices[1].".PHP_EOL;
echo "<br>Il a bu un jus de $juices[koolaid1].".PHP_EOL;

class people {
    public $john = "John Smith";
    public $jane = "Jane Smith truc";
    public $robert = "Robert Paulsen";
    
    public $smith = "Smith";
}

$people = new people();
echo "<br>";
echo "<br>$people->john a bu quelques jus de $juices[0].".PHP_EOL;
echo "<br>$people->john dit bonjour à $people->jane.".PHP_EOL;
echo "<br>$people->john's wife greeted $people->robert.".PHP_EOL;
//echo "$people->robert greeted the two $people->smiths."; // Won't work
// ;
//    class Voiture{
//       private $couleur;
//       private $puissance;
//       private $vitesse;
//       public function __construct($couleur, $puissance, $vitesse){
//          $this->couleur=$couleur;
//          $this->puissance=$puissance;
//          $this->vitesse=$vitesse;
//       }

//       public function __destruct(){
//       	echo " ".$this->vitesse, " ";
//       	//accelerer($vitesse);
//          echo "Couleur de la voiture: ".$this->puissance," ".$this->couleur," ".$this->vitesse;

//       } 

//       public function accelerer($vitesse2){
//          //echo "Appel de la méthode accelerer()";
//          $vitesse2=$vitesse2 + 3;
         
//       }

//       public function ralentir(){
//          echo "Appel de la méthode ralentir()";
//       }
//    }

//    $citadine = new Voiture("Rouge",120,50);  
  
 
?> 