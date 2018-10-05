		<div class="container" style="margin-top:10px">
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
   				<?php
					
    				//si l'utilisateur est connecté
    				include("../controlleur/isCo.php");
    					if($isCo) {
        					include("../controlleur/isAdmin.php");
						echo "<ul class='navbar-nav'>";
					// Accueil
					if($pagecharger=="index.php") {
						echo "<li class='nav-item active'><a class='nav-link' href='index.php' >Accueil</a></li>";
					} else {
						echo "<li class='nav-item'><a class='nav-link' href='index.php' >Accueil</a></li>";
					}
 					// Mes résultats
					if($pagecharger=="pagePerso.php") {
						echo "<li class='nav-item active'><a class='nav-link' href='pagePerso.php' >Mes résultats</a></li>";	
					} else {
						echo "<li class='nav-item'><a class='nav-link' href='pagePerso.php' >Mes résultats</a></li>";	
					}
 					// Questionnaires
					if($pagecharger=="questionnaire.php") {
						echo "<li class='nav-item active'><a class='nav-link' href='questionnaire.php'>Questionnaires</a></li>";	
					} else {
						echo "<li class='nav-item'><a class='nav-link' href='questionnaire.php' >Questionnaires</a></li>";	
					}					  
    							
        					echo "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar'>
    							<span class='navbar-toggler-icon'></span></button>";

						if($isAdmin) {
 
							if($pagecharger=="adminIndex.php") {
								echo "<li class='nav-item active'><a class='nav-link' href='adminIndex.php'>Options d'administration</a></li>";	
							} else {
								echo "<li class='nav-item'><a class='nav-link' href='adminIndex.php'>Options d'administration</a></li>";	
							} 
        					}

					echo "<li class='nav-item'><a class='nav-link disabled' href='../../../index.php' >Retour à l'espace personnel</a></li>
						</ul></div>";
    					}
    				?>
			</nav>
		</div>
