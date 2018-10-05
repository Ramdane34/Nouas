<?php
include("../includes/script_maintenance.php");

session_start();
//APPEL BDD
include ('../includes/dbcall.php';
header('content-type: text/html; charset=utf-8');

// CONNEXION
if(!empty($_POST["email"]) AND !empty($_POST["password"])){
		$salt = "m33GT9*PH12*";
		
		$select_account = $bdd->prepare("SELECT id, email, password FROM account WHERE email = ? AND password = ?");
		$select_account->execute(array($_POST["email"], sha1($_POST["password"] .$salt)));
		
		if($select_account->fetch()){
			$select_statut = $bdd->prepare("SELECT * FROM account WHERE email = ? AND statut != 'archive'");
			$select_statut->execute(array($_POST["email"]));
			
			if($select_statut->fetch()){
				$select_infos = $bdd->prepare("SELECT * FROM account WHERE email = ?");
				$select_infos->execute(array($_POST["email"]));
				
				while($show_infos = $select_infos->fetch()){
					$_SESSION["email"] = $_POST["email"];
					$_SESSION["type"] = $show_infos["type"];
					$_SESSION["id"] = $show_infos["id"];
					$_SESSION["root"] = $show_infos["root"];
					$_SESSION["statut"] = $show_infos["statut"];
					if($show_infos["HoNs"] == 1){
						$_SESSION["hero"] = 1;
					}

					//récupération du nom

					$nomAccount = $bdd->prepare("SELECT * FROM account_details WHERE account_id = ?");
					$nomAccount->execute(array
					(
						$_SESSION["id"]
					));
					while($nomCompte = $nomAccount->fetch())
					{
						$_SESSION["nom"] = $nomCompte["nom"];
					}
					$nomAccount->closeCursor();
					$select_infos->closeCursor();
					$select_account->closeCursor();
					$select_statut->closeCursor();
					
					header("location:index.php?connect=true");
					exit();
				}
			}
			else{
				$select_statut->closeCursor();
				header("location:index.php?connect=false&statut=archive");
				exit();
			}
		}
		else{
			$select_account->closeCursor();
			header("location:index.php?connect=false&wrong=" . $_POST["email"]);
			exit();
		}
	
}
else{
	header("location:index.php?connect=false");
	exit();
}
?>