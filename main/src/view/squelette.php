<?php
	//session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title><?php echo $this->title; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="CSS/style.css" />
</head>
<body>
	<header>
		<nav>
			<ul class="nav">
				<?php 
					echo '<li><a href=' . $this->router->homePage() .'>Accueil</a></li>';
					echo '<li><a href=' . $this->router->getRecetteCreationURL() .'>Ajouter une recette</a></li>';
					echo '<li>LOGO</li>';
					echo '<li><a href='. $this->router->getFormulaireConnexionURL() . '>Se Connecter</a></li>';
				?>
			</ul>
		</nav>
		<h1>Recette de cuisine</h1>
		<form id= "recherche" methode= "GET">
            <input type="text" name="recherche" size= »15 placeholder="Rechercher une recette" required="required">
            <!--<input type="submit" id= "button-submit" name="submit" value="Rechercher">-->
        </form>
	</header>
	<main>
		<div class="content">
			<h2><?php echo $this->title; ?></h2>
			<?php echo $this->content;?>
		</div>
		<div class="footer">
			<p>FOOTER</p>
		</div>
	</main>
	
</body>
</html>
