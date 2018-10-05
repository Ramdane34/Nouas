		<div class="container" style="margin-top:10px">
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
   				<?php
    				//si l'utilisateur est connecté
    				include("../controlleur/isCo.php");
    					if($isCo) {
        					include("../controlleur/isAdmin.php");
						echo "<ul class='navbar-nav'>
							<li class='nav-item active'><a class='nav-link' href='index.php' >Accueil</a></li>
     							<li class='nav-item'><a class='nav-link' href='pagePerso.php' >Mes résultats</a></li>";
							
        						echo "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar'>
    								<span class='navbar-toggler-icon'></span></button>";