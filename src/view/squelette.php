<?php
//session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<title><?php echo $this->title; ?></title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="CSS/style.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&family=Raleway:wght@600&display=swap" rel="stylesheet">

</head>

<body>
	<header>
		<nav>
			<ul class="nav">
				<?php
				echo '<li><a href="' . $this->router->homePage() . '">Accueil</a></li>';
				echo '<li><a href="' . $this->router->getRecetteCreationURL() . '">Ajouter une recette</a></li>';
				echo '<li class="menu"><a href="#">Compte</a>';
				echo '<ul class="sousMenu">';
				if (key_exists('username', $_SESSION)) {
					if (key_exists('logout', $_POST)) {
						echo '<li><a href="' . $this->router->getConnexionFormURL() . '">Connexion</a></li>';
						echo '<li><a href="' . $this->router->getIncriptionFormURL() . '">Inscription</a></li>';
					} else {
						//a revoir, un utilisateur ayant pour usernam admin peut y avoir accès
						if ($_SESSION['username'] == 'admin') {
							echo '<li><a href="' . $this->router->getAdminURL() . '">Espace administrateur</a></li>';
						}
						echo '<li><a href="' . $this->router->getDeconnexionURL() . '">Deconnexion</a></li>';
					}
				} else {
					echo '<li><a href="' . $this->router->getConnexionFormURL() . '">Connexion</a></li>';
					echo '<li><a href="' . $this->router->getIncriptionFormURL() . '">Inscription</a></li>';
				}
				echo '</ul>';
				?>
			</ul>
		</nav>
		<h1>Kitchy Cootchen</h1>
		<form id="recherche" method="GET">
			<input type="text" name="recherche" size="30" placeholder="Rechercher une recette" required="required">
			<!--<input type="submit" id= "button-submit" name="submit" value="Rechercher">-->
		</form>
	</header>
	<main>
		<div class="content">
			<h2><?php echo $this->title; ?></h2>
			<?php echo $this->content; ?>
		</div>
	</main>
	<footer><?php echo '<a href="' . $this->router->getAProposURL() . '">À propos</a>'; ?></footer>

</body>

</html>
